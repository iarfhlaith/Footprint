<?php

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