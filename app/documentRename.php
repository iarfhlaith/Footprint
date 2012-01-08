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
$valid    = false;
$page	  = 'documentRename';
$output   = $page;
$success  = false;
$formVars = array();

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

if(empty($_POST) && empty($_GET))
{
	$smarty->display('errorWrongParameters.tpl');
	exit();
}

if(empty($_GET)) $_GET = $_POST;

$fp->doc = new document;
$checkClientAccess = false;

if(!$fp->checkPermission('all_objects')
|| !$fp->checkPermission('assigned_objects')) $checkClientAccess = true;

$docNames = $fp->doc->loadDocsForRename($_GET['documents'], $checkClientAccess);
$smarty->assign('docNames' , $docNames);

if(empty($docNames))
{
	$smarty->display('errorWrongParameters.tpl');
	exit();
}

if(empty($_POST))
{	
	SmartyValidate::connect($smarty, true);
	SmartyValidate::register_validator('documents', 'documents', '@notEmpty');
}
else
{
	SmartyValidate::connect($smarty);
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		$fp->doc = new document;
		SmartyValidate::disconnect();
		
		// Check Docs Belong to Account
		if(!$fp->doc->belong($_POST['documents'], $_SESSION['user']['accID']))
		{
			$smarty->display('errorAccess.tpl');
			exit();
		}
		
		if(!$fp->checkPermission('all_objects') || !$fp->checkPermission('assigned_objects')) $checkClientAccess = true;
		
		foreach($_POST['documents'] as $fieldName => $fieldValue)
		{	
			$success=$fp->doc->rename($fieldName, cleanValue($fieldValue), $checkClientAccess);
			if(!$success) break;
		}
	}
	
	// Process Results for Correct Response
	$res=$fp->validator->loadResponse($valid, $success);
	if($res['redirect']) $_SESSION['message'] = $res;
	
	if(isset($_POST['ajax']))
	{
		$output = 'json';
		$smarty->assign('response',  json_encode($res));
	}
	else
	{
		if($res['redirect'])
		{
			header('Location: '.$res['redirect']);
			exit();
		}
	}
}

// Mark Menu
$smarty->assign('belowDocuments', true);
$smarty->assign('page'          , array('documentRename' => true));

// Assign Variables
$smarty->assign($_POST);
$smarty->assign('text'  , $lang[$page]);
$smarty->assign('valid' , $valid);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');
?>