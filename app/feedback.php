<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        feedback.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Ltd.
 *
 * This software is protected under Irish Copyright Law.
 *
 * @link http://www.footprintapp.com/
 * @copyright 2007-2009 Webstrong Ltd
 * @author Iarfhlaith Kelly <ik at webstrong dot ie>
 * @package Footprint
 * @version 1.0
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. http://www.footprintapp.com/forums
 *
 */

require_once ('lib/initialise.php');

// Defaults
$valid    = false;
$page	  = 'feedback';
$output   = $page;
$success  = false;
$managers = false;
$referrer = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

// Mark Menu
$smarty->assign('belowHome'  , true);
$smarty->assign('page'       , array('feedback' => true));

// Assign referrer (if available)
if(isset($_SERVER['HTTP_REFERER'])) $referrer = cleanValue($_SERVER['HTTP_REFERER']);

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('subject'  , 'subject'  , 'notEmpty');
	SmartyValidate::register_validator('comments' , 'comments' , 'notEmpty');
}
else
{
	SmartyValidate::connect($smarty);
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Clean Values
		$formVars = array(
						'subject' => cleanValue($_POST['subject'])
			,	       'comments' => cleanValue($_POST['comments'])
			,		   'referrer' => cleanValue($_POST['referrer'])
			,		       'user' => $_SESSION['user']);
		
		// Start Feedback
		$fp->feedback = new feedback;
		$fp->feedback->setFormVars($formVars);
		
		// Save Feedback
		$success = $fp->feedback->save();
		
		// Send Receipt (must be called AFTER save() method)
        $fp->feedback->sendReceipt();
		
		// Notify Footprint Support
		$fp->feedback->notify();
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

// Assign Variables
$smarty->assign($_POST);
$smarty->assign('text'     , $lang[$page]);
$smarty->assign('valid'    , $valid);
$smarty->assign('referrer' , $referrer);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');

?>