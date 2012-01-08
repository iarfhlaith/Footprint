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

// Assign Values
if(isset($_GET['id']))
{
	$id = cleanValue($_GET['id']);
}

// Create Screenshot Object
$fp->screenshot = new screenshot;

// Check Permissions
if($fp->checkPermission('all_objects'))
{
	$ss = $fp->screenshot->loadScreenshotFromVersionID($id, 'a');
}
elseif($fp->checkPermission('assigned_objects'))
{
	$ss = $fp->screenshot->loadScreenshotFromVersionID($id, 'a', '', true);
}
else
{
	$ss = $fp->screenshot->loadScreenshotFromVersionID($id, 'a', $_SESSION['user']['userID']);
}

// Check Project was Found
if(empty($ss['screenshotID']))
{
	$smarty->display('errorNotFoundMsg.tpl');
	exit();
}

// Assign Values
$smarty->assign('screenshot', $ss);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('screenshotShow.tpl');

?>