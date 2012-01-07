<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        taskNew.php
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
$valid    = false;
$page	  = 'taskNew';
$output   = $page;
$success  = false;
$managers = false;
$cid	 = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

// Check Access Rights
if(!$fp->checkPermission('create_tasks'))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowTasks' , true);
$smarty->assign('page'       , array('taskNew' => true));

// Pre select Client
if(isset($_GET['cid'])) $cid = cleanValue($_GET['cid']);

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('task'    , 'task'    , 'notEmpty');
	SmartyValidate::register_validator('project' , 'project' , 'notEmpty');
}
else
{
	SmartyValidate::connect($smarty);
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Determine Manager
		if(isset($_POST['manager'])) $manager = cleanValue($_POST['manager']); else $manager = $fp->getUserID();
		
		// Clean Values
		$formVars = array(
						'task' => cleanValue($_POST['task'])
			,	 'description' => cleanValue($_POST['description'])
			,		 'project' => cleanValue($_POST['project'])
			,		 'manager' => $manager
			,		  'status' => cleanValue($_POST['status']));
		
		// Create Task Object
		$fp->task = new task;
		$success  = $fp->task->create($formVars);
		
		// Update Activity Log
		$fp->updateActivityLog('taskNew');
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
			header('Location: '.$res['redirect']);
			exit();
		}
	}
}

// Load Correct Project and Management Lists
if($fp->checkPermission('all_objects'))
{
	$projects = $fp->loadAllProjects($cid, false, false);
	$managers = $fp->loadManagement();
}
elseif($fp->checkPermission('assigned_objects'))
{
	$projects = $fp->loadAssignedProjects($cid, false, false);
}

// Assign Variables
$smarty->assign($_POST);
$smarty->assign('text'     , $lang[$page]);
$smarty->assign('valid'    , $valid);
$smarty->assign('projects' , $projects);
$smarty->assign('managers' , $managers);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');

?>