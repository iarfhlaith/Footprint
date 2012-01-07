<?php

require_once ('lib/initialise.php');

// Defaults
$pName    = 'screenshots';
$size     = 'c';
$output   = $pName;
$paginate = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($pName);

// Authenticate User
$fp->authenticate();

if(!isset($_GET['ajax']))
{
	$paginate = true;
	
	// Start Pagination Plugin
	SmartyPaginate::connect($pName);
	SmartyPaginate::setLimit(PER_PAGE, $pName);
	$fp->setPage($pName);
}

// Filter by task if necessary
$task = $fp->loadFilterID($_GET);

// Check Access and Load Documents
if($fp->checkPermission('all_objects'))
{
	$screenshots = $fp->loadScreenshots($task, '', $size);
	$tasks = $fp->loadAllTasks('', '', false, false);
}
elseif($fp->checkPermission('assigned_objects'))
{
	$screenshots = $fp->loadScreenshots($task, '', $size, true);
	$tasks = $fp->loadAssignedTasks('', '', false, false);	
}
else
{
	$screenshots = $fp->loadScreenshots($task, $_SESSION['user']['userID'], $size);
	$tasks = $fp->loadAllTasks('', $_SESSION['user']['userID'], false, false);	
}

// Delete Screenshots (permission checking for client access is done inside the class method.)
if(!empty($_POST['screenshots']))
{
	$checkClientAccess = false;
	
	if(!$fp->checkPermission('all_objects') || !$fp->checkPermission('assigned_objects')) $checkClientAccess = true;
	
	$fp->screenshot= new screenshot;
	$res=$fp->screenshot->delete($_POST['screenshots'], $checkClientAccess);
	
	$_SESSION['message'] = $fp->validator->loadResponse(true, $res);
	
	// Reset Pagination (if necessary)
	if(count($_POST['screenshots']) >= PER_PAGE)
	{
		SmartyPaginate::disconnect($pName);
	}
		
	// Display Message
	header('Location: screenshots.php');
	exit();
}

// Mark Menu
$smarty->assign('belowScreenshots', true);
$smarty->assign('page'            , array('screenshots' => true));
$smarty->assign('pName'           , $pName);
$smarty->assign('screenshots'     , $screenshots);
$smarty->assign('task'            , $task);
$smarty->assign('tasks'           , $tasks);
$smarty->assign('message'         , $fp->loadMessages());

// Paginate
SmartyPaginate::assign($smarty, 'paginate', $pName);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('screenshots.tpl');

?>