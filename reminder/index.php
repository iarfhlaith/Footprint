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
$output     = 'html';
$formName   = 'default';
$page		= 'reminder';

// Start
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page); 

if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('emailValidate', 'email', 'isEmail', false, true);
	SmartyValidate::register_validator('emailCheck'   , 'email:account'   , 'isAccountEmail');
}
else
{
	SmartyValidate::connect($smarty);
	
	SmartyValidate::register_object('validator'        , $fp->validator);
	SmartyValidate::register_criteria('isAccountEmail' , 'validator->isAccountEmail');
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
	
		// Send Reminder
		$fp->setPrefix($accName);
		$fp->remind(cleanValue($_POST['email']));
	}
	
	if(isset($_POST['ajax']))
	{
		$output = 'json';
		$smarty->assign('response', json_encode($fp->validator->loadResponse($valid, true)));
	}
}

// Customise Login Page
$accColour = $fp->loadAccColour($accName);
if(empty($accColour)) $accColour = '#003366';

// Assign Template Variables
$smarty->assign($_POST);
$smarty->assign('text'      , $lang[$page]);
$smarty->assign('valid'     , $valid);
$smarty->assign('account'   , $accName);
$smarty->assign('accColour' , $accColour);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Appropriate Template
$smarty->display($output.'.reminder.tpl');	
?>