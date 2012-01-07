<?php

require_once ('lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Authenticate User
$fp->authenticate();

// Check Access Rights
if(!$fp->checkPermission('manage_account'))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowHome', true);
$smarty->assign('page'     , array('accInfo' => true));

// Assign Variables
$smarty->assign('stats'    , $fp->loadAccStats());
$smarty->assign('payments' , $fp->loadPaymentsReceived());
$smarty->assign('upgrades' , $fp->loadUpgradeList());

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('accInfo.tpl');

?>