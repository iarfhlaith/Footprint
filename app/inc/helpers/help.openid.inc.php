<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        help.openid.inc.php
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

/////////////////////////////////////////////////////////////////////////////////////////////////////
function tryAuth($openID)
{
	// Require the OpenID consumer code.
    require_once "Auth/OpenID/Consumer.php";
	
	// Require the Simple Registration extension API.
    require_once "Auth/OpenID/SReg.php";
	
	$consumer = new Auth_OpenID_Consumer();
	
	// Begin the OpenID authentication process.
    $authRequest = $consumer->begin($openID);
	
	if (!$authRequest) return(false);
	
	// Setup a Simple Registration Request
	$sRegRequest = Auth_OpenID_SRegRequest::build(array('nickname'), array('fullname', 'email'));
	
	if ($sRegRequest) $authRequest->addExtension($sRegRequest);
	
	// Redirect user to their OpenID provider
	if ($auth_request->shouldSendRedirect())
	{
        $redirect_url = $auth_request->redirectURL(OPENID_ROOT, OPENID_ROOT.'');
		
		//Continue here...
	}

	
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////

?>