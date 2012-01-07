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
$success	= false;
$output     = 'html';
$formName   = 'default';
$page		= 'reset';

// Start
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page); 

if(empty($_POST) && empty($_GET))
{
	header('Location: ../reminder/index.php');
	exit();
}

if(empty($_GET)) $_GET = $_POST;

if(isset($_GET['sig']))
{
	$smarty->assign('sig', $_POST['sig']);
	$sig = $_POST['sig'];
}
else
{
	header('Location: ../reminder/index.php');
	exit();
}

if(empty($_POST))
{
	
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('passwordEmpty', 'password1:5'          , 'isLength', false, true);
	SmartyValidate::register_validator('passwordMatch', 'password1:password2'  , 'isEqual');
}
else
{
	SmartyValidate::connect($smarty);
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
	
		// Reset Password
		$fp->reset($_POST['password1'], $sig);
	}
	
	if(isset($_POST['ajax']))
	{
		$output = 'json';
		$smarty->assign('response', json_encode($fp->validator->loadResponse($valid, true)));
	}
}

// Assign Template Variables
$smarty->assign($_POST);
$smarty->assign('text'      , $lang[$page]);
$smarty->assign('valid'     , $valid);
$smarty->assign('account'   , $accName);
$smarty->assign('accColour' , $fp->loadAccColour($accName));

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Appropriate Template
$smarty->display($output.'.reset.tpl');	
?>