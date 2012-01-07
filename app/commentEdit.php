<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        commentEdit.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Ltd.
 *
 * This software is protected under Irish Copyright Law.
 *
 * @link http://www.footprintapp.com/
 * @copyright 2007-2009 Webstrong Ltd
 * @author Iarfhlaith Kelly <ik at webstrong dot ie>
 * @package Footprint
 * @version 1.0
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. http://www.footprintapp.com/forums
 *
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