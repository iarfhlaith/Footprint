<?php

require_once ('lib/initialise.php');

// Mark Menu
$smarty->assign('belowHome', true);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('index.tpl');

?>