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

// Force Error Level
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'on');

require_once('HTTP/Request.php');

/**
 * All of these calls will work with the API.
 *
 * If there is an authentication error you will get an http response of 401.5 (unauthorised)
 * If there is nothing found in the system that matches your criteria you will get a http response 404 (file not found)
 * If your account does not have permission to access the content you will get a http response of 403 (forbidden)
 *
 * If there was no problems you will get an http response of 200 (ok)
 *
 */

#$url = '/clients/list/'; 
#$url = '/clients/view/?id=1007';
#$url = '/projects/list/';
#$url = '/projects/view/?id=2';

$url = '/projects/list/';

$req = new HTTP_Request('http://webstrong.footprintapp.local/api'.$url);

$req->addHeader('Accept', 'application/xml');
$req->setBasicAuth('iarfhlaith', 'strong4');

$response = $req->sendRequest();

if (PEAR::isError($response))
{
    echo $response->getMessage();
}
else
{	
	header('Content-type: '.$req->getResponseHeader('content-type'));
	echo($req->getResponseBody());
	
	/*
	echo($req->getResponseCode());
	
	foreach($req->getResponseHeader() as $key => $value)
	{
		echo($key.': '.$value.'<br />');
	}
	*/
}

?>