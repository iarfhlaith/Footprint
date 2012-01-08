<?php
/**
 * Footprint
 *
 * A project management tool for web designers.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst. It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package Footprint
 * @author Iarfhlaith Kelly
 * @copyright Copyright (c) 2007 - 2012, Iarfhlaith Kelly. (http://iarfhlaith.com/)
 * @license http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link http://footprintapp.com
 * @since Version 1.0
 * @filesource
 */
require_once ('lib/initialise.php');

// Defaults
$valid   = false;
$page	 = 'projectNew';
$output  = $page;
$success = false;
$cid	 = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

// Check Access Rights
if(!$fp->checkPermission('create_projects'))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowProjects', true);
$smarty->assign('page'         , array('projectNew' => true));

// Check Account Limits
if(!$fp->checkLimits('projects'))
{
	$smarty->assign('type', 'projects');
	$smarty->display('errorLimit.tpl');
	exit();
}

// Pre select Client
if(isset($_GET['cid'])) $smarty->assign('client', cleanValue($_GET['cid']));

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
		
		// Load staff that have default access
		$fp->staff      = new staff;
		$accessCtrlList = $fp->staff->loadStaffWithDefaultAccess($fp->getAccID());
		
		// Clean Values
		$formVars = array(
						'name' => cleanValue($_POST['name'])
			,	 'description' => cleanValue($_POST['description'])
			,		  'client' => cleanValue($_POST['client'])
			,		 'visible' => cleanValue($_POST['visible'])
			,	     'manager' => cleanValue($_POST['manager'])
			,  'defaultAccess' => $accessCtrlList
			,          'accID' => $fp->getAccID());
		
		// Create Project Object
		$fp->project = new project;
		$success     = $fp->project->create($formVars);
		
		// Update Activity Log
		$fp->updateActivityLog('projectNew');
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

// Load Managers (Staff and Designer)
$managers = $fp->loadManagement();

// Load Clients
$clients  = $fp->loadClients(false, false, false);

// Assign Variables
$smarty->assign($_POST);
$smarty->assign('text'     , $lang[$page]);
$smarty->assign('valid'    , $valid);
$smarty->assign('clients'  , $clients);
$smarty->assign('managers' , $managers);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');

?>