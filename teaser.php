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

// Set Error Level (for debugging on hosted server)
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once ('lib/initialise.php');

// Defaults
$valid   = false;
$success = false;
$output	 = 'teaser'; 

// Set Teaser Settings
$smarty->template_dir = WEB_ROOT.'/teaser/tpl';
$smarty->compile_dir  = WEB_ROOT.'/teaser/tpl_c';
require_once (APP_ROOT.'/inc/classes/class.teaser.inc.php');

/////////////////////////////////////////////////////////////////////////////////////

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);
	
	SmartyValidate::register_validator('firstnameWarning'   , 'firstname'  , 'notEmpty');
	SmartyValidate::register_validator('lastnameWarning'    , 'lastname'   , 'notEmpty');
	SmartyValidate::register_validator('emailWarning'  		, 'email'      , 'isEmail');
}
else
{
	SmartyValidate::connect($smarty);
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Clean Values
		$formVars = array(
						'firstname' => cleanValue($_POST['firstname'])
			,		     'lastname' => cleanValue($_POST['lastname'])
			,		        'email' => cleanValue($_POST['email']));
		
		// Save Person's Details
		$person  = new teaser;
		$success = $person->save($formVars);
		
		// Send Email
		$mail = new mailer;
		$mail->from('Footprint', 'info@footprintapp.com');
		$mail->add_bcc('e-mail@iarfhlaith.com');
		$mail->add_recipient($_POST['email']);
		$mail->subject('Footprint - Thanks for Your Interest');
		$mail->message("Hi ".$formVars['firstname'].",
		
Thanks for your interest in Footprint.
		
We're not quite ready to hand out invites yet, but when we are we'll send one to this email address.

Thanks for waiting. It'll totally be worth it.
		
If you've got a question that just can't wait, then you can email us at: info@footprintapp.com.");
		
		$success=$mail->send();
	}
}

// Assign Variables
$smarty->assign($_POST);
$smarty->assign('success', $success);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('teaser.tpl');

?>