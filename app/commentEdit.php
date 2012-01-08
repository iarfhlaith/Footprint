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
$id      = 0;
$valid   = false;
$page	 = 'commentEdit';
$output  = $page;
$qstr	 = array();
$success = false;

// Start Footprint
$fp = new footprint;
$fp->validator = new validator;
$fp->validator->setPage($page);
$fp->validator->setFormName('default');

// Authenticate User
$fp->authenticate();

// Parse Querystring
if(!empty($_GET))
{
	if(isset($_GET['id']))
	{
		$id = cleanValue($_GET['id']);
		$source   = $_GET['source'];
		$sourceid = $_GET['sourceid'];
	}
}
// Parse POST Info
elseif(!empty($_POST))
{
	if(isset($_POST['id']))
	{
		$id = cleanValue($_POST['id']);
		$source   = $_POST['source'];
		$sourceid = $_POST['sourceid'];
	}
}

// Instantiate Comment
$fp->comment = new comment;

// Check Access Rights
if(!$fp->comment->isAuthor($id, $_SESSION['user']['userID']))
{
	$smarty->display('errorAccess.tpl');
	exit();
}

// Load Comment
$comment = $fp->comment->loadComment($id);

// Check Comment was Found
if(empty($comment['id']))
{	
	$smarty->display('errorNotFound.tpl');
	exit();
}

// Initialise Form Validators
if(empty($_POST))
{
	SmartyValidate::connect($smarty, true);	
	SmartyValidate::register_validator('comment', 'comment', 'notEmpty');
	SmartyValidate::register_validator('author' , 'id'     , 'isAuthor');
}
else
{
	SmartyValidate::connect($smarty);
	
	SmartyValidate::register_object('com', $fp->comment);
	SmartyValidate::register_criteria('isAuthor', 'com->isAuthorWrapper');
	
	if($valid=SmartyValidate::is_valid($_POST))
	{
		SmartyValidate::disconnect();
		
		// Clean Comment
		$com = cleanValue($_POST['comment']);
		
		// Update Comment
		$success = $fp->comment->update($id, $com);
	}
	else
	{
		$smarty->assign($_POST);
		
		$source   = $_POST['source'];
		$sourceid = $_POST['sourceid'];
	}

	// Process Results for Correct Response
	$res=$fp->validator->loadResponse($valid, $success);
	if($res['redirect']) $_SESSION['message'] = $res;
	
	if(isset($_POST['ajax']))
	{
		$res['redirect'] = $source;
		$output = 'json';
		$smarty->assign('response',  json_encode($res));
	}
	else
	{
		$res['redirect'] = $source.'?id='.$sourceid;
		header('Location: '.$res['redirect']);
	}
}

// Mark Menu
$smarty->assign('belowNothing', true);
$smarty->assign('page'        , array('commentEdit' => true));

// Assign Variables
$smarty->assign('text'     , $lang[$page]);
$smarty->assign('valid'    , $valid);
$smarty->assign('comment'  , $comment);
$smarty->assign('source'   , $source);
$smarty->assign('sourceid' , $sourceid);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display($output.'.tpl');

?>