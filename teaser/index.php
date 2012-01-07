<?php

if($_SERVER['HTTP_HOST'] != 'footprintapp.com' && $_SERVER['HTTP_HOST'] != 'footprintapp.local')
{
	// Redirect to app login
	header('Location: login/');
	exit();
}

// Set Error Level (for debugging on hosted server)
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once ('../lib/initialise.php');

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
		$mail->from('info@footprintapp.com', 'Footprint');
		$mail->add_bcc('info@footprintapp.com');
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