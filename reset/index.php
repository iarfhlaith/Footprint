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
$valid      = false;
$success	= false;
$output     = 'html';
$formName   = 'default';
$page		= 'reset';

// Start
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page); 

if(empty($_POST) && empty($_GET))
{
	header('Location: ../reminder/index.php');
	exit();
}

if(empty($_GET)) $_GET = $_POST;

if(isset($_GET['sig']))
{
	$smarty->assign('sig', $_POST['sig']);
	$sig = $_POST['sig'];
}
else
{
	header('Location: ../reminder/index.php');
	exit();
}

if(empty($_POST))
{
	
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('passwordEmpty', 'password1:5'          , 'isLength', false, true);
	SmartyValidate::register_validator('passwordMatch', 'password1:password2'  , 'isEqual');
}
else
{
	SmartyValidate::connect($smarty);
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
	
		// Reset Password
		$fp->reset($_POST['password1'], $sig);
	}
	
	if(isset($_POST['ajax']))
	{
		$output = 'json';
		$smarty->assign('response', json_encode($fp->validator->loadResponse($valid, true)));
	}
}

// Assign Template Variables
$smarty->assign($_POST);
$smarty->assign('text'      , $lang[$page]);
$smarty->assign('valid'     , $valid);
$smarty->assign('account'   , $accName);
$smarty->assign('accColour' , $fp->loadAccColour($accName));

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Appropriate Template
$smarty->display($output.'.reset.tpl');	
?>