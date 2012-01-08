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
if($_SERVER['HTTP_HOST'] != 'footprintapp.com' && $_SERVER['HTTP_HOST'] != 'footprintapp.local')
{
	// Redirect to app login
	header('Location: login/');
	exit();
}

require_once ('../app/lib/initialise.php');

// Defaults
$success = false;
$output	 = 'signup'; 

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('msgName'     , 'name'  	   , 'notEmpty');
	SmartyValidate::register_validator('msgEmail'    , 'email'     , 'isEmail');
	SmartyValidate::register_validator('msgUsername' , 'username'  , 'isValid');
	SmartyValidate::register_validator('msgPassword' , 'password'  , 'isStrongPassword');
	SmartyValidate::register_validator('msgCompany'  , 'company'   , 'notEmpty');
	SmartyValidate::register_validator('msgCountry'  , 'country'   , 'notEmpty');
	SmartyValidate::register_validator('msgTimezone' , 'timezone'  , 'notEmpty');
	SmartyValidate::register_validator('msgPrefix1'  , 'prefix'    , 'isValidPrefix', false, true);
	SmartyValidate::register_validator('msgPrefix2'  , 'prefix'    , 'isUniquePrefix');
}
else
{
	SmartyValidate::connect($smarty);
	
	SmartyValidate::register_object('validator'        , $fp->validator);
	SmartyValidate::register_criteria('isValid'        , 'validator->isValidUsername');
	SmartyValidate::register_criteria('isUniquePrefix' , 'validator->isUniquePrefix');
	SmartyValidate::register_criteria('isValidPrefix'  , 'validator->isValidPrefix');
	
	if(SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Clean Values
		$formVars = array();
		foreach($_POST as $fieldName => $fieldValue)
		{
			array_push_associative($formVars, array($fieldName => cleanValue($fieldValue)));
		}
		
		// Create Account
		$accID=$fp->signupBeta($formVars);
		
		// Send Welcome Email
		$subj  = "Welcome to Footprint";
		$user  = html_entity_decode($formVars['email'], ENT_QUOTES);
		
		$email = file_get_contents(APP_ROOT.'/inc/emails/english/signup.welcome.txt');
		
		$email = str_replace('[~name~]'		, $formVars['name']		, $email);
		$email = str_replace('[~username~]' , $formVars['username']	, $email);
		$email = str_replace('[~password~]' , $formVars['password']	, $email);
		$email = str_replace('[~prefix~]'   , $formVars['prefix']	, $email);
	
		$mail = new mailer;
		$mail->from('notifications@footprintapp.com', 'Footprint');
		$mail->add_recipient($user);
		$mail->subject($subj);
		$mail->message($email);
		$result = $mail->send();
		
		// Prepare Auto Login Querystring
		$crypt       = new encryption;
		$encContent  = $crypt->encrypt(ENC_KEY, 'u='.$formVars['username'].'&p='.$formVars['password'], 55);
		$querystring = base64_encode($encContent);
		
		// Redirect to Auto Login Script
		header('Location: http://'.$formVars['prefix'].'.'.$_SERVER['HTTP_HOST'].'/login/auto.php?q='.$querystring);
		exit();
	}
}

// Assign Variables
$smarty->assign('timezone'    , 26);
$smarty->assign('timezones'   , $fp->loadTimezones());
$smarty->assign('success'	  , $success);
$smarty->assign($_POST);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('signup.tpl');

?>