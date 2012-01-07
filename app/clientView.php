<?php

require_once ('lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Authenticate User
$fp->authenticate();

$id = 0;

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
	$fp->client->select($id);

	$client = $fp->client->loadClient();
}
elseif($fp->checkPermission('assigned_objects'))
{
	// No need to create a client object
	$client = $fp->loadAssignedClient($id);	
}
else
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Check Client was Found
if(empty($client))
{
	$smarty->display('errorNotFound.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowClients', true);
$smarty->assign('page'        , array('clientView' => true));
$smarty->assign('client'      , $client);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('clientView.tpl');

?>