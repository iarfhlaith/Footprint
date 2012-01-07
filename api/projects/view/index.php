<?php

// Initialise Footprint & API Code
require_once('../../../app/lib/initialise.php');
require_once('../../lib/api.setup.inc.php');

// Initialise Variables
$id      = 0;
$project = '';

// Check Conditions
if($api->checkConditions($_SERVER))
{
	// Start API
	$api->start();
	
	if($api->getAuth())
	{	
		// Start Footprint
		$fp = new footprint;
		
		// Set UserID and AccID
		$fp->setAccID($api->getAuthData('accid'));
		$fp->setUserID($api->getAuthData('userid'));
		
		// Clean ID Value
		if(isset($_GET['id']))
		{
			$id = cleanValue($_GET['id']);
		}
		
		// Create Project Object
		$fp->project = new project;
		
		// Set UserID and AccID (for project)
		$fp->project->setAccID($fp->getAccID());
		$fp->project->setUserID($fp->getUserID());
		
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
			$project = $fp->project->loadProject($fp->getUserID());
		}
		
		// Check Project was Found
		if(empty($project))
		{
			header("HTTP/1.0 404 Not Found");
			exit();
		}
		
		// Show Content as XML
		header('Content-type: application/xml');
	}
}

// Assign Content
$smarty->assign('p' , $project);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('project.tpl');

?>