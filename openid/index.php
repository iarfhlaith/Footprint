<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        index.php
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

require_once ('../app/lib/initialise.php');

// Defaults
$valid      = false;
$auth		= false;
$output     = 'html';
$formName   = 'default';
$page		= 'openid';
$url		= false;

// Start
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);

if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('openid'        , 'openid_url' , 'notEmpty', false, true);
	SmartyValidate::register_validator('isSystemOpenID', 'openid_url' , 'isSystemOpenID');
}
else
{
	SmartyValidate::connect($smarty);
	
	SmartyValidate::register_object('validator'        , $fp->validator);
	SmartyValidate::register_criteria('isSystemOpenID' , 'validator->isSystemOpenID');
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		$id = cleanValue($_POST['openid_url']);
		
		$openid = new openid;
		$openid->setOpenID($id);
		
		// Include files
		require_once "Auth/OpenID/Consumer.php";
		require_once "Auth/OpenID/FileStore.php";
		
		// Create file storage area for OpenID data
		$store = new Auth_OpenID_FileStore('./openid_store');
		
		// Create OpenID consumer
		$consumer = new Auth_OpenID_Consumer($store);
		
		// Create an authentication request to the OpenID provider
		$auth = $consumer->begin($id);
		
		// Set redirection to OpenID provider for authentication
		if ($auth) $url = $auth->redirectURL('http://'.$_SERVER["SERVER_NAME"], 'http://'.$_SERVER["SERVER_NAME"].'/openid/return.php');
	}
	
	$res=$fp->validator->loadResponse($valid, $auth);
	$res['redirect'] = $url;
	
	if(isset($_POST['ajax']))
	{
		$output = 'json';
		$smarty->assign('response', json_encode($res));
	}
	else
	{
		header('Location: '.$res['redirect']);
		exit();
	}
}

// Assign Template Variables
$smarty->assign($_POST);
$smarty->assign('text'      , $lang[$page]);
$smarty->assign('valid'     , $valid);
$smarty->assign('accColour' , $fp->loadAccColour($accName));

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Appropriate Template
$smarty->display($output.'.openid.tpl');

?>