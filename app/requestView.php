<?php

require_once ('lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Authenticate User
$fp->authenticate();

// Initialise Variables
$id = 0;

// Clean ID Value
if(isset($_GET['id']))
{
	$id = cleanValue($_GET['id']);
}

// Create Request Object
$fp->request = new request;
$fp->request->select($id);
	
// Check Access Rights and Load Request
if($fp->checkPermission('all_objects'))
{
	$request = $fp->request->loadRequest();
}
elseif($fp->checkPermission('assigned_objects'))
{
	$request = $fp->request->loadAssignedRequest();	
}
else
{
	$request = $fp->request->loadRequest($_SESSION['user']['userID']);
}

// Check Request was Found
if(empty($request))
{
	$smarty->display('errorNotFound.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowTasks', true);
$smarty->assign('page'      , array('requestView' => true));
$smarty->assign('request'   , $request);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('requestView.tpl');

?>