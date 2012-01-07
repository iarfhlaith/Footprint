<?php

require_once ('lib/initialise.php');

// Defaults
$page = 'clients';

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);

// Authenticate User
$fp->authenticate();

// Start Pagination Plugin
$pName = 'clients';
SmartyPaginate::connect($pName);
SmartyPaginate::setLimit(PER_PAGE, $pName);
$fp->setPage($pName);

// Check Access Rights and Load Clients
if($fp->checkPermission('all_objects'))
{
	$clients = $fp->loadClients();
}
elseif($fp->checkPermission('assigned_objects'))
{
	$clients = $fp->loadAssignedClients();	
}
else
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Delete Clients
if($fp->checkPermission('all_objects'))
{
	if(!empty($_POST['client']))
	{
		$fp->client = new client;
		$res=$fp->client->delete($_POST['client']);
		
		$_SESSION['message'] = $fp->validator->loadResponse(true, $res);
		
		// Reset Pagination (if necessary)
		if(count($_POST['client']) >= PER_PAGE)
		{
			SmartyPaginate::disconnect($pName);
		}
		
		// Display Message
		header('Location: clients.php');
		exit();
	}
}

// Mark Menu
$smarty->assign('belowClients', true);
$smarty->assign('page'        , array('clients' => true));
$smarty->assign('pName'       , $pName);

// Assign Variables
$smarty->assign('clients'     , $clients);
$smarty->assign('message'     , $fp->loadMessages());

// Paginate
SmartyPaginate::assign($smarty, 'paginate', $pName);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('clients.tpl');

?>