<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        class.openid.inc.php
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
class openid
{
   /**
    * The OpenID URL
    *
    * @var 	private string
    */
	private $openID;

   /**
    * The UserID that the OpenID is attached to
    *
    * @var 	private string
    */
	private $userID;

   /**
    * The AccID that the OpenID is attached to
    *
    * @var 	private string
    */
	private $accID;

   /**
    * Gets the OpenID URL (from the object instance)
	* @access 	public
	* @return 	string - The name of the OpenID
    */
	public  function getOpenID()
	{
		return($this->openID);
	}
	
   /**
    * Sets the OpenID (for the object instance)
    *
	* @access 	public
	* @param 	string $openID the supplied OpenID
	* @return 	void
    */
	public  function setOpenID($openID)
	{
		// Preprocess OpenID and Canonicalize it (remove the https:// or http://).
		$parsed = parse_url($openID);

		if(isset($parsed['host']))
		{
			$res = $parsed['host'];
		}
		else
		{
			$res = $parsed['path'];
		}
		
		$this->openID = $res; 
		
		$_SESSION['user']['openID'] = $res;
	}

   /**
    * Gets the UserID (from the object instance)
	* @access 	public
	* @return 	string - The peron's userID
    */
	public  function getUserID()
	{
		return($this->userID);
	}
	
   /**
    * Sets the UserID (for the object instance)
    *
	* @access 	public
	* @param 	string $userID
	* @return 	void
    */
	public  function setUserID($userID)
	{
		$this->userID = $userID; 
	}

   /**
    * Gets the AccID (from the object instance)
	* @access 	public
	* @return 	string - The peron's accID
    */
	public  function getAccID()
	{
		return($this->accID);
	}
	
   /**
    * Sets the AccID (for the object instance)
    *
	* @access 	public
	* @param 	string $accID
	* @return 	void
    */
	public  function setAccID($accID)
	{
		$this->accID = $accID; 
	}

   /**
    * The class constructor.
	*
    */
	public  function __construct()
	{
		/**
		 * Require the OpenID consumer code.
		 */
		require_once "Auth/OpenID/Consumer.php";
	}

   /**
    * Load the userID based on the OpenID provided during OpenID Login
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	mixed	- Returns the userID if it exists, false if not.
    */
	public function loadUserID()
	{
		$openID = $this->getOpenID();
		
		$sql = "SELECT userID FROM app_openIDs WHERE app_openIDs.openid_url = '{$openID}'";
		
		$dbh = dbConnection::get()->handle();
		
		// Execute the query
		$result =& $dbh->query($sql);
		
		$userID = $result->fetchRow();
		
		// Assign to the Object Instance
		$this->setUserID($userID);
		
		return($userID);
	}

   /**
    * Load all the user's OpenIDs. There could be more then one.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	mixed	- Returns the userID if it exists, false if not.
    */
	public function loadUsersOpenIDs()
	{
		$openIDs = array();
	
		$userID = $this->getUserID();
		
		$sql = "SELECT openid_url FROM app_openIDs WHERE userID = '{$userID}'";
		
		$dbh = dbConnection::get()->handle();
		
		// Execute the query
		$result =& $dbh->query($sql);
		
		while ($row = $result->fetchRow())
		{
			array_push($openIDs, $row['openid_url']);
		}
		
		return($openIDs);
	}
	
   /**
    * Attach the selected OpenID to the selected UserID's account.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean	- True if successful, false if not.
    */
	public function attachOpenID()
	{	
		$accID  = $this->getAccID();
		$userID = $this->getUserID();
		$openID = $this->getOpenID();
		
		if(empty($userID) || empty($openID) || empty($accID)) return(false);
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "INSERT INTO app_openIDs (openid_url, accID, userID) VALUES ('{$openID}', '{$accID}', '{$userID}')";
		
		$affected =& $dbh->exec($sql);

		// Check for Error
		if (PEAR::isError($affected))
		{
    		return(false);
		}
		else
		{
			return(true);
		}
	}
	
   /**
    * Detach the selected OpenID from the selected UserID's account.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean	- True if successful, false if not.
    */
	public function detachOpenID()
	{
		$accID  = $this->getAccID();
		$userID = $this->getUserID();
		$openID = $this->getOpenID();
		
		if(empty($userID) || empty($openID) || empty($accID)) return(false);
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "DELETE FROM app_openIDs WHERE openid_url = '{$openID}'
				AND userID = '{$userID}'
				AND  accID = '{$accID}'";
		
		$affected =& $dbh->exec($sql);

		// Check for Error
		if (PEAR::isError($affected))
		{
    		return(false);
		}
		else
		{
			return(true);
		}
	}
	
   /**
    * Detach all the OpenIDs for the selected User
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean	- True if successful, false if not.
    */
	public function detachOpenIDsByUser()
	{
		$userID = getUserID();
		
		if(empty($userID)) return(false);
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "DELETE FROM app_openIDs WHERE userID = '{$userID}'";
		
		$affected =& $dbh->exec($sql);

		// Check for Error
		if (PEAR::isError($affected))
		{
    		return(false);
		}
		else
		{
			return(true);
		}
	}

   /**
    * Ensure that the OpenID is not already in use on that account.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	array $formVars - The user's login credentials
	* @return 	boolean
    */
	public  function isUnique($openID, $empty, &$params, &$formvars)
	{
		// Test Parameters
		if (!isset($openID)
		 || !isset($params['field2'])
		  ) return($empty);
		
		$accID = $params['field2'];
		
		$sql = "SELECT openid_url FROM app_openIDs WHERE openid_url = '{$openID}' AND accID = '{$accID}'";
		
		$dbh = dbConnection::get()->handle();
		
		// Execute the query
		$result =& $dbh->query($sql);
		
		// One row or more? Then the user is in the group
		if($result->numRows() >= 1)
		{
			return(false);
		}
		
		return(true);
	}
	
   /**
    * Check if a particular OpenID is owned by a particular user
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	integer	- The OpenID
	* @return 	boolean	- True or False depending on whether the OpenID is owned by the user
	*/
	public  function isOwner($openID)
	{
		$accID  = $this->getAccID();
		$userID = $this->getUserID();
		
		// Check Data Quality
		if(empty($openID) || !is_numeric($accID) || !is_numeric($userID)) return(false);
		
		// Connect to Database
		$dbh = dbConnection::get()->handle();
		
		// Build SQL
		$sql = "SELECT * FROM app_openIDs WHERE openid_url = '{$openID}'
				AND  accID = '{$accID}'
				AND userID = '{$userID}'";
		
		// Execute the query
		$result =& $dbh->query($sql);
		
		// One Row? Excellent, then the comment is owned by the author
		if($result->numRows() == 1) return(true);
		
		return(false);
	}
}

?>