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
$smarty->assign('page'     , array('upgrade' => true));

// Assign Variables
$smarty->assign('billInfo' , $fp->loadBillingInfo());
$smarty->assign('cardOpts' , array('Mastercard','Visa','Laser'));

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('upgrade.tpl');

?>