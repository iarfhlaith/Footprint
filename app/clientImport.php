<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        clientImport.php
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
$page	 = 'clientImport';
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
	$smarty->display('errorAccess');
	exit();
}

// Mark Menu
$smarty->assign('belowClients', true);
$smarty->assign('page'        , array('clientImport' => true));

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('type'      , 'type'    	 , 'notEmpty');
	SmartyValidate::register_validator('file'      , 'file'    	 , 'notFileEmpty', false, true);
	SmartyValidate::register_validator('fileSize'  , 'file:15m'  , 'isFileSize'  , false, true);
	SmartyValidate::register_validator('fileFormat', 'file:type' , 'isFormat');
}
else
{
	SmartyValidate::connect($smarty);
	
	SmartyValidate::register_object('validator'  , $fp->validator);
	SmartyValidate::register_criteria('isFormat' , 'validator->isCorrectClientImportFormat');
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Clean Value
		$type = cleanValue($_POST['type']);
		
		// Import Clients
		$fp->client = new client;
		
		$success = $fp->client->import($_FILES['file'], $fp->getAccID(), $type);

		// Update Activity Log
		if($success) $fp->updateActivityLog('clientImport');
	}
	
	// Process Results for Correct Response
	$res=$fp->validator->loadResponse($valid, $success);
	if($res['redirect']) $_SESSION['message'] = $res;
	
	if($res['redirect'])
	{
		header('Location: clients.php');
		exit();
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