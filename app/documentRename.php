<?php

require_once ('lib/initialise.php');

// Defaults
$valid    = false;
$page	  = 'documentRename';
$output   = $page;
$success  = false;
$formVars = array();

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

if(empty($_POST) && empty($_GET))
{
	$smarty->display('errorWrongParameters.tpl');
	exit();
}

if(empty($_GET)) $_GET = $_POST;

$fp->doc = new document;
$checkClientAccess = false;

if(!$fp->checkPermission('all_objects')
|| !$fp->checkPermission('assigned_objects')) $checkClientAccess = true;

$docNames = $fp->doc->loadDocsForRename($_GET['documents'], $checkClientAccess);
$smarty->assign('docNames' , $docNames);

if(empty($docNames))
{
	$smarty->display('errorWrongParameters.tpl');
	exit();
}

if(empty($_POST))
{	
	SmartyValidate::connect($smarty, true);
	SmartyValidate::register_validator('documents', 'documents', '@notEmpty');
}
else
{
	SmartyValidate::connect($smarty);
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		$fp->doc = new document;
		SmartyValidate::disconnect();
		
		// Check Docs Belong to Account
		if(!$fp->doc->belong($_POST['documents'], $_SESSION['user']['accID']))
		{
			$smarty->display('errorAccess.tpl');
			exit();
		}
		
		if(!$fp->checkPermission('all_objects') || !$fp->checkPermission('assigned_objects')) $checkClientAccess = true;
		
		foreach($_POST['documents'] as $fieldName => $fieldValue)
		{	
			$success=$fp->doc->rename($fieldName, cleanValue($fieldValue), $checkClientAccess);
			if(!$success) break;
		}
	}
	
	// Process Results for Correct Response
	$res=$fp->validator->loadResponse($valid, $success);
	if($res['redirect']) $_SESSION['message'] = $res;
	
	if(isset($_POST['ajax']))
	{
		$output = 'json';
		$smarty->assign('response',  json_encode($res));
	}
	else
	{
		if($res['redirect'])
		{
			header('Location: '.$res['redirect']);
			exit();
		}
	}
}

// Mark Menu
$smarty->assign('belowDocuments', true);
$smarty->assign('page'          , array('documentRename' => true));

// Assign Variables
$smarty->assign($_POST);
$smarty->assign('text'  , $lang[$page]);
$smarty->assign('valid' , $valid);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');
?>