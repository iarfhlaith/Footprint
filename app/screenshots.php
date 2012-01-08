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