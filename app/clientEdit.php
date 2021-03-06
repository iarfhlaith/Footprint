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
$page	 = 'clientEdit';
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

// Parse Client ID
$id = 0;
if(isset($_GET['id'])) 		$id = cleanValue($_GET['id']);
elseif(isset($_POST['id']))	$id = cleanValue($_POST['id']);

// Instantiate Client
$fp->client = new client;
$fp->client->select($id);

// Load Client Info 
$client = $fp->client->loadClient();

// Check Client was Found
if(empty($client))
{
	$smarty->display('errorNotFound.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowClients', true);
$smarty->assign('page'        , array('clientEdit' => true));

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('name'      , 'name'              , 'notEmpty');
	SmartyValidate::register_validator('email'     , 'email'             , 'isEmail');
	SmartyValidate::register_validator('passWeak'  , 'newPass1:5'		 , 'isLength'  , true);
	SmartyValidate::register_validator('passDiff'  , 'newPass1:newPass2' , 'isEqual'   , true);
	
	SmartyValidate::register_validator('userValid' , 'username', 'isValid'	    , false, true);
	SmartyValidate::register_validator('userUnique', 'username:'.$fp->getAccID().':'.$id, 'isUnique');
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
			,		'password' => cleanValue($_POST['newPass1'])
			,	'organisation' => cleanValue($_POST['organisation'])
			,		  'userID' => $id
			,          'accID' => $fp->getAccID());
		
		if(isset($_POST['invite'])) array_push_associative($formVars, array('invite' => $_POST['invite']));
		
		// Update Client Object
		$fp->client->setFormVars($formVars);
		$success = $fp->client->update();
		
		// Update Activity Log
		$fp->updateActivityLog('clientEdit');
	}
	else
	{
		$client = $_POST;
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

$smarty->assign($_POST);
$smarty->assign('text'   , $lang[$page]);
$smarty->assign('valid'  , $valid);
$smarty->assign('client' , $client);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');

?>