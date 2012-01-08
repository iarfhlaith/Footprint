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
$type   = 'text/plain';
$length = 300; 

// Clean ID Value
if(isset($_GET['id']))
{
	$versionID = cleanValue($_GET['id']);
}

// Create Document Object
$fp->doc = new document;

// Check Permissions
if($fp->checkPermission('all_objects'))
{
	$doc = $fp->doc->loadDocFromVersionID($versionID);
}
elseif($fp->checkPermission('assigned_objects'))
{
	$doc = $fp->doc->loadDocFromVersionID($versionID, '', true);
}
else
{
	$doc = $fp->doc->loadDocFromVersionID($versionID, $_SESSION['user']['userID']);
}

// Check Document was Found
if(empty($doc['title']))
{
	$smarty->display('errorNotFound.tpl');
	exit();
}
// Check Docs Belong to Account
elseif(!$fp->doc->belong($versionID, $_SESSION['user']['accID'], true))
{
	$smarty->display('errorAccess.tpl');
	exit();
}
else
{
	$type   = $doc['mime'];
	
	if(!empty($doc['data']['info']['content-length']))
	{
		$length = $doc['data']['info']['content-length'];
	}

	// Send Headers & Force Download
	header("Content-type: {$type}");
	header('Content-Disposition: attachment; filename="'.html_entity_decode($doc['title'], ENT_QUOTES).'.'.$doc['docType'].'"');
	header("Content-Length: {$length}");
	echo($doc['data']['contents']);
}
?>