<?php

require_once ('lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Authenticate User
$fp->authenticate();

// Initialise Variables
$id = 0;

// Clean ID Value
if(isset($_GET['id']))
{
	$id = cleanValue($_GET['id']);
}

// Create Document Object
$fp->document = new document;
$fp->document->select($id);

// Check Access Rights and Load Doc
if($fp->checkPermission('all_objects'))
{
	$document = $fp->document->loadDocument();
}
elseif($fp->checkPermission('assigned_objects'))
{
	$document = $fp->document->loadDocument('', true);	
}
else
{
	$document = $fp->document->loadDocument($_SESSION['user']['userID']);
}

// Check Document was Found
if(empty($document['title']))
{
	$smarty->display('errorNotFound.tpl');
	exit();
}

// Mark Menu
$smarty->assign('belowDocuments', true);
$smarty->assign('page'          , array('documentVersions' => true));
$smarty->assign('document'      , $document);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('documentVersions.tpl');

?>