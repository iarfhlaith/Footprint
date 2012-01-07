<?php

require_once ('../lib/initialise.php');

// Mark Menu
$smarty->assign('belowCases', true);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('cases.tpl');

?>