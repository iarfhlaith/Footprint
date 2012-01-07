<?php

require_once ('lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Authenticate User
$fp->authenticate();

// Check Access Rights
if(!$fp->checkPermission('manage_api'))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

if(!empty($_POST))
{
	if($_POST['action'] == 'on')
	{
		$fp->setApiStatus(1);
	}
	if($_POST['action'] == 'off')
	{
		$fp->setApiStatus(0);
	}
}

// Mark Menu
$smarty->assign('belowHome'  , true);
$smarty->assign('settings4'  , true);
$smarty->assign('page'       , array('settings' => true));

// Assign Variables
$smarty->assign('apiStatus'  , $fp->loadApiStatus());

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('settings4.tpl');

?>