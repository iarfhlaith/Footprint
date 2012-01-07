<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        screenshotNew.php
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
$page	  	   = 'screenshotNew';
$output   	   = $page;
$success  	   = false;
$managers 	   = false;
$limitExceeded = false;
$cid	 	   = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

// Check Limits
$stats = $fp->loadAccStats();
if($stats['totDiskSpace'] > $stats['accDiskSpace']) $limitExceeded = true;

// Pre select Client
if(isset($_GET['cid'])) $cid = cleanValue($_GET['cid']);

// Check Access and Load Projects
if($fp->checkPermission('all_objects'))
{
	$projects = $fp->loadAllProjects($cid, false, false);	
}
elseif($fp->checkPermission('assigned_objects'))
{
	$projects = $fp->loadAssignedProjects($cid, false, false);	
}
else
{
	$projects = $fp->loadAllProjects($_SESSION['user']['userID'], false, false);	
}

// Mark Menu
$smarty->assign('belowScreenshots', true);
$smarty->assign('page'            , array('screenshotNew' => true));

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('name'     , 'name'     			, 'notEmpty');
	SmartyValidate::register_validator('project'  , 'project'  			, 'isNumber');
	SmartyValidate::register_validator('task'     , 'task:newTaskName'  , 'notBothEmpty');
	SmartyValidate::register_validator('access'   , 'access'    		, 'notEmpty');
	SmartyValidate::register_validator('file'     , 'file'				, 'isMimeType', false, true);
	SmartyValidate::register_validator('fileSize' , 'file:15m' 			, 'isFileSize'); 
}
else
{
	SmartyValidate::connect($smarty);
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Clean Values
		$formVars = array(
						'name' => cleanValue($_POST['name'])
			,		 'project' => cleanValue($_POST['project'])
			,		    'task' => cleanValue($_POST['task'])
			,	 'newTaskName' => cleanValue($_POST['newTaskName'])
			,	      'access' => cleanValue($_POST['access']));
		
		// Create Document Object
		$fp->screenshot = new screenshot;
		$newID = $fp->screenshot->save($formVars, $_FILES['file']);
		if(is_numeric($newID)) $success = true;
		
		// Update Activity Log
		if($success) $fp->updateActivityLog('screenshotNew', $newID);
	}
	
	// Process Results for Correct Response
	$res=$fp->validator->loadResponse($valid, $success);
	
	if($res['redirect'])
	{
		$_SESSION['message'] = $res;
		header('Location: screenshots.php');
		exit();
	}
}

// Assign Variables
$smarty->assign($_POST);
$smarty->assign('text'          , $lang[$page]);
$smarty->assign('projects'      , $projects);
$smarty->assign('limitExceeded' , $limitExceeded);
$smarty->assign('imgTypes'	    , 'image/pjpeg, image/jpeg, image/gif, image/png');

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('screenshotNew.tpl');
?>