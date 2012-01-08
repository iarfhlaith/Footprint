<?php
/**
 * Footprint
 *
 * A project management tool for web designers.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst. It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package Footprint
 * @author Iarfhlaith Kelly
 * @copyright Copyright (c) 2007 - 2012, Iarfhlaith Kelly. (http://iarfhlaith.com/)
 * @license http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link http://footprintapp.com
 * @since Version 1.0
 * @filesource
 */
require_once ('lib/initialise.php');

// Defaults
$valid    	       = false;
$page	  	       = 'screenshotUpdate';
$output   	       = $page;
$success  	       = false;
$limitExceeded     = false;
$checkClientAccess = false;
$id				   = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

// Check Limits
$stats = $fp->loadAccStats();
if($stats['totDiskSpace'] > $stats['accDiskSpace']) $limitExceeded = true;

if(!empty($_GET)) 		$id = $_GET['id'];
elseif(!empty($_POST))	$id = $_POST['id'];
else
{
	$smarty->display('errorWrongParameters.tpl');
	exit();
}

$fp->screenshot    = new screenshot;
$fp->screenshot->select($id);

// Check Permissions
if($fp->checkPermission('all_objects'))
{
	$ss = $fp->screenshot->loadScreenshot('', false, false);
}
elseif($fp->checkPermission('assigned_objects'))
{
	$ss = $fp->screenshot->loadScreenshot('', true, false);
}
else
{
	$ss = $fp->screenshot->loadScreenshot($_SESSION['user']['userID'], false, false);
}

// Check Project was Found
if(empty($ss['screenshotID']))
{
	$smarty->display('errorNotFound.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowScreenshots', true);
$smarty->assign('page'            , array('screenshotUpdate' => true));

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('access'   , 'access'    		, 'notEmpty');
	SmartyValidate::register_validator('version'  , 'version'    		, 'isNumber');
	SmartyValidate::register_validator('file'     , 'file'				, 'isMimeType', false, true);
	SmartyValidate::register_validator('fileSize' , 'file:15m' 			, 'isFileSize'); 
}
else
{
	SmartyValidate::connect($smarty);
	
	if($valid=SmartyValidate::is_valid($_POST))
	{	
		SmartyValidate::disconnect();
		
		// Check Screenshot Belongs to Account
		if(!$fp->screenshot->belong($_POST['id'], $_SESSION['user']['accID']))
		{
			$smarty->display('errorAccess.tpl');
			exit();
		}
		
		// Clean Values
		$formVars = array(
					    'name' => cleanValue($_POST['name'])
			,			  'id' => cleanValue($_POST['id'])
			,	     'version' => cleanValue($_POST['version'])
			,	      'access' => cleanValue($_POST['access']));
		
		// Create Document Object
		$fp->screenshot = new screenshot;
		$success = $fp->screenshot->update($formVars, $_FILES['file']);
		
		// Update Activity Log
		if($success) $fp->updateActivityLog($page, $formVars['id']);
	}
	
	// Process Results for Correct Response
	$res=$fp->validator->loadResponse($valid, $success);
	
	if($res['redirect'])
	{
		$_SESSION['message'] = $res;
		header('Location: screenshots.php');
		exit();
	}
}

// Assign Variables
$smarty->assign($_POST);
$smarty->assign('text'          , $lang[$page]);
$smarty->assign('screenshot'    , $ss);
$smarty->assign('limitExceeded' , $limitExceeded);
$smarty->assign('imgTypes'	    , 'image/pjpeg, image/jpeg, image/gif, image/png');

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('screenshotUpdate.tpl');

?>