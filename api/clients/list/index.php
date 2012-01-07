<?php

// Initialise Footprint & API Code
require_once('../../../app/lib/initialise.php');
require_once('../../lib/api.setup.inc.php');

// Initialise Variables
$clients = array();

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
		
		// Check Access Rights and Load Clients
		if($fp->checkPermission('all_objects'))
		{
			$clients = $fp->loadClients(true, false, false);	
		}
		elseif($fp->checkPermission('assigned_objects'))
		{
			$clients = $fp->loadAssignedClients(true, false);	
		}
		else
		{
			header("HTTP/1.1 403 Forbidden");
			exit();
		}
		
		// Show Content as XML
		header('Content-type: application/xml');
	}
}

// Assign Content
$smarty->assign('clients' , $clients);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('clients.tpl');

?>