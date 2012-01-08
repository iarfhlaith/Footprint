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

// Start
$fp = new footprint;

// Check Querystring Exists
if(!isset($_GET))
{
	header('Location: index.php');
	exit();
}

// Check Parameter Exists
if(!isset($_GET['q']))
{
	header('Location: index.php');
	exit();
}

// Decrypt Parameter
$crypt       = new encryption;
$temp        = base64_decode(str_replace(' ', '+', $_GET['q']));

parse_str($crypt->decrypt(ENC_KEY, $temp), $result);

// Prepare Login Details
$vars = array('account' => $accName, 'username' => $result['u'], 'password' => $result['p']);

// Login User
if($fp->login($vars))
{
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/app/');
	exit();
}

// If fail, redirect to traditional login.
header('Location: index.php');

?>