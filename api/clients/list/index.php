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