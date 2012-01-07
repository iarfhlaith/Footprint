<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        taskEdit.php
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
$page	 = 'requestEdit';
$output  = $page;
$success = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

if(!$fp->checkPermission('make_requests'))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Parse Request ID
$id = 0;
if(isset($_GET['id'])) 		$id = cleanValue($_GET['id']);
elseif(isset($_POST['id']))	$id = cleanValue($_POST['id']);

// Instantiate Request
$fp->request = new request;
$fp->request->select($id);

// Check Access Rights and Load Request
if($fp->checkPermission('all_objects'))
{
	$request = $fp->request->loadRequest();
}
elseif($fp->checkPermission('assigned_objects'))
{
	$request = $fp->request->loadAssignedRequest();	
}
else
{
	$request = $fp->request->loadRequest($_SESSION['user']['userID']);
}

// Check Request was Found
if(empty($request))
{
	$smarty->display('errorNotFound.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowTasks', true);
$smarty->assign('page'      , array('requestEdit' => true));

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('title'   , 'title'   , 'notEmpty');
	SmartyValidate::register_validator('project' , 'project' , 'notEmpty');
}
else
{
	SmartyValidate::connect($smarty);
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Clean Values
		$formVars = array(
					   'title' => cleanValue($_POST['title'])
			,	 'description' => cleanValue($_POST['description'])
			,		 'project' => cleanValue($_POST['project'])
			,	   'requestID' => $id
			,		 'manager' => $fp->getUserID());
		
		// Create Request Object
		$fp->request = new request;
		$success     = $fp->request->update($formVars);
		
		// Update Activity Log
		$fp->updateActivityLog('requestEdit');
	}
	else
	{
		$request = $_POST;
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
			header('Location: requests.php');
			exit();
		}
	}
}

// Assign Variables
$smarty->assign($_POST);
$smarty->assign('text'      , $lang[$page]);
$smarty->assign('valid'     , $valid);
$smarty->assign('projects'  , $fp->loadAllProjects($_SESSION['user']['userID'], false, false));
$smarty->assign('request'   , $request);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');

?>