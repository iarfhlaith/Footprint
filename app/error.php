<?php

require_once ('lib/initialise.php');

// Defaults
$link = false;

// Determine Referring Page
if(isset($_SERVER['HTTP_REFERER']))
{
	$link = $_SERVER['HTTP_REFERER'];
}

// Assign Variables
$smarty->assign('link' , $link);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('errorDb.tpl');

?>