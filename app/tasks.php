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
$pName    = 'tasks';
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

// Filter by project if necessary
$project = $fp->loadFilterID($_GET);

// Check Access and Load Tasks
if($fp->checkPermission('all_objects'))
{
	$tasks     = $fp->loadAllTasks($project);
	$projects  = $fp->loadAllProjects('', false, false);
}
elseif($fp->checkPermission('assigned_objects'))
{
	$tasks     = $fp->loadAssignedTasks($project);
	$projects  = $fp->loadAssignedProjects('', false, false);	
}
else
{
	$tasks     = $fp->loadAllTasks($project, $_SESSION['user']['userID']);
	$projects  = $fp->loadAllProjects($_SESSION['user']['userID'], false, false);	
}

// Delete Tasks
if($fp->checkPermission('manage_tasks'))
{
	if(!empty($_POST['task']))
	{
		$fp->task = new task;
		$res=$fp->task->delete($_POST['task']);
		
		$_SESSION['message'] = $fp->validator->loadResponse(true, $res);
		
		// Reset Pagination (if necessary)
		if(count($_POST['task']) >= PER_PAGE)
		{
			SmartyPaginate::disconnect($pName);
		}
		
		// Display Message
		header('Location: tasks.php');
		exit();
	}
}

// Assign Tasks
$smarty->assign('tasks', $tasks);

// Process Results for Correct Response Type
if(isset($_GET['ajax']))
{
	$output = 'json';
	$smarty->assign('response',  json_encode($tasks));
}
else
{
	if($paginate)
	{
		SmartyPaginate::assign($smarty, 'paginate', $pName);	
	}
		
	// Assign Variables
	$smarty->assign('belowTasks', true);
	$smarty->assign('page'      , array('tasks' => true));
	$smarty->assign('pName'     , $pName);
	$smarty->assign('project'   , $project);
	$smarty->assign('projects'  , $projects);
	$smarty->assign('message'   , $fp->loadMessages());
}

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');

?>