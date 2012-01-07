<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        screenshotView.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Internet Solutions.
 *
 * This software is protected under Irish Copyright Law.
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

require_once ('lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Authenticate User
$fp->authenticate();

// Initialise Variables
$id     = 0;
$type   = 'image/jpeg';
$length = 300; // Any number
$size   = 'c';

// Clean ID Value
if(isset($_GET['id']))
{
	$versionID = cleanValue($_GET['id']);
}
// Clean Size Value
if(isset($_GET['size']))
{
	$size = cleanValue($_GET['size']);
}

// Create Document Object
$fp->screenshot = new screenshot;

// Check Permissions
if($fp->checkPermission('all_objects'))
{
	$ss = $fp->screenshot->loadScreenshotFromVersionID($versionID, $size);
}
elseif($fp->checkPermission('assigned_objects'))
{
	$ss = $fp->screenshot->loadScreenshotFromVersionID($versionID, $size, '', true);
}
else
{
	$ss = $fp->screenshot->loadScreenshotFromVersionID($versionID, $size, $_SESSION['user']['userID']);
}

// Display image if it's found
if(empty($ss['title'])){exit();} else
{
	$type   = $ss['mime'];
	
	if(!empty($ss['data']['info']['content-length']))
	{
		$length = $ss['data']['info']['content-length'];
	}

	// Send Headers & Force Download
	header("Content-type: {$type}");
	header("Content-Length: {$length}");
	echo($ss['data']['contents']);
}
?>