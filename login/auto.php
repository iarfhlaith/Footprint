<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        auto.php
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