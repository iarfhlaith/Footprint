<?php

require_once ('../lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Notes on Authentication
//
// I need to extend the PEAR Auth HTTP Class so that I can perform authentication 
// based on the username, password AND the account name (eg. 'webstrong').
//
// At the moment, only the username and password is checked. So if a user on a different account
// has the same username and password, it will lead to security holes and unexpected behavour.
//
// This is also true for the authentication process within the API.
//

// Authenticate User
$fp->authenticate('http');

// Fetch Recent Activity
$activity = $fp->loadRecentActivity();

// Assign Variables
$smarty->assign('activity', $activity);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('feed.tpl');

?>