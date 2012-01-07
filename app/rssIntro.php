<?php

require_once ('lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Authenticate User
$fp->authenticate();

// Check Access Rights
if(!$fp->checkPermission('activity_feed'))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowHome'  , true);
$smarty->assign('page'       , array('rssIntro' => true));

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('rssIntro.tpl');

?>