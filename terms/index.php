<?php

require_once ('../lib/initialise.php');

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('terms.tpl');

?>