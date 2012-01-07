<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        english.php
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

$lang = array(
	
     'reminder' => array(
	 				  'success' => 'Success! We\'ve emailed you a link to reset your password.'
	 ,			  'successText' => ''
	 ,				  'failure' => ''
	 ,                'invalid' => ''
	 ,			     'redirect' => ''
	 ,          'emailValidate' => 'That email address wasn\'t valid'
	 ,             'emailCheck' => 'That email address doesn\'t exist in the system'
	 ,				  'options' => ''
	)
	
   ,    'login' => array(
	                  'success' => 'Logging in...'
	 ,            'successText' => ''
	 ,                'failure' => ''
	 ,                'invalid' => ''
	 ,			     'redirect' => ''
	 ,				  'account' => 'Please enter your account name'
	 ,				 'username' => 'Please enter your username'
	 ,				 'password' => 'Please enter your password'
	 ,		  'credentialCheck' => 'Your login details were incorrect'
	 ,				  'options' => ''
	)

,      'reset' => array(
	                  'success' => 'Password Changed! Now login using your new password.'
	 ,            'successText' => ''
	 ,                'failure' => ''
	 ,                'invalid' => ''
	 ,			     'redirect' => ''
	 ,		    'passwordEmpty' => 'Please choose a stronger password. (min 5 chars)'
	 ,		    'passwordMatch' => 'The password fields don\'t match. Please try again.'
	 ,				  'options' => ''
	)

   ,   'openid' => array(
	                  'success' => 'Logging in...'
	 ,            'successText' => ''
 	 ,                'failure' => 'Please enter a valid OpenID'
	 ,			  'failureText' => 'That OpenID is not Valid. Please try again.'
     ,                'invalid' => ''
	 ,				 'redirect' => true
     , 		           'openid' => 'Please enter your OpenID'
	 ,				 'notFound' => 'That OpenID does not belong to any users in your account'
	 ,				  'options' => ''
	)

   ,    'staff' => array(
					  'success' => 'Staff Deleted'
	 ,			  'successText' => 'The selected staff member(s) have been permanently deleted from the system.'
	 ,                'failure' => 'Internal Error'
	 ,			  'failureText' => 'There was a communications breakdown while your new staff member was being deleted. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => ''
	 ,				  'options' => array(array('link' => '/app/index.php'   ,'text' => 'Return to your dashboard'))
	)

   , 'staffNew' => array(
					  'success' => 'New Staff Member Created'
	 ,			  'successText' => 'The new staff member\'s details have been saved to your account.'
	 ,                'failure' => 'Internal Error, Staff Member Not Created'
	 ,			  'failureText' => 'There was a communications breakdown while your staff member was being created. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => 'staff.php'
	 ,					 'name' => 'Please enter a name for the staff member'
	 ,				    'email' => 'Please enter a valid email address for the staff member'
	 ,				 'password' => 'The password must be at least 5 characters long'
	 ,				'userValid' => 'Please choose a valid username'
	 ,			   'userUnique' => 'That username already exists, please choose something unique'
	 ,				  'options' => array(array('link' => '/app/staffNew.php','text' => 'Create another staff member')
	 								   , array('link' => '/app/index.php'   ,'text' => 'Return to your dashboard'))
	)
	
   , 'staffEdit' => array(
					  'success' => 'Staff Member Updated'
	 ,			  'successText' => 'The staff member\'s details have been saved and updated.'
	 ,                'failure' => 'Internal Error, Changes Have Not Been Saved'
	 ,			  'failureText' => 'There was a communications breakdown while the staff member data was being updated. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => 'staff.php'
	 ,					 'name' => 'Please enter a name for the staff member'
	 ,				    'email' => 'Please enter a valid email address for the staff member'
	 ,				 'passWeak' => 'The password must be at least 5 characters long'
	 ,				 'passDiff' => 'The confirmation password doesn\'t match'
	 ,				'userValid' => 'Please choose a valid username'
	 ,			   'userUnique' => 'That username already exists, please choose something unique'
	 ,				  'options' => array(array('link' => '/app/index.php'   ,'text' => 'Return to your dashboard'))
	)

   ,   'clients' => array(
					  'success' => 'Client(s) Deleted'
	 ,			  'successText' => 'The selected client(s) and their data have been permanently deleted from the system.'
	 ,                'failure' => 'Internal Error'
	 ,			  'failureText' => 'There was a communications breakdown while your client was being deleted. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => ''
	 ,				  'options' => array(array('link' => '/app/index.php'   ,'text' => 'Return to your dashboard'))
	)
	
   , 'clientNew' => array(
					  'success' => 'New Client Created'
	 ,			  'successText' => 'The new client\'s details have been saved to your account.'
	 ,                'failure' => 'Internal Error, The Client Was Not Created'
	 ,			  'failureText' => 'There was a communications breakdown while your new client was being created. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => 'clients.php'
	 ,					 'name' => 'Please enter a name for the client'
	 ,				    'email' => 'Please enter a valid email address for the client'
	 ,				 'password' => 'The password must be at least 5 characters long'
	 ,				'userValid' => 'Please choose a valid username'
	 ,			   'userUnique' => 'That username already exists, please choose something unique'
	 ,				  'options' => array(array('link' => '/app/clientNew.php','text' => 'Create another client')
	 								   , array('link' => '/app/index.php'    ,'text' => 'Return to your dashboard'))
	)
	
   , 'clientEdit' => array(
					  'success' => 'Client Information Updated'
	 ,			  'successText' => 'The client\'s details have been saved and updated.'
	 ,                'failure' => 'Internal Error, Changes Have Not Been Saved'
	 ,			  'failureText' => 'There was a communications breakdown while the client\'s data was being updated. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => 'clients.php'
	 ,					 'name' => 'Please enter a name for the client'
	 ,				    'email' => 'Please enter a valid email address for the client'
	 ,				 'passWeak' => 'The password must be at least 5 characters long'
	 ,				 'passDiff' => 'The confirmation password doesn\'t match'
	 ,				'userValid' => 'Please choose a valid username'
	 ,			   'userUnique' => 'That username already exists, please choose something unique'
	 ,				  'options' => array(array('link' => '/app/index.php'   ,'text' => 'Return to your dashboard'))
	)

   , 'clientImport' => array(
					  'success' => 'Clients Have Been Imported'
	 ,			  'successText' => 'The clients been imported successfully.'
	 ,                'failure' => 'Internal Error, Changes Have Not Been Saved'
	 ,			  'failureText' => 'There was a communications breakdown while the client\'s data was being updated. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => 'clients.php'
	 ,					 'type' => 'Please choose a supported source type'
	 ,				     'file' => 'Please provide a file containing a list of your clients'
	 ,				 'fileSize' => 'That file is too large. It must be less than 15Mb. Please try again.'
	 ,			   'fileFormat' => 'The format of the file you submitted is not supported. Please try again.'
	 ,				  'options' => array(array('link' => '/app/index.php'   ,'text' => 'Return to your dashboard'))
	)

   ,   'projects' => array(
					  'success' => 'Project(s) Deleted'
	 ,			  'successText' => 'The selected project(s) and their data have been permanently deleted from the system.'
	 ,                'failure' => 'Internal Error'
	 ,			  'failureText' => 'There was a communications breakdown while your project(s) were being deleted. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => ''
	 ,				  'options' => array(array('link' => '/app/index.php'   ,'text' => 'Return to your dashboard'))
	)

   ,  'projectNew' => array(
					  'success' => 'New Project Created'
	 ,			  'successText' => 'The new project\'s details have been saved and is available in your list of projects.'
	 ,                'failure' => 'Internal Error, The Project Was Not Created'
	 ,			  'failureText' => 'There was a communications breakdown while your new project was being created. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => 'projects.php'
	 ,					 'name' => 'Please enter a project name'
	 ,				   'client' => 'Please select the project\'s client'
	 ,				  'manager' => 'Please select a person to manage the project'
	 ,				  'options' => array(array('link' => '/app/projectNew.php','text' => 'Create another project')
	 								   , array('link' => '/app/index.php'     ,'text' => 'Return to your dashboard'))
	)
	
	, 'projectEdit' => array(
					  'success' => 'Project Information Updated'
	 ,			  'successText' => 'The project\'s details have been saved and updated.'
	 ,                'failure' => 'Internal Error, Changes Have Not Been Saved'
	 ,			  'failureText' => 'There was a communications breakdown while your project\'s details were being updated. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => 'projects.php'
	 ,					 'name' => 'Please enter a project name'
	 ,				   'client' => 'Please select the project\'s client'
	 ,				  'manager' => 'Please select a person to manage the project'
	 ,				  'options' => array(array('link' => '/app/index.php'     ,'text' => 'Return to your dashboard'))
	)

   ,       'tasks' => array(
					  'success' => 'Task(s) Deleted'
	 ,			  'successText' => 'The selected task(s) and their data have been permanently deleted from the system.'
	 ,                'failure' => 'Internal Error'
	 ,			  'failureText' => 'There was a communications breakdown while your task(s) were being deleted. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => ''
	 ,				  'options' => array(array('link' => '/app/index.php'   ,'text' => 'Return to your dashboard'))
	)
	
   ,     'taskView' => array(
					  'success' => 'Comment Saved'
	 ,			  'successText' => 'Your comments have been saved.'
	 ,                'failure' => 'Internal Error, The Comment Was Not Saved'
	 ,			  'failureText' => 'There was a communications breakdown while your comment was being saved. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'taskView.php'
	 ,			      'comment' => 'Please enter a comment'
	 ,				  'options' => false
	)
	
   ,     'taskNew' => array(
					  'success' => 'New Task Created'
	 ,			  'successText' => 'The new task\'s details have been saved and is available in your list of tasks.'
	 ,                'failure' => 'Internal Error, The Task Was Not Created'
	 ,			  'failureText' => 'There was a communications breakdown while your new task was being created. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'tasks.php'
	 ,					 'task' => 'Please enter the task name'
	 ,				  'project' => 'Please select the parent project'
	 ,				  'options' => array(array('link' => '/app/taskNew.php'   ,'text' => 'Create another task')
	 								   , array('link' => '/app/index.php'     ,'text' => 'Return to your dashboard'))
	)
	
   ,    'taskEdit' => array(
					  'success' => 'Task Information Updated'
	 ,			  'successText' => 'The task\'s details have been saved and updated.'
	 ,                'failure' => 'Internal Error, Changes Have Not Been Saved'
	 ,			  'failureText' => 'There was a communications breakdown while your task\'s details were being updated. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'tasks.php'
	 ,					'title' => 'Please enter the task name'
	 ,				  'project' => 'Please select the parent project'
	 ,				  'options' => array(array('link' => '/app/index.php'     ,'text' => 'Return to your dashboard'))
	)

   ,    'requests' => array(
					  'success' => 'Request(s) Deleted'
	 ,			  'successText' => 'The selected request(s) have been permanently deleted from the system.'
	 ,                'failure' => 'Internal Error'
	 ,			  'failureText' => 'There was a communications breakdown while your request(s) were being deleted. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => ''
	 ,				  'options' => array(array('link' => '/app/index.php'   ,'text' => 'Return to your dashboard'))
	 
	 ,				 'success1' => 'Request(s) Converted'
	 ,			 'successText1' => 'The selected request(s) have been converted to Task(s).'
	 ,               'failure1' => 'Internal Error'
	 ,		     'failureText1' => 'There was a communications breakdown while your request(s) were being converted. Please try again.'
	 ,			     'invalid1' => ''
	 ,		        'redirect1' => ''
	 ,		    	 'options1' => array(array('link' => '/app/index.php'   ,'text' => 'Return to your dashboard'))
	 
	 ,				 'success2' => 'Request(s) Rejected'
	 ,			 'successText2' => 'The selected request(s) have been rejected.'
	 ,               'failure2' => 'Internal Error'
	 ,		     'failureText2' => 'There was a communications breakdown while the request(s) were being rejected. Please try again.'
	 ,			     'invalid2' => ''
	 ,		        'redirect2' => ''
	 ,		    	 'options2' => array(array('link' => '/app/index.php'    ,'text' => 'Return to your dashboard')
									   , array('link' => '/app/requests.php' ,'text' => 'View more Requests'))
	)

   ,  'requestNew' => array(
					  'success' => 'New Request Created'
	 ,			  'successText' => 'The new request\'s details have been saved and is available in your list of submitted requests.'
	 ,                'failure' => 'Internal Error, The Request Was Not Created'
	 ,			  'failureText' => 'There was a communications breakdown while your new request was being created. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'requests.php'
	 ,				  'request' => 'Please enter the request\'s title'
	 ,				  'project' => 'Please select the parent project'
	 ,				  'options' => array(array('link' => '/app/requestNew.php'   ,'text' => 'Create another request')
	 								   , array('link' => '/app/index.php'        ,'text' => 'Return to your dashboard'))
	)
	
  ,  'requestEdit' => array(
					  'success' => 'Request Information Updated'
	 ,			  'successText' => 'The request\'s details have been saved and updated.'
	 ,                'failure' => 'Internal Error, Changes Have Not Been Saved'
	 ,			  'failureText' => 'There was a communications breakdown while your request\'s details were being updated. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'requests.php'
	 ,				    'title' => 'Please enter the request\'s title'
	 ,				  'project' => 'Please select the parent project'
	 ,				  'options' => array(array('link' => '/app/index.php'        ,'text' => 'Return to your dashboard'))
	)
	
  ,  'commentEdit' => array(
					  'success' => 'Comment Updated'
	 ,			  'successText' => 'The comment has been saved and updated.'
	 ,                'failure' => 'Internal Error, Changes Have Not Been Saved'
	 ,			  'failureText' => 'There was a communications breakdown while your comments\'s details were being updated. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'taskView.php'
	 ,				  'comment' => 'Please enter a comment'
	 ,				   'author' => 'Sorry, only the person who created the comment is allowed to change it.'
	 ,				  'options' => false
	)
	
   ,   'settings1' => array(
					  'success' => 'Settings Saved'
	 ,			  'successText' => 'Company profile information has been saved'
	 ,                'failure' => 'Internal Error, The Information Was Not Updated'
	 ,			  'failureText' => 'There was a communications breakdown while your information was being updated. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'settings1.php'
	 ,				     'name' => 'Please enter your name'
	 ,				    'email' => 'Please enter your email address'
	 ,				 'password' => 'Please choose a valid password (min 5 characters)'
	 ,				  'confirm' => 'Please confirm your password, they\'ve got to match'
	 ,				'userValid' => 'Please choose a valid username'
	 ,			   'userUnique' => 'That username already exists, please choose something unique'
	 ,				  'options' => NULL
	)
	
   ,   'settings2' => array(
					  'success' => 'Settings Saved'
	 ,			  'successText' => 'The settings information has been saved'
	 ,                'failure' => 'Internal Error, The Information Was Not Updated'
	 ,			  'failureText' => 'There was a communications breakdown while your information was being updated. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'settings2.php'
	 ,				    'style' => 'Please select a style'
	 ,				  'options' => NULL
	)

   ,   'settings5' => array(
					  'success' => 'OpenID Attached'
	 ,			  'successText' => 'The supplied OpenID has been attached to your account'
	 ,                'failure' => 'Internal Error, The Information Was Not Updated'
	 ,			  'failureText' => 'There was a communications breakdown while your information was being updated. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'settings5.php'
	 ,			   'openid_url' => 'Please enter an OpenID'
	 ,			'openid_unique' => 'That OpenID is already in use. Please choose a different one.'
	 ,				  'options' => NULL
	)	

   , 'settingsLogo' => array(
					  'success' => 'Logo Updated'
	 ,			  'successText' => 'The new logo has been saved. If you do not see the changes immediately, wait a few minutes and hit refresh. Alternatively you could also try clearing your cache.'
	 ,                'failure' => 'Internal Error, The Information Was Not Updated'
	 ,			  'failureText' => 'There was a communications breakdown while your information was being updated. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'settingsLogo.php'
	 ,				     'logo' => 'Please select a valid image'
	 ,				 'logoSize' => 'Please select an image less then 1Mb'
	 ,				  'options' => NULL
	)
	
  , 'screenshotNew' => array(
					  'success' => 'Screenshot Saved'
	 ,			  'successText' => 'The screenshot has been safely stored within your account'
	 ,                'failure' => 'Internal Error, The Screenshot Was Not Saved'
	 ,			  'failureText' => 'There was a communications breakdown while your screenshot was uploading. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'screenshots.php'
	 ,				     'name' => 'Please enter a short title for the screenshot'
	 ,				  'project' => 'Please choose the appropriate project for the screenshot'
	 ,				     'task' => 'Please choose the appropriate task for the screenshot (or create a new task)'
	 ,				     'file' => 'Please select a valid image to upload from your computer'
	 ,				 'fileSize' => 'Please select a file less than 15Mb in size.'
	 ,				   'access' => 'Please select a suitable access level'
	 ,				  'options' => array(array('link' => '/app/screenshotNew.php' ,'text' => 'Add another screenshot')
	 								   , array('link' => '/app/index.php'         ,'text' => 'Return to your dashboard'))
	)

   , 'screenshotView' => array(
					  'success' => 'Comment Saved'
	 ,			  'successText' => 'Your comments have been saved.'
	 ,                'failure' => 'Internal Error, The Comment Was Not Saved'
	 ,			  'failureText' => 'There was a communications breakdown while your comment was being saved. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'screenshotView.php'
	 ,			      'comment' => 'Please enter a comment'
	 ,				  'options' => false
	)
	
 ,      'screenshots' => array(
					  'success' => 'Screenshot(s) Deleted'
	 ,			  'successText' => 'The selected screenshot(s) have been permanently deleted from the system.'
	 ,                'failure' => 'Internal Error'
	 ,			  'failureText' => 'There was a communications breakdown while your screenshot(s) were being deleted. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => ''
	 ,				  'options' => array(array('link' => '/app/index.php'   ,'text' => 'Return to your dashboard'))
	)

, 'screenshotUpdate' => array(
					  'success' => 'Screenshot Updated'
	 ,			  'successText' => 'The screenshot has been safely updated and all previous versions of the screenshot are still accessable.'
	 ,                'failure' => 'Internal Error, The Screenshot Was Not Updated'
	 ,			  'failureText' => 'There was a communications breakdown while your screenshot was being updated. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'screenshots.php'
	 ,				     'file' => 'Please select a valid image to upload from your computer'
	 ,				 'fileSize' => 'Please select a file less than 15Mb in size.'
	 ,				   'access' => 'Please select a suitable access level'
	 ,				  'version' => 'Please provide the current version information'
	 ,				  'options' => array(array('link' => '/app/screenshotNew.php' ,'text' => 'Add a new screenshot')
	 								   , array('link' => '/app/index.php'         ,'text' => 'Return to your dashboard'))
	)

 , 'documentNew' => array(
					  'success' => 'Document Saved'
	 ,			  'successText' => 'The document has been safely stored within your account'
	 ,                'failure' => 'Internal Error, The Document Was Not Saved'
	 ,			  'failureText' => 'There was a communications breakdown while your document was uploading. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'documents.php'
	 ,				     'name' => 'Please enter a short title for the document'
	 ,				  'project' => 'Please choose the appropriate project for the document'
	 ,				     'task' => 'Please choose the appropriate task for the document (or create a new task)'
	 ,				     'file' => 'Please select a file to upload from your computer'
	 ,				 'fileSize' => 'Please select a file less than 15Mb in size.'
	 ,				   'access' => 'Please select a suitable access level'
	 ,				  'options' => array(array('link' => '/app/documentNew.php' ,'text' => 'Add another document')
	 								   , array('link' => '/app/index.php'       ,'text' => 'Return to your dashboard'))
	)

, 'documentUpdate' => array(
					  'success' => 'Document Updated'
	 ,			  'successText' => 'The document has been safely updated and all previous versions of the document are still accessable.'
	 ,                'failure' => 'Internal Error, The Document Was Not Updated'
	 ,			  'failureText' => 'There was a communications breakdown while your document was being updated. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'documents.php'
	 ,				     'file' => 'Please select a file to upload from your local computer'
	 ,				 'fileSize' => 'Please select a file less than 15Mb in size.'
	 ,				   'access' => 'Please select a suitable access level'
	 ,				  'version' => 'Please provide the current version information'
	 ,				  'options' => array(array('link' => '/app/documentNew.php' ,'text' => 'Add a new document')
	 								   , array('link' => '/app/index.php'       ,'text' => 'Return to your dashboard'))
	)

 , 'documentRename' => array(
					  'success' => 'Document(s) Renamed'
	 ,			  'successText' => 'The selected document(s) have been renamed.'
	 ,                'failure' => 'Internal Error, The Document(s) Were Not Renamed'
	 ,			  'failureText' => 'There was a communications breakdown while your document(s) were being renamed. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'documents.php'
	 ,				'documents' => 'Please enter new names for all the documents'
	 ,				  'options' => array(array('link' => '/app/index.php'       ,'text' => 'Return to your dashboard'))
	)

 ,   'documents' => array(
					  'success' => 'Document(s) Deleted'
	 ,			  'successText' => 'The selected document(s) have been permanently deleted from the system.'
	 ,                'failure' => 'Internal Error'
	 ,			  'failureText' => 'There was a communications breakdown while your document(s) were being deleted. Please try again.'
	 ,				  'invalid' => ''
	 ,			     'redirect' => ''
	 ,				  'options' => array(array('link' => '/app/index.php'   ,'text' => 'Return to your dashboard'))
	)
	
   ,  'feedback' => array(
					  'success' => 'Thanks for the Feedback!'
	 ,			  'successText' => 'Your comments have been sent to our support team. We\'ll get back to you as soon as we can.'
	 ,                'failure' => 'Internal Error, The Feedback Was Not Sent'
	 ,			  'failureText' => 'There was a communications breakdown while your feedback was being sent. Please try again.'
	 ,				  'invalid' => 'Ooops! There was an unknown error and the form did not validate.'
	 ,			     'redirect' => 'index.php'
	 ,				  'subject' => 'Please provide a subject title'
	 ,				 'comments' => 'Please enter your comments'
	 ,				  'options' => array(array('link' => '/app/feedback.php'   ,'text' => 'Send more feedback'))
	)

);

?>