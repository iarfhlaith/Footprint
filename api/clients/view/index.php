<?php
/**
 * Footprint
 *
 * A project management tool for web designers.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst. It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package Footprint
 * @author Iarfhlaith Kelly
 * @copyright Copyright (c) 2007 - 2012, Iarfhlaith Kelly. (http://iarfhlaith.com/)
 * @license http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link http://footprintapp.com
 * @since Version 1.0
 * @filesource
 */

// Initialise Footprint & API Code
require_once('../../../app/lib/initialise.php');
require_once('../../lib/api.setup.inc.php');

// Initialise Variables
$id       = 0;
$client   = '';
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
		
		// Clean ID Value
		if(isset($_GET['id']))
		{
			$id = cleanValue($_GET['id']);
		}
		
		// Check Access Rights and Load Client
		if($fp->checkPermission('all_objects'))
		{
			// Create Client Object
			$fp->client = new client;
			
			// Set UserID and AccID (for client)
			$fp->client->setAccID($fp->getAccID());
			$fp->client->setUserID($fp->getUserID());
			
			$fp->client->select($id);
			
			$client   = $fp->client->loadClient();
			$projects = $fp->loadAllProjects($id, true, false);
		}
		elseif($fp->checkPermission('assigned_objects'))
		{
			// No need to create a client object
			$client   = $fp->loadAssignedClient($id);	
			$projects = $fp->loadAssignedProjects($id, true, false);
		}
		else
		{
			header("HTTP/1.0 403 Forbidden");
			exit();
		}
		
		// Check Client was Found
		if(empty($client))
		{
			header("HTTP/1.0 404 Not Found");
			exit();
		}
		
		// Show Content as XML
		header('Content-type: application/xml');
	}
}

// Assign Content
$smarty->assign('c'        , $client);
$smarty->assign('projects' , $projects);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('client.tpl');

?>