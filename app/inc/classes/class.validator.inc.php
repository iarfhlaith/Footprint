<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        class.validator.inc.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Internet Solutions.
 *
 * This software is protected under Irish CopyRight Law.
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. @link http://www.footprinthq.com/forums
 *
 * @link 		http://www.footprinthq.com/
 * @copyright 	2007-2008 Webstrong Internet Solutions
 * @author 		Iarfhlaith Kelly <ik at webstrong dot net>
 * @package 	Footprint
 * @version 	1.0
 */

/**
 * @package Footprint
 *
 */
class validator
{
   /**
    * The unique name for the form
    *
    * @var 	private string
    */
	private $formName;

   /**
    * The unique name for the page
    *
    * @var 	private string
    */
	private $pageName;

   /**
    * Gets the form name for use in SmartyValidate
    *
	* @access 	public
	* @return 	string - The name of the form
    */
	public  function getFormName()
	{
		if(empty($this->formName))
		{
			return('default');
		}
		else
		{
			return($this->formName);
		}
	}
	
   /**
    * Sets the form name for use in accessing SmartyValidate info
    *
	* @access 	public
	* @param 	string $f the form name used by SmartyValidate
	* @return 	void
    */
	public  function setFormName($f)
	{
		$this->formName = $f; 
	}

   /**
    * Gets the page name for use in SmartyValidate
    *
	* @access 	public
	* @return 	string - The name of the validated page
    */
	public  function getPage()
	{
			return($this->pageName);
	}
	
   /**
    * Sets the page name for use in SmartyValidate
    *
	* @access 	public
	* @param 	string $p the page name used by SmartyValidate
	* @return 	void
    */
	public  function setPage($p)
	{
		$this->pageName = $p; 
	}

   /**
    * The class constructor.
	*
    */
	public  function __construct(){}

   /**
    * Check if the email provided is associated with
	* a system user.
	*
	* Dependant on: SmartyValidate
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string	$email    - The user's email address
	* @param 	boolean $empty    - Optional flag, decides whether the email is optional or not
	* @param 	array 	$params   - The extra parameters provided by SmartyValidate
	* @param 	array 	$formvars - The other form variables provided by the form
	* @return 	boolean			  - True if email exists, false if not.
    */
	public function isSystemEmail($email, $empty, &$params, &$formvars)
	{
		// Test Parameters
		if (!isset($email)) return($empty);
		
		$email = cleanValue($email);
		
		$sql = "SELECT userID FROM app_users WHERE app_users.email = '{$email}'";
		
		$dbh = dbConnection::get()->handle();
		
		// Execute the query
		$result =& $dbh->query($sql);
		
		// One row or more? Excellent, then the email was found.
		if($result->numRows() >= 1)
		{
			return(true);
		}
		else
		{
			return(false);
		}
	}
	
   /**
    * Check if the email provided is associated with
	* a system user AND THE SPECIFIED ACCOUNT.
	*
	* Dependant on: SmartyValidate
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string	$email    - The user's email address
	* @param 	boolean $empty    - Optional flag, decides whether the email is optional or not
	* @param 	array 	$params   - The extra parameters provided by SmartyValidate
	* @param 	array 	$formvars - The other form variables provided by the form
	* @return 	boolean			  - True if email exists, false if not.
    */
	public function isAccountEmail($email, $empty, &$params, &$formvars)
	{
		// Test Parameters
		if (!isset($email) || !isset($formvars[$params['field2']])) return($empty);
		
		$email   = cleanValue($email);
		$accName = cleanValue($formvars[$params['field2']]);
		
		$sql = "SELECT userID FROM app_users

				INNER JOIN app_accounts ON app_users.accID = app_accounts.accID

				WHERE app_users.email     = '{$email}'
				  AND app_accounts.prefix = '{$accName}'";
		
		$dbh = dbConnection::get()->handle();
		
		// Execute the query
		$result =& $dbh->query($sql);
		
		// One row or more? Excellent, then the email was found.
		if($result->numRows() >= 1)
		{
			return(true);
		}
		else
		{
			return(false);
		}
	}

   /**
    * Check if the openID provided is associated with
	* a system user.
	*
	* Dependant on: SmartyValidate
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string	$openID   - The user's OpenID
	* @param 	boolean $empty    - Optional flag, decides whether the OpenID is optional or not
	* @param 	array 	$params   - The extra parameters provided by SmartyValidate
	* @param 	array 	$formvars - The other form variables provided by the form
	* @return 	boolean			  - True if OpenID exists, false if not.
    */
	public function isSystemOpenID($openID, $empty, &$params, &$formvars)
	{
		// Test Parameters
		if (!isset($openID)) return($empty);
		
		$openID = cleanValue($openID);
		
		$sql = "SELECT openid_url FROM app_openIDs WHERE app_openIDs.openid_url = '{$openID}'";
		
		$dbh = dbConnection::get()->handle();
		
		// Execute the query
		$result =& $dbh->query($sql);
		
		// One row or more? Excellent, then the OpenID was found.
		if($result->numRows() >= 1)
		{
			return(true);
		}
		else
		{
			return(false);
		}
	}

   /**
    * Check that the invite code provided exists and has not already been used.
	*
	* Dependant on: SmartyValidate
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string	$code     - The code
	* @param 	boolean $empty    - Optional flag, decides whether the username is optional or not
	* @param 	array 	$params   - The extra parameters provided by SmartyValidate
	* @param 	array 	$formvars - The other form variables provided by the form
	* @return 	boolean			  - True if code does not exist, false if it does.
    */
	public function isValidInviteCode($code, $empty, &$params, &$formvars)
	{
		// Test Parameters
		if (empty($code)) return($empty);
		
		$sql = "SELECT code FROM pro_invitations WHERE code = '{$code}' AND usedBy = '0'";
		
		$dbh = dbConnection::get()->handle();
		
		// Execute the query
		$result =& $dbh->query($sql);
		
		// One row or more? Then the code exists.
		if($result->numRows() >= 1)
		{
			return(true);
		}
		else
		{
			return(false);
		}
	}

   /**
    * Check that the prefix provided is unique to Footprint.
	*
	* Dependant on: SmartyValidate
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string	$prefix   - The prefix
	* @param 	boolean $empty    - Optional flag, decides whether the username is optional or not
	* @param 	array 	$params   - The extra parameters provided by SmartyValidate
	* @param 	array 	$formvars - The other form variables provided by the form
	* @return 	boolean			  - True if prefix does not exist, false if it does.
    */
	public function isUniquePrefix($prefix, $empty, &$params, &$formvars)
	{
		// Test Parameters
		if (empty($prefix)) return($empty);
		
		$sql = "SELECT prefix FROM app_accounts WHERE prefix = '{$prefix}'";
		
		$dbh = dbConnection::get()->handle();
		
		// Execute the query
		$result =& $dbh->query($sql);
		
		// One row or more? Then the prefix exists.
		if($result->numRows() >= 1)
		{
			return(false);
		}
		else
		{
			return(true);
		}
	}

  /**
    * Check that the prefix provided is valid.
    * 
    * It must be:
	*
	* - Between 2 and 45 characters
	* - Contain only A-Z 0-9 and '_' 
	* - and contain no spaces
    * 
	*
	* Dependant on: SmartyValidate
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string	$prefix   - The prefix
	* @param 	boolean $empty    - Optional flag, decides whether the username is optional or not
	* @param 	array 	$params   - The extra parameters provided by SmartyValidate
	* @param 	array 	$formvars - The other form variables provided by the form
	* @return 	boolean			  - True if prefix is valid, false if it's not.
    */
	public function isValidPrefix($prefix, $empty, &$params, &$formvars)
	{
		// Test Parameters
		if (empty($prefix)) return($empty);
		
		// Check criteria
		if (preg_match('/^[a-z\d_@\.]{2,45}$/i', $prefix))
		{
			return(true);
		}
		else
		{
			return(false);
		}
	}

   /**
    * Check that the string provided is not a valid username.
	*
	* It must be:
	*
	* - Between 5 and 45 characters
	* - Contain only A-Z 0-9 and '_' 
	* - and contain no spaces
	*
	* Dependant on: SmartyValidate
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string	$username - The username
	* @param 	boolean $empty    - not used
	* @param 	array 	$params   - not used
	* @param 	array 	$formvars - not used
	* @return 	boolean			  - True if username is valid, false if it's not
    */
	public function isValidUsername($username, $empty, &$params, &$formvars)
	{	
		// Test Parameters
		if (empty($username)) return($empty);
		
		// Check criteria
		if (preg_match('/^[a-z\d_@\.]{5,45}$/i', $username))
		{
			return(true);
		}
		else
		{
			return(false);
		}
	}
	
   /**
    * Check that the string provided is not an existing username
	* for a registered user contained within the logged user's account
	*
	* There an optional 3rd criteria that can be given when calling this 
	* method (existing userID). This will allow an existing user to submit
	* his curent username for testing in a way that will ensure it will not
	* be rejected.
	*
	* Dependant on: SmartyValidate
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string	$username - The username
	* @param 	boolean $empty    - Optional flag, decides whether the username is optional or not
	* @param 	array 	$params   - The extra parameters provided by SmartyValidate
	* @param 	array 	$formvars - The other form variables provided by the form
	* @return 	boolean			  - True if username does not exist, false if it does.
    */
	public function isUniqueUsername($username, $empty, &$params, &$formvars)
	{
		// Test Parameters
		if (empty($username)) return($empty);
		if (!isset($params['field2'])) return($empty);
		
		$accID = $params['field2'];
		
		$sql = "SELECT userID, username FROM app_users WHERE username = '{$username}' AND accID = '{$accID}'";
		
		// Exclude existing username (if it exists)
		if(isset($params['field3'])) 
		{
			$sql .= " AND userID != '{$params['field3']}'";
		}
		
		$dbh = dbConnection::get()->handle();
		
		// Execute the query
		$result =& $dbh->query($sql);
		
		// One row or more? Then the username exists.
		if($result->numRows() >= 1)
		{
			return(false);
		}
		else
		{
			return(true);
		}
	}

   /**
    * Check that the userID provided is part of the specified group and that it's also part
	* of the specified account. 
	*
	* Dependant on: SmartyValidate
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string	$userID   - The user's userID
	* @param 	boolean $empty    - Optional flag, decides whether the username is optional or not
	* @param 	array 	$params   - The extra parameters provided by SmartyValidate
	* @param 	array 	$formvars - The other form variables provided by the form
	* @return 	boolean			  - True if user is a member of the specified group, false if it isn't.
    */
	public function isUserType($userID, $empty, &$params, &$formvars)
	{
		// 1 = Designer
		// 2 = Staff
		// 3 = Client
		// 4 = Admin
		
		// M = Manager (Staff+Designer)
	
		// Test Parameters
		if (empty($userID)) return($empty);
		if (!isset($params['field2'])) return($empty);
		if (!isset($params['field3'])) $group = 3; else $group = $params['field3'];
		if (!isset($params['field4'])) $management = false; else $management = true;
		
		$accID = $params['field2'];
		
		$sql = "SELECT username FROM app_users
		
				INNER JOIN app_userGroups ON app_users.userID       = app_userGroups.userID
				INNER JOIN app_groups	  ON app_userGroups.groupID = app_groups.groupID
		
				WHERE app_users.userID = '{$userID}' AND accID = '{$accID}' AND app_groups.groupID = '{$group}'";
		
		$dbh = dbConnection::get()->handle();
		
		// Execute the query
		$result =& $dbh->query($sql);
		
		// One row or more? Then the user is in the group
		if($result->numRows() >= 1)
		{
			return(true);
		}
		elseif($management)
		{
			if($_SESSION['user']['userID'] == $userID)
			{
				return(true);
			}
		}
		else
		{
			return(false);
		}
	}
	
   /**
    * Check that the submitted file for import is in the correct format. 
	*
	* Dependant on: SmartyValidate
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string	$value    - A dummy value. Not used because we're accessing the $_FILE super global to test content.
	* @param 	boolean $empty    - Optional flag, decides whether the username is optional or not
	* @param 	array 	$params   - The extra parameters provided by SmartyValidate
	* @param 	array 	$formvars - The other form variables provided by the form
	* @return 	boolean			  - True if format is valid, false if it isn't.
    */
	public function isCorrectClientImportFormat($value, $empty, &$params, &$formvars)
	{
		$max    = 3;
		$now	= 1;
		$valid	= true;
		$_field = $params['field'];
	
		if(!isset($_FILES[$_field])) return false;
		
		// Check for format type ('csv' (Comma Separated), 'xls' (MS Excel), 'bcp' (Basecamp), 'fbs' (Freshbooks))
		if (!isset($params['field2'])) $type = 'csv'; else $type = $params['field2'];
		
		// Check file was uploaded		
		if($_FILES[$_field]['error'] == 4) return ($empty);
		
		// Check format
		switch ($type)
		{
	    case "xls":
			return(false);
	        break;
	    case "bcp":
			return(false);
	        break;
	    case "fbs":
	        return(false);
	        break;
		case "csv":
		default: 
		
			// Check MIME is application/text
			if($_FILES[$_field]['type'] != 'text/plain') return(false);
			
			// Read the first few rows
			$lines = file($_FILES[$_field]['tmp_name'], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

			foreach ($lines as $line)
			{
    			// Split each row by comma
				$arr = explode(',', $line);
				
				// Count the number of rows (should be at least 3 but no more then 5)
				if(count($arr) < 3 || count($arr) > 5) return(false);
				
				// Check that column 3 is an email address
				// to do...
				
				$now++;
				if($now >= $max) break;
			}
			
			return($valid);
		}
	}
	
   /**
    * Load the relevent messages for the form.
	* 
	* The message is determined by the state of the $valid and $success variables.
	* Returns result in either PHP or JSON formats depending on which is requested.
	*
	* Dependant on: SmartyValidate
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	boolean $valid    - The state of the form validation (true or false)
	* @param	boolean $success  - The state of the form action (success or failure)
	* @param	integer $set  	  - The set of messages to be returned. Different sets may be required on the same page. This is to support multiple actions from the one page.
	* @return 	string			  - HTML Formatted Response
    */
	public function loadResponse($valid, $success, $set='')
	{
		global $lang;
		
		$page = $this->getPage();
		
		if($valid)
		{
			if($success)
			{
				$res = array('result'  => '0'
						  , 'message'  => $lang[$page]['success'.$set]
						  , 'details'  => $lang[$page]['successText'.$set]
						  , 'options'  => $lang[$page]['options'.$set]
						  , 'style'    => 'success'
						  , 'class'    => 'good'
						  , 'redirect' => $lang[$page]['redirect'.$set]);
			}
			else
			{
				$res = array('result'  => '1'
						  , 'message'  => $lang[$page]['failure'.$set]
					      , 'details'  => $lang[$page]['failureText'.$set]
						  , 'style'    => 'warning'
						  , 'class'    => 'bad'
						  , 'redirect' => $lang[$page]['redirect'.$set]);
			}
		}
		else
		{	
			$res = array('result'  => '1'
				 	  , 'message'  => $lang[$page]['invalid'.$set]
					  , 'style'    => 'warning'
					  , 'class'    => 'bad'
					  , 'errors'   => $this->loadErrors()
					  , 'redirect' => false);
		}
		
		return($res);
	}

   /**
    * Load any errors for the form.
	* Taken from SmartyValidate session data
	*
	* Dependant on: SmartyValidate
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	string	- An array of the errors
    */
	private function loadErrors()
	{	
		$formName = $this->getFormName();
	
		$validators = array();
		
		if(isset($_SESSION['SmartyValidate'][$formName]))
		{	
			foreach($_SESSION['SmartyValidate'][$formName]['validators'] as $validator)
			{
				if(isset($validator['valid']) && !$validator['valid'])
				{
					array_push($validators, array('field' => $validator['field'], 'message' => $validator['message']));
				}
			}
		}
		
		return($validators);
	}
}
?>