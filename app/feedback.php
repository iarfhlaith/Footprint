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