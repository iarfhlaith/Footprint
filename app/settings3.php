<?php

require_once ('lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Authenticate User
$fp->authenticate();

// Check Access Rights
if(!$fp->checkPermission('manage_import_export'))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowHome'  , true);
$smarty->assign('settings3'  , true);
$smarty->assign('page'       , array('settings' => true));

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('settings3.tpl');

?>