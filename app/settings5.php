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
$page	  = 'settings5';
$output	  = $page;
$success  = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

// Instantiate Class
$openID = new openid;
$openID->setAccID($_SESSION['user']['accID']);
$openID->setUserID($_SESSION['user']['userID']);

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	SmartyValidate::register_validator('openid_url'   , 'openid_url', 'notEmpty', false, true);
	SmartyValidate::register_validator('openid_unique', 'openid_url:'.$_SESSION['user']['accID'], 'isUnique');
	
	$smarty->assign('message'    , $fp->loadMessages());
}
else
{	
	SmartyValidate::connect($smarty);
	
	SmartyValidate::register_object('openID'    , $openID);
	SmartyValidate::register_criteria('isUnique', 'openID->isUnique');
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Clean Text
		$newOpenID = cleanValue($_POST['openid_url']);
		
		// Add OpenID
		$openID->setOpenID($newOpenID);
		$success = $openID->attachOpenID();
	}
	
	// Process Results for Correct Response
	$res = $fp->validator->loadResponse($valid, $success);
	$_SESSION['message'] = $res;
	
	if(isset($_POST['ajax']))
	{
		$output = 'json';
		$smarty->assign('response',  json_encode($res));
	}
}

// Mark Menu
$smarty->assign('belowHome'  , true);
$smarty->assign('page'       , array('settings' => true));

// Assign Variables
$smarty->assign('openIDs'    , $openID->loadUsersOpenIDs());
$smarty->assign('settings5'  , true);
$smarty->assign('text'       , $lang[$page]);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');

?>