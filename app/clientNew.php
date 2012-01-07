<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        clientNew.php
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
$valid   = false;
$page	 = 'clientNew';
$output  = $page;
$success = false; 

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

// Check Access Rights
if(!$fp->checkPermission('manage_clients'))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowClients', true);
$smarty->assign('page'        , array('clientNew' => true));

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('name'      , 'name'                     , 'notEmpty');
	SmartyValidate::register_validator('email'     , 'email'                    , 'isEmail');
	SmartyValidate::register_validator('password'  , 'password:5'               , 'isLength'  , true);
	
	SmartyValidate::register_validator('userValid' , 'username', 'isValid'	    , false, true);
	SmartyValidate::register_validator('userUnique', 'username:'.$fp->getAccID(), 'isUnique');
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
			,		'password' => cleanValue($_POST['password'])
			,	'organisation' => cleanValue($_POST['organisation'])
			,		  'invite' => cleanValue($_POST['invite'])
			,          'accID' => $fp->getAccID());
		
		// Create Client Object
		$fp->client = new client;
		$fp->client->setFormVars($formVars);
		$success = $fp->client->create();
		
		// Update Activity Log
		$fp->updateActivityLog('clientNew');
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
			header('Location: clients.php');
			exit();
		}
	}
}

// Assign Variables
$smarty->assign($_POST);
$smarty->assign('text'  , $lang[$page]);
$smarty->assign('valid' , $valid);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');
?>