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
 * @copyright 2007-2008 Webstrong Ltd
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
$no_account = FALSE;
$valid   	= FALSE;
$output  	= 'html';
$page	 	= 'login';

// Start
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);

// Check Account Exists
if(!$fp->accountExists($accName))
{
	$no_account = TRUE;
	
	//$smarty->display('errorNoAccount.tpl');
	//exit();
}

if(empty($_POST))
{	
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('account' , 'account' , 'notEmpty', false);
	SmartyValidate::register_validator('username', 'username', 'notEmpty', false);
	SmartyValidate::register_validator('password', 'password', 'notEmpty', false, true);
	
	SmartyValidate::register_validator('login'   , 'account:username:password', 'login');
}
else
{	
	SmartyValidate::connect($smarty);
	
	SmartyValidate::register_object('fp', $fp);
	SmartyValidate::register_criteria('login', 'fp->loginWrapper');
	
	if($valid=SmartyValidate::is_valid($_POST))
	{		
		SmartyValidate::disconnect();
	}
	
	if(isset($_POST['ajax']))
	{		
		$output = 'json';
		$smarty->assign('response', json_encode($fp->validator->loadResponse($valid, true)));
	}
	elseif($valid)
	{
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/app/');
		exit();
	}
}

// Customise Login Page
$accColour = $fp->loadAccColour($accName);
if(empty($accColour)) $accColour = '#003366';

// Assign Template Variables
$smarty->assign($_POST);
$smarty->assign('text'       , $lang[$page]);
$smarty->assign('valid'      , $valid);
$smarty->assign('account'    , $accName);
$smarty->assign('accColour'  , $accColour);
$smarty->assign('no_account' , $no_account);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.login.tpl');
?>