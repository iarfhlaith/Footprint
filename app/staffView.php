<?php

require_once ('lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Authenticate User
$fp->authenticate();

// Check Access Rights
if(!$fp->checkPermission('staff'))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

$id = 0;

// Clean ID Value
if(isset($_GET['id']))
{
	$id = cleanValue($_GET['id']);
}

// Instantiate Staff
$fp->staff = new staff;
$fp->staff->select($id);

// Load Staff Info 
$staff = $fp->staff->loadStaff();

// Check Staff was Found
if(empty($staff))
{
	$smarty->display('errorNotFound.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowStaff', true);
$smarty->assign('page'      , array('staffView' => true));
$smarty->assign('staff'     , $staff);
$smarty->assign('projects'  , $fp->staff->loadStaffProjects());

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('staffView.tpl');

?>