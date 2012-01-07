<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        documentView.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Ltd.
 *
 * This software is protected under Irish Copyright Law.
 *
 * @link http://www.footprintapp.com/
 * @copyright 2007-2008 Webstrong Ltd
 * @author Iarfhlaith Kelly <ik at webstrong dot ie>
 * @package Footprint
 * @version 1.0
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. http://www.footprintapp.com/forums
 *
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