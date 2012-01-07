<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        documentUpdate.php
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
$valid    	   = false;
$page	  	   = 'documentUpdate';
$output   	   = $page;
$success  	   = false;
$limitExceeded = false;

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

$docName = $fp->doc->loadDocNames($_GET['id'], $checkClientAccess);
$smarty->assign('docName', $docName);

// Check Limits
$stats = $fp->loadAccStats();
if($stats['totDiskSpace'] > $stats['accDiskSpace']) $limitExceeded = true;

// Mark Menu
$smarty->assign('belowDocuments', true);
$smarty->assign('page'          , array('documentUpdate' => true));

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('access'   , 'access'    		, 'notEmpty');
	SmartyValidate::register_validator('version'  , 'version'    		, 'isNumber');
	SmartyValidate::register_validator('file'     , 'file'    			, 'notFileEmpty', false, true);
	SmartyValidate::register_validator('fileSize' , 'file:15m' 			, 'isFileSize'); 
}
else
{
	SmartyValidate::connect($smarty);
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		//Check Docs Belong to Account
		if(!$fp->doc->belong($_POST['id'], $_SESSION['user']['accID']))
		{
			$smarty->display('errorAccess.tpl');
			exit();
		}
		
		// Clean Values
		$formVars = array(
					 'comment' => cleanValue($_POST['comment'])
			,			  'id' => cleanValue($_POST['id'])
			,	     'version' => cleanValue($_POST['version'])
			,	      'access' => cleanValue($_POST['access']));
		
		// Create Document Object
		$fp->doc = new document;
		$success = $fp->doc->update($formVars, $_FILES['file']);
		
		// Update Activity Log
		if($success) $fp->updateActivityLog($page, $formVars['id']);
	}
	
	// Process Results for Correct Response
	$res=$fp->validator->loadResponse($valid, $success);
	
	if($res['redirect'])
	{
		$_SESSION['message'] = $res;
		header('Location: documents.php');
		exit();
	}
}

// Assign Variables
$smarty->assign($_POST);
$smarty->assign('text'          , $lang[$page]);
$smarty->assign('limitExceeded' , $limitExceeded);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('documentUpdate.tpl');

?>