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

// Create Project Object
$fp->project = new project;
$fp->project->select($id);
	
// Check Access Rights and Load Project
if($fp->checkPermission('all_objects'))
{
	$project = $fp->project->loadProject();
}
elseif($fp->checkPermission('assigned_objects'))
{
	$project = $fp->project->loadAssignedProject();	
}
else
{
	$project = $fp->project->loadProject($_SESSION['user']['userID']);
}

// Check Project was Found
if(empty($project))
{
	$smarty->display('errorNotFound.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowProjects', true);
$smarty->assign('page'         , array('projectView' => true));
$smarty->assign('project'      , $project);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('projectView.tpl');

?>