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
$page	 = 'staffEdit';
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
if(!$fp->checkPermission('staff'))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Parse Staff ID
$id = 0;
if(isset($_GET['id'])) 		$id = cleanValue($_GET['id']);
elseif(isset($_POST['id']))	$id = cleanValue($_POST['id']);

// Instantiate Staff
$fp->staff = new staff;
$fp->staff->select($id);

// Load Staff Info 
$staff = $fp->staff->loadStaff();

// Check Staff was Found
if(empty($staff))
{
	$smarty->display('errorNotFound.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowStaff', true);
$smarty->assign('page'      , array('staffEdit' => true));

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('name'     , 'name'              , 'notEmpty');
	SmartyValidate::register_validator('email'    , 'email'             , 'isEmail');

	SmartyValidate::register_validator('passWeak' , 'newPass1:5'		, 'isLength'  , true);
	SmartyValidate::register_validator('passDiff' , 'newPass1:newPass2'	, 'isEqual'   , true);
	
	SmartyValidate::register_validator('userValid' , 'username'			, 'isValid'	    , false, true);
	SmartyValidate::register_validator('userUnique', 'username:'.$fp->getAccID().':'.$staff['userID'], 'isUnique');
}
else
{
	SmartyValidate::connect($smarty);
	
	SmartyValidate::register_object('validator' , $fp->validator);
	
	SmartyValidate::register_criteria('isValid' 		 , 'validator->isValidUsername');
	SmartyValidate::register_criteria('isUnique'		 , 'validator->isUniqueUsername');
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Clean Values
		$formVars = array(
						'name' => cleanValue($_POST['name'])
			,		   'email' => cleanValue($_POST['email'])
			,		'username' => cleanValue($_POST['username'])
			,		'password' => $_POST['newPass1']
			,		  'userID' => $staff['userID']
			,          'accID' => $fp->getAccID());
		
		if(isset($_POST['invite']))        array_push_associative($formVars, array('invite'        => $_POST['invite']));
		if(isset($_POST['access']))        array_push_associative($formVars, array('access'        => $_POST['access']));
		if(isset($_POST['defaultAccess'])) array_push_associative($formVars, array('defaultAccess' => $_POST['defaultAccess']));
		
		// Update Staff Object
		$fp->staff->setFormVars($formVars);
		$success = $fp->staff->update();
		
		// Update Activity Log
		$fp->updateActivityLog('staffEdit');
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
			header('Location: staff.php');
			exit();
		}
	}
}

// Assign Variables
$smarty->assign($_POST);
$smarty->assign('text'          , $lang[$page]);
$smarty->assign('valid'         , $valid);
$smarty->assign('staff'     	, $staff);
$smarty->assign('staffProjects' , $fp->staff->loadStaffProjects());
$smarty->assign('projects'      , $fp->loadAllProjects('', false, false));

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');
?>