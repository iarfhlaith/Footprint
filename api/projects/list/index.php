<?php

// Initialise Footprint & API Code
require_once('../../../app/lib/initialise.php');
require_once('../../lib/api.setup.inc.php');

// Initialise Variables
$projects = array();

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
		
		// Check Access and Load Projects
		if($fp->checkPermission('all_objects'))
		{
			$projects = $fp->loadAllProjects('', true, false);
		}
		elseif($fp->checkPermission('assigned_objects'))
		{
			$projects = $fp->loadAssignedProjects('', true, false);
		}
		else
		{
			$projects = $fp->loadAllProjects($fp->getUserID(), true, false);
		}
		
		// Show Content as XML
		header('Content-type: application/xml');
	}
}

// Assign Content
$smarty->assign('projects' , $projects);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('projects.tpl');

?>