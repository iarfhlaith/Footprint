<?php

/**
 * Project:     Footprint - Business Collaboration for Web Designers
 * File:        settings5.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Ltd.
 *
 * This software is protected under Irish Copyright Law.
 *
 * @link http://www.footprintapp.com/
 * @copyright 2007-2009 Webstrong Ltd
 * @author Iarfhlaith Kelly <ik at webstrong dot ie>
 * @package Footprint
 * @version 1.0
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. http://www.footprintapp.com/forums
 *
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