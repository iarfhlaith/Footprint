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

// Default values
$error = false;

// Start
$fp = new footprint;

if(!empty($_GET))
{
	// Include files
	require_once "Auth/OpenID/Consumer.php";
	require_once "Auth/OpenID/FileStore.php";
	
	// Create file storage area for OpenID data
	$store = new Auth_OpenID_FileStore('./openid_store');
	
	// Read response from OpenID provider
	$consumer = new Auth_OpenID_Consumer($store);
	$response = $consumer->complete('http://'.$_SERVER['SERVER_NAME'].'/openid/return.php');
	
	// Login User
	if ($response->status == Auth_OpenID_SUCCESS)
	{
	  // Login User based on their OpenID
	  if($fp->loginByOpenID($_SESSION['user']['openID'], $accName))
	  {
	  	header('Location: http://'.$_SERVER['HTTP_HOST'].'/app/');
		exit();
	  }
	  else
	  {
	  	$error = array('Login failed. Please try again.');
	  }
	} 
	else
	{	
	  $error = array('Authentication failed. Please try again.');
	}
}
else
{
	$error = array('Some parameters were missing. Please try again.');
}

// Assign Template Variables
$smarty->assign('error'     , $error);
$smarty->assign('accColour' , $fp->loadAccColour($accName));

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Appropriate Template
$smarty->display('html.openid.return.tpl');

?>