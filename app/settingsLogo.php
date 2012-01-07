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
$page	 = 'settingsLogo';
$success = false;
$logo    = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

// Mark Menu
$smarty->assign('belowHome'    , true);
$smarty->assign('settingsLogo' , true);
$smarty->assign('page'         , array('settings' => true));

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
	SmartyValidate::register_validator('logo'     , 'logo'    , 'isMimeType', false, true);
	SmartyValidate::register_validator('logoSize' , 'logo:1m' , 'isFileSize'); 
}
else
{
	SmartyValidate::connect($smarty);
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Clean Form
		if(isset($_FILES["logo"])) $logo = $_FILES["logo"];
		
		// Update Logo
		$success = $fp->updateLogo($logo);
		
		// Reset Smarty Validate
		SmartyValidate::connect($smarty, true);
		SmartyValidate::register_validator('logo'     , 'logo'    , 'isMimeType', false, true);
		SmartyValidate::register_validator('logoSize' , 'logo:1m' , 'isFileSize'); 
	}
	
	// Process Results for Correct Response
	$res = $fp->validator->loadResponse($valid, $success);
	if($res['redirect']) $_SESSION['message'] = $res;
}

// Build List of Accepted MIME Types
$mimeTypes = "image/pjpeg, image/jpeg, image/gif, image/png";

$smarty->assign($_POST);
$smarty->assign('text'      , $lang[$page]);
$smarty->assign('valid'     , $valid);
$smarty->assign('mimeTypes' , $mimeTypes);
$smarty->assign('message'   , $fp->loadMessages());

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('settingsLogo.tpl');

?>