<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        settings2.php
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
$page	 = 'settings2';
$output  = $page;
$success = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

// Mark Menu
$smarty->assign('belowHome' , true);
$smarty->assign('settings2' , true);
$smarty->assign('page'      , array('settings' => true));
$smarty->assign('message'   , $fp->loadMessages());

// Check Access Rights
if(!$fp->checkPermission('manage_colours_logos'))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('style', 'style', 'notEmpty');
}
else
{
	SmartyValidate::connect($smarty);
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Clean Form
		$style = cleanValue($_POST["style"]);
		
		// Update Settings
		$success = $fp->updateColours($style);
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
			header('Location: settings2.php');
			exit();
		}
	}
}

$smarty->assign($_POST);
$smarty->assign('text'  , $lang[$page]);
$smarty->assign('valid' , $valid);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');

?>