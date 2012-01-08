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
require_once ('../app/lib/initialise.php');

// Defaults
$no_account = FALSE;
$valid   	= FALSE;
$output  	= 'html';
$page	 	= 'login';

// Start
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);

// Check Account Exists
if(!$fp->accountExists($accName))
{
	$no_account = TRUE;
	
	//$smarty->display('errorNoAccount.tpl');
	//exit();
}

if(empty($_POST))
{	
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('account' , 'account' , 'notEmpty', false);
	SmartyValidate::register_validator('username', 'username', 'notEmpty', false);
	SmartyValidate::register_validator('password', 'password', 'notEmpty', false, true);
	
	SmartyValidate::register_validator('login'   , 'account:username:password', 'login');
}
else
{	
	SmartyValidate::connect($smarty);
	
	SmartyValidate::register_object('fp', $fp);
	SmartyValidate::register_criteria('login', 'fp->loginWrapper');
	
	if($valid=SmartyValidate::is_valid($_POST))
	{		
		SmartyValidate::disconnect();
	}
	
	if(isset($_POST['ajax']))
	{		
		$output = 'json';
		$smarty->assign('response', json_encode($fp->validator->loadResponse($valid, true)));
	}
	elseif($valid)
	{
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/app/');
		exit();
	}
}

// Customise Login Page
$accColour = $fp->loadAccColour($accName);
if(empty($accColour)) $accColour = '#003366';

// Assign Template Variables
$smarty->assign($_POST);
$smarty->assign('text'       , $lang[$page]);
$smarty->assign('valid'      , $valid);
$smarty->assign('account'    , $accName);
$smarty->assign('accColour'  , $accColour);
$smarty->assign('no_account' , $no_account);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.login.tpl');
?>