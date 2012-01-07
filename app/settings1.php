<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        settings1.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Internet Solutions.
 *
 * This software is protected under Irish Copyright Law.
 *
 * @link http://www.footprinthq.com/
 * @copyright 2007-2008 Webstrong Internet Solutions
 * @author Iarfhlaith Kelly <ik at webstrong dot net>
 * @package Footprint
 * @version 1.0
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. http://www.footprinthq.com/forums
 *
 */

require_once ('lib/initialise.php');

// Defaults
$valid   = false;
$page	 = 'settings1';
$output  = $page;
$success = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

// Mark Menu
$smarty->assign('belowHome' , true);
$smarty->assign('settings1' , true);
$smarty->assign('page'      , array('settings' => true));
$smarty->assign('message'   , $fp->loadMessages());

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('name'       , 'name'                     , 'notEmpty');
	SmartyValidate::register_validator('email'      , 'email'                    , 'isEmail');
	SmartyValidate::register_validator('password'   , 'password:5'               , 'isLength'  , true, true);
	SmartyValidate::register_validator('confirm'    , 'password:confirm'         , 'isEqual'   , true);
	SmartyValidate::register_validator('userValid'  , 'username'                 , 'isValid'   , false, true);
	SmartyValidate::register_validator('userUnique' , 'username:'.$fp->getAccID().':'.$fp->getUserID(), 'isUnique');
}
else
{
	SmartyValidate::connect($smarty);
	
	SmartyValidate::register_object('validator' , $fp->validator);
	SmartyValidate::register_criteria('isValid' , 'validator->isValidUsername');
	SmartyValidate::register_criteria('isUnique', 'validator->isUniqueUsername');
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Clean Values
		$formVars = array(
						'name' => cleanValue($_POST['name'])
			,		   'email' => cleanValue($_POST['email'])
			,		'username' => cleanValue($_POST['username'])
			,		'password' => $_POST['password']
			,         'userID' => $fp->getUserID());
		
		if($_SESSION['user']['groupName'] != 'Staff')
		{
			array_push_associative($formVars, array('organisation' => cleanValue($_POST['organisation'])));
		}
		
		if($_SESSION['user']['groupName'] == 'Designer')
		{
			array_push_associative($formVars, array('timezone' => cleanValue($_POST['timezone'])));
		}
		
		// Update User Details
		$success = $fp->updateProfile($formVars, $_SESSION['user']['groupName']);
	}
	
	// Process Results for Correct Response
	$res=$fp->validator->loadResponse($valid, $success);
	if($res['redirect']) $_SESSION['message'] = $res;
	
	if(isset($_POST['ajax']))
	{
		$output = 'json';
		$smarty->assign('response', json_encode($res));
	}
	else
	{
		if($res['redirect'])
		{
			header('Location: settings1.php');
			exit();
		}
	}
}

if($_SESSION['user']['groupName'] == 'Client')
	 $org = $_SESSION['user']['clientOrganisation'];
else $org = $_SESSION['user']['organisation'];

// Original Form Values
$smarty->assign('organisation', $org);
$smarty->assign('name'        , $_SESSION['user']['firstname'].' '.$_SESSION['user']['lastname']);
$smarty->assign('email'       , $_SESSION['user']['email']);
$smarty->assign('username'    , $_SESSION['user']['username']);

if($_SESSION['user']['groupName'] == 'Designer')
{
	$smarty->assign('timezone'    , $_SESSION['user']['tzID']);
	$smarty->assign('timezones'   , $fp->loadTimezones());
}

// Assign Variables
$smarty->assign($_POST);
$smarty->assign('text'        , $lang[$page]);
$smarty->assign('valid'       , $valid);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');

?>