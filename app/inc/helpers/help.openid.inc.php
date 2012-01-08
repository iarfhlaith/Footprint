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