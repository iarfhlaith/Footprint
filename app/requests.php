<?php

require_once ('lib/initialise.php');

// Defaults
$pName    = 'requests';
$output   = $pName;
$paginate = false;
$note	  = false;

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

// Initialise Variables
$clients = false;

// Filter for a particular project if required
if(isset($_GET['id']))
{
	$client = cleanValue($_GET['id']);
}
else
{
	$client = '';
}

// Check Access and Load Requests
if($fp->checkPermission('all_objects'))
{
	$requests = $fp->loadAllRequests('', $client);
	$clients  = $fp->loadClients(false, false, false, true);
}
elseif($fp->checkPermission('assigned_objects'))
{
	$requests = $fp->loadAssignedRequests($client);
	$clients  = $fp->loadAssignedClients(false, false, true);	
}
else
{
	$requests = $fp->loadAllRequests('', $_SESSION['user']['userID']);	
}

// Process User Actions
if($fp->checkPermission('manage_requests'))
{		
	$fp->request = new request;
	
	if(!empty($_GET['request'])) $_POST = $_GET;
	if(isset($_POST['reply']))   $reply = $_POST['reply'];

	if(!empty($_POST['request']))
	{
		if($_POST['action'] == 'delete')
		{
			$res=$fp->request->delete($_POST['request']);
			$_SESSION['message'] = $fp->validator->loadResponse(true, $res);
			header('Location: requests.php');
		}
		elseif($_POST['action'] == 'convert')
		{	
			$res=$fp->request->convert($_POST['request']);
			$_SESSION['message'] = $fp->validator->loadResponse(true, $res, 1);
			header('Location: tasks.php');
			
			// Update Activity Log
			if(is_array($_POST['request']))
			{
				foreach($_POST['request'] as $value=>$dummy) $fp->updateActivityLog('requestConvert', $value);
			}
			else $fp->updateActivityLog('requestConvert', $_POST['request']);
		}
		elseif($_POST['action'] == 'reject')
		{	
			$res=$fp->request->reject($_POST['request'], $reply);
			$_SESSION['message'] = $fp->validator->loadResponse(true, $res, 2);
			header('Location: requests.php');
			
			// Update Activity Log
			if(is_array($_POST['request']))
			{
				foreach($_POST['request'] as $value=>$dummy) $fp->updateActivityLog('requestReject', $value);
			}
			else $fp->updateActivityLog('requestReject', $_POST['request']);
		}
		
		// Reset Pagination (if necessary)
		if(count($_POST['request']) >= PER_PAGE)
		{
			SmartyPaginate::disconnect($pName);
		}
		
		exit();
	}
}

// Assign Tasks
$smarty->assign('requests', $requests);

// Process Results for Correct Response Type
if(isset($_GET['ajax']))
{
	$output = 'json';
	$smarty->assign('response',  json_encode($requests));
}
else
{
	if($paginate)
	{
		SmartyPaginate::assign($smarty, 'paginate', $pName);	
	}
		
	// Assign Variables
	$smarty->assign('belowTasks', true);
	$smarty->assign('page'      , array('requests' => true));
	$smarty->assign('pName'     , $pName);
	$smarty->assign('requests'  , $requests);
	$smarty->assign('client'    , $client);
	$smarty->assign('clients'   , $clients);
	$smarty->assign('message'   , $fp->loadMessages());
}

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');

?>