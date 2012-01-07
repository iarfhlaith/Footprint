<?php

require_once ('lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Authenticate User
$fp->authenticate();

// Mark Menu
$smarty->assign('belowProjects', true);
$smarty->assign('page'         , array('projectTimeline' => true));

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('projectTimeline.tpl');

?>