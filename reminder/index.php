<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        index.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Internet Solutions.
 *
 * This software is protected under Irish CopyRight Law.
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