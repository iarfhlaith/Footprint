<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        return.php
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