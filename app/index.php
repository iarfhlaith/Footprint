<?php

require_once ('lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Authenticate User
$fp->authenticate();

// Mark Menu
$smarty->assign('belowHome'  , true);
$smarty->assign('page'       , array('dashboard' => true));

// Assign Variables
$smarty->assign('stats'      , $fp->loadAccStats());
$smarty->assign('topClients' , $fp->loadTopClients());
$smarty->assign('activity'   , $fp->loadRecentActivity());
$smarty->assign('message'    , $fp->loadMessages());

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('index.tpl');

?>