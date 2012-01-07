<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        projectEdit.php
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
$page	 = 'projectEdit';
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
if(!$fp->checkPermission('manage_projects'))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Parse Project ID
$id = 0;
if(isset($_GET['id'])) 		$id = cleanValue($_GET['id']);
elseif(isset($_POST['id']))	$id = cleanValue($_POST['id']);

// Instantiate Project
$fp->project = new project;
$fp->project->select($id);

// Load Project Info 
$project = $fp->project->loadProject();

// Check Project was Found
if(empty($project))
{
	$smarty->display('errorNotFound.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowProjects', true);
$smarty->assign('page'         , array('projectEdit' => true));

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('name'     , 'name'    , 'notEmpty');
	SmartyValidate::register_validator('client'   , 'client:' .$fp->getAccID().':3'   , 'isClient');
	SmartyValidate::register_validator('manager'  , 'manager:'.$fp->getAccID().':2:M' , 'isManager');
}
else
{
	SmartyValidate::connect($smarty);
	
	SmartyValidate::register_object('validator'  , $fp->validator);
	SmartyValidate::register_criteria('isClient' , 'validator->isUserType');
	SmartyValidate::register_criteria('isManager', 'validator->isUserType');
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Clean Values
		$formVars = array(
						'name' => cleanValue($_POST['name'])
			,	 'description' => cleanValue($_POST['description'])
			,		  'client' => cleanValue($_POST['client'])
			,	     'manager' => cleanValue($_POST['manager'])
			,		  'projID' => $id
			,          'accID' => $fp->getAccID());
		
		if(isset($_POST['visibility'])) array_push_associative($formVars, array('visible' => $_POST['visibility']));
		
		// Update Client Object
		$success   = $fp->project->update($formVars);
		
		// Update Activity Log
		$fp->updateActivityLog('projectEdit');
	}
	else
	{
		$project = $_POST;
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
			header('Location: projects.php');
			exit();
		}
	}
}

$smarty->assign($_POST);
$smarty->assign('text'     , $lang[$page]);
$smarty->assign('valid'    , $valid);
$smarty->assign('project'  , $project);
$smarty->assign('clients'  , $fp->loadClients(false, false, false));
$smarty->assign('managers' , $fp->loadManagement());

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');

?>