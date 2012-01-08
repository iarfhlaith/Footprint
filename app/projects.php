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
require_once ('lib/initialise.php');

// Defaults
$page    = 'projects';
$clients = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);

// Authenticate User
$fp->authenticate();

// Start Pagination Plugin
$pName = 'projects';
SmartyPaginate::connect($pName);
SmartyPaginate::setLimit(PER_PAGE, $pName);
$fp->setPage($pName);

// Filter by client if necessary
$client = $fp->loadFilterID($_GET);

// Check Access and Load Projects
if($fp->checkPermission('all_objects'))
{
	$projects = $fp->loadAllProjects($client);
	$clients  = $fp->loadClients(false, false, false, true);
}
elseif($fp->checkPermission('assigned_objects'))
{
	$projects = $fp->loadAssignedProjects($client);
	$clients  = $fp->loadAssignedClients(false, false);	
}
else
{
	$projects = $fp->loadAllProjects($_SESSION['user']['userID']);
}

// Delete Projects
if($fp->checkPermission('delete_projects'))
{
	if(!empty($_POST['project']))
	{
		$fp->project = new project;
		$res=$fp->project->delete($_POST['project']);
		
		$_SESSION['message'] = $fp->validator->loadResponse(true, $res);
		
		// Reset Pagination (if necessary)
		if(count($_POST['project']) >= PER_PAGE)
		{
			SmartyPaginate::disconnect($pName);
		}
		
		// Display Message
		header('Location: projects.php');
		exit();
	}
}

// Mark Menu
$smarty->assign('belowProjects', true);
$smarty->assign('page'         , array('projects' => true));
$smarty->assign('pName'        , $pName);

// Assign Variables
$smarty->assign('client'       , $client);
$smarty->assign('clients'      , $clients);
$smarty->assign('projects'     , $projects);
$smarty->assign('message'      , $fp->loadMessages());

// Paginate
SmartyPaginate::assign($smarty, 'paginate', $pName);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('projects.tpl');

?>