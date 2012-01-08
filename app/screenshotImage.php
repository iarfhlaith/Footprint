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