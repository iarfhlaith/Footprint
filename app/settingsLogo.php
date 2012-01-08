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