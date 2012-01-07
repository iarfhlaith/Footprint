<?php

require_once ('lib/initialise.php');

// Defaults
$page	 = 'staff';
$success = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);

// Authenticate User
$fp->authenticate();

// Start Pagination Plugin
$pName = 'staff';
SmartyPaginate::connect($pName);
SmartyPaginate::setLimit(PER_PAGE, $pName);
$fp->setPage($pName);

// Check Access Rights
if(!$fp->checkPermission('staff'))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Delete Staff
if(!empty($_POST['staff']))
{
	$fp->staff = new staff;
	$res=$fp->staff->delete($_POST['staff']);
	
	$_SESSION['message'] = $fp->validator->loadResponse(true, $res);
	
	// Reset Pagination (if necessary)
	if(count($_POST['staff']) >= PER_PAGE)
	{
		SmartyPaginate::disconnect($pName);
	}
	
	// Display Message
	header('Location: staff.php');
	exit();
}

// Mark Menu
$smarty->assign('belowStaff', true);
$smarty->assign('page'      , array('staff' => true));
$smarty->assign('pName'     , $pName);

// Assign Variables
$smarty->assign('staff'     , $fp->loadAllStaff(true, true));
$smarty->assign('message'   , $fp->loadMessages());

// Paginate
SmartyPaginate::assign($smarty, 'paginate', $pName);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('staff.tpl');

?>