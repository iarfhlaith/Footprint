<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        class.footprint.inc.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Ltd.
 *
 * This software is protected under Irish Copyright Law.
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. @link http://www.footprinthapp.com/forums
 *
 * @link 		http://www.footprintapp.com/
 * @copyright 	2007-2009 Webstrong Ltd
 * @author 		Iarfhlaith Kelly <ik at webstrong dot ie>
 * @package 	Footprint
 * @version 	1.0
 */

/**
 * @package Footprint
 *
 */
class footprint
{
   /**
    * Used to assign a staff object into footprint. 
    *
    * @var 	public object
    */
	public  $staff;
	
   /**
    * Used to assign a client object into footprint. 
    *
    * @var 	public object
    */
	public  $client;

   /**
    * Used to assign a project object into footprint. 
    *
    * @var 	public object
    */
	public  $project;	
	
   /**
    * Used to assign a document object into footprint. 
    *
    * @var 	public object
    */
	public  $document;	

   /**
    * Used to assign a screenshot object into footprint. 
    *
    * @var 	public object
    */
	public  $screenshot;

   /**
    * Used to assign a task object into footprint. 
    *
    * @var 	public object
    */
	public  $task;	
	
   /**
    * Used to assign a request object into footprint. 
    *
    * @var 	public object
    */
	public  $request;	

   /**
    * The validation object used to check business logic
	* during form validation. It's used with the SmartyValidate
	* Smarty plugin.
    *
    * @var 	public object
    */
	public  $validator;	

   /**
    * The unique name for the pagination set.
    *
    * @var 	private string
    */
	private $pageName;
	
   /**
    * The userID of the logged in person. 
    *
    * @var 	private integer
    */
	private $userID;
	
   /**
    * The accID of the logged in person.
    *
    * @var 	private integer
    */
	private $accID;

   /**
    * The account prefix. http://prefix.footprintapp.com
    *
    * @var 	private string
    */
	private $prefix;

   /**
    * The class constructor.
	*
    */
	public  function __construct(){}
	
   /**
    * Gets the page name for use in smarty pagination
    *
	* @access 	public
	* @return 	string - The name of the pagination page
    */
	public  function getPage()
	{
			return($this->pageName);
	}
	
   /**
    * Sets the page name for use in SmartyPaginate
    *
	* @access 	public
	* @param 	string $p the page name used by SmartyPaginate
	* @return 	void
    */
	public  function setPage($p)
	{
		$this->pageName = $p; 
	}

   /**
    * Gets the account prefix stored in the class instance
    *
	* @access 	public
	* @return 	string - The prefix
    */
	public  function getPrefix()
	{
			return($this->prefix);
	}
	
   /**
    * Sets the prefix in the class
    *
	* @access 	public
	* @param 	string $p The supplied account prefix
	* @return 	void
    */
	public  function setPrefix($p)
	{
		$this->prefix = $p; 
	}
	
   /**
    * Gets the userID
    *
	* @access 	public
	* @return 	boolean|integer - Returns the userID or false if unavailable
    */
	public  function getUserID()
	{
		if(!empty($this->userID))
		{
			return($this->userID);
		}
		elseif(!empty($_SESSION['user']['userID']))
		{
			return($_SESSION['user']['userID']);
		}
		else
		{
			return(false);
		}
	}
	
   /**
    * Sets the userID
	*
	* @param integer $uid - The userID of the logged in person
	*
	* @access 	public
	* @return 	void
    */
	public function setUserID($userID)
	{
		$this->userID = $userID; 
	}
	
   /**
    * Gets the accID of the logged in person
    *
	* @access 	public
	* @return 	boolean|integer - Returns the accID or false if unavailable
    */
	public  function getAccID()
	{
		if(!empty($this->accID))
		{
			return($this->accID);
		}
		elseif(!empty($_SESSION['user']['accID']))
		{
			return($_SESSION['user']['accID']);
		}
		else
		{
			return(false);
		}
	}
	
   /**
    * Sets the accID
	*
	* @access 	public
	* @param 	integer $accid - The accID of the logged in person
	* @return 	void
    */
	public function setAccID($accID)
	{
		$this->accID = $accID; 
	}

  /**
    * Check an Account exists based on the provided
    * prefix.
    * 
    * Example: webstrong.footprintapp.com
    * 
    * The prefix will contain the sub-domain name (ex: webstrong).
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string $prefix - The sub domain of the Footprint account.
	* @return 	boolean
    */
	public function accountExists($prefix)
	{
		if(empty($prefix)) return(false);
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "SELECT prefix FROM app_accounts WHERE prefix = '{$prefix}'";
		
		// Execute the query
		$res = $dbh->query($sql);
		
		// One Row? Excellent, then the account was found.
		if($res->numRows() != 1)
		{
			return(false);
		}
		else
		{
			return(true);
		}
	}

  /**
    * Load the account logo.
	*
	* Dependant on: class.db.inc.php
	*
	* 1. Check if a prefix is set. If it is load said logo from db and exit.
	* 2. Check if session has a stored logo. If it has, display it and exit.
	* 3. Check if user is logged in. If they are, load a fresh logo from db.
	* 4. Otherwise, display the default system logo.
	*
	* @access 	public
	* @param 	string  $prefix - The unique account name.
	* @return 	mixed
    */
	public function loadLogo($prefix='')
	{	
		$accID = $this->getAccID();
		$dbh   = dbConnection::get()->handle();
		
		// Reset logo if prefix is set
		if(!empty($prefix))
		{	
			$sql = "SELECT logo AS data, logoMIMEType AS mime FROM app_accounts WHERE prefix = '{$prefix}'";
			$res = $dbh->query($sql);
			$det = $res->fetchRow();
			
			array_push_associative($det, array('size' => strlen($det['data'])));
			
			$_SESSION['logo']['data'] = $det['data'];
			$_SESSION['logo']['mime'] = $det['mime'];
			$_SESSION['logo']['size'] = $det['size'];
		}
		// Otherwise load from session if that's set
		elseif(isset($_SESSION['logo']))
		{	
			$det['data'] = $_SESSION['logo']['data'];
			$det['mime'] = $_SESSION['logo']['mime'];
			$det['size'] = $_SESSION['logo']['size'];
		}
		// Or, if user is logged in, load logo
		elseif(is_numeric($accID))
		{
			$sql = "SELECT logo AS data, logoMIMEType AS mime FROM app_accounts WHERE accID = '{$accID}'";
			$res = $dbh->query($sql);
			$det = $res->fetchRow();
			
			array_push_associative($det, array('size' => strlen($det['data'])));
			
			$_SESSION['logo']['data'] = $det['data'];
			$_SESSION['logo']['mime'] = $det['mime'];
			$_SESSION['logo']['size'] = $det['size'];
		}
		
		// If image is still not found then load default
		if(!isset($det) || (isset($det) && $det['size'] < 1))
		{	
			$logo = (APP_ROOT.'/media/images/default/footprint.gif');
			
			// Assign the image to the session
			$det['data'] = file_get_contents($logo);
			$det['mime'] = 'image/gif';
			$det['size'] = filesize($logo);
			
			$_SESSION['logo']['data'] = $det['data'];
			$_SESSION['logo']['mime'] = $det['mime'];
			$_SESSION['logo']['size'] = $det['size'];
		}

		// Display Image
		header("Content-Type:   {$det['mime']}");
		header("Content-Length: {$det['size']}");
		echo ($det['data']);
	}

  /**
    * Load the main account colour (Zone A).
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string  $prefix - The unique account name.
	* @return 	mixed
    */
	public function loadAccColour($prefix='')
	{
		if(empty($prefix)) return(false);
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "SELECT cssZoneA FROM app_accounts WHERE prefix = '{$prefix}'";
		$res = $dbh->query($sql);
		$det = $res->fetchRow();
		
		return($det['cssZoneA']);
	}

   /**
    * Sends an email to the given address provided that it
	* exists within a registered Footprint account
	*
	* The email contains a unique url that will allow the user
	* to reset their password.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string $email - The email address of the user
	* @return 	boolean
    */
	public  function remind($email)
	{
		// Load User Information
		$user  = $this->loadUserFromEmail($email);
		
		// Encrypt and Encode UserID
		$crypt       = new encryption;
		$encUserID   = $crypt->encrypt(ENC_KEY, $user['userID'], 25);
		$cryptEncode = base64_encode($encUserID);

		// Build Reset URL
		$url   = 'http://'.$_SERVER['SERVER_NAME'].'/reset/?sig='.$cryptEncode;
		
		// Load Email Text
		$email = file_get_contents(APP_ROOT.'/inc/emails/english/reminder.txt');
		
		// Merge Variables into Email
		$email = str_replace('[~firstname~]'  , $user['firstname']	  , $email);
		$email = str_replace('[~username~]'   , $user['username']	  , $email);
		$email = str_replace('[~company~]'    , $user['organisation'] , $email);
		$email = str_replace('[~url~]'        , $url				  , $email);
		
		// Send Reset Email
		$mail = new mailer;
		$mail->from(SUPPORT_EMAIL, SUPPORT_NAME);
		$mail->add_recipient($user['email']);
		$mail->subject('Password Reset on '.$user['organisation'].' Account');
		$mail->message($email);
		$mail->send();
		
		return(true);
	}

   /**
    * Reset the selected user with the provided password.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	string $password  - The new password
	* @aram		string $signature - The encrypted and encoded string representing the users userID
	* @return 	boolean True if the password was reset.
    */
	public  function reset($password, $signature)
	{
		if(empty($password) || empty($signature)) return(false);
		
		$dbh = dbConnection::get()->handle();
		
		// Replace any spaces with + signs.
		$signature = str_replace(' ', '+', $signature);
		
		// Decode Signature into UserID
		$crypt      = new encryption;
		$encrypted  = base64_decode($signature);
		$userID     = $crypt->decrypt(ENC_KEY, $encrypted);
		
		if(!is_numeric($userID)) return(false);
		
		// Encrypt New Password
		$password = md5($password);
		
		// Update Users Password
		$sql = "UPDATE app_users SET password = '{$password}' WHERE userID = '{$userID}'";

		$affected = $dbh->exec($sql);

		// Check for Error
		if (PEAR::isError($affected))
		{
    		die($affected->getMessage());
		}
		
		return(true);
	}

   /**
    * Load any existing messages from the session
	*
	* Using this method as opposed to accessing the message
	* directly ensures that the message is removed afterwards and
	* is only displayed once.
	*
	* Message format:
	*
	* - Result	(boolean - 0 = ok, 1 = error)
	* - Message (string)
	* - Details (string)
	* - Options (associative array of urls & text)
	* - Errors  (string)
	* - Style	(string  - 'warning' or 'success')
	*
	* @access 	public
	* @return 	array	 - An array containing the described message format for Footprint
    */
	public  function loadMessages()
	{
		$message = false;
	
		if(isset($_SESSION['message']))
		{
			$message = $_SESSION['message'];
			unset($_SESSION['message']);	
			return($message);
		}
		else
		{
			return(false);
		}
	}	
	
   /**
    * Loads the Most Recent Log Information for the
	* logged in user.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	integer $amount - The number of records to return
	* @return 	array
    */
	public function loadRecentActivity($amount = 12)
	{
		$activity = array();
	
		$accID = $this->getAccID();
		
		$dbh = dbConnection::get()->handle();
		
		$dbh->setLimit($amount, 0);
		
		$sql = "SELECT * FROM app_history
				
				WHERE accID = '{$accID}' AND adminOnly = false
				
				ORDER BY eventDate DESC";
		
		// Execute the query
		$result = $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			array_push($activity, array('id' => $row['id']
							   ,    'action' => $row['action']
							   ,     'accID' => $row['accID']
							   , 'eventDate' => $row['eventDate']
							   ,   'comment' => html_entity_decode($row['comment'], ENT_QUOTES)
							   , 'adminOnly' => $row['adminOnly']));
		}
		
		return($activity);
	}

   /**
    * Loads the top clients for the logged user based on the 
	* number of tasks set for that client.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	integer $amount - The number of records to return
	* @return 	array
    */
	public function loadTopClients($amount = 3)
	{
		$topClients = array();
	
		$accID = $this->getAccID();
		
		$dbh = dbConnection::get()->handle();
		
		$dbh->setLimit($amount, 0);
		
		$sql = "SELECT app_users.clientOrganisation AS `client`
					 , app_users.userID             AS `clientID`
					 , count(app_tasks.title)       AS `tasks`
				
				FROM app_tasks
				
				INNER JOIN app_projects ON app_tasks.projID      = app_projects.projID
				INNER JOIN app_users    ON app_projects.clientID = app_users.userID
				
				WHERE app_projects.accID = '{$accID}'
				
				GROUP BY `client`
				
				ORDER BY `tasks` DESC";
		
		// Execute the query
		$result = $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			array_push($topClients, $row);
		}
		
		return($topClients);
	}
	
   /**
    * Loads various account statistics including no. of clients,
	* tasks, screenshots, logins,date account was created and
	* the last login of the account admin.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	
	* @return 	boolean
    */
	public function loadAccStats()
	{	
		$accID  = $this->getAccID();
		$userID = $this->getUserID();
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "SELECT app_accounts.dateCreated AS accountCreated
		
					,  app_accounts.accProjects
					,  app_accounts.accStaff
					,  app_accounts.accDiskSpace
					,  app_accounts.packageTitle
					
					, (SELECT count(*)
					    FROM app_projects
					   WHERE app_projects.accID = '{$accID}'
					  ) AS totProjects
					
					, (SELECT SUM(size) FROM app_documentVersions
						INNER JOIN app_documents ON app_documentVersions.docID = app_documents.docID
						INNER JOIN app_tasks     ON app_documents.taskID       = app_tasks.taskID
              			INNER JOIN app_projects  ON app_tasks.projID           = app_projects.projID
              		   WHERE app_projects.accID = '{$accID}'
					  ) AS totDocSpace
					
					, (SELECT SUM(size) FROM app_screenshotVersions
					    INNER JOIN app_screenshots ON app_screenshotVersions.screenshotID = app_screenshots.screenshotID
						INNER JOIN app_tasks       ON app_screenshots.taskID = app_tasks.taskID
              			INNER JOIN app_projects    ON app_tasks.projID       = app_projects.projID
              		   WHERE app_projects.accID = '{$accID}'
					  ) AS totScreenshotSpace
					
					, (SELECT count(*) FROM app_users
				  		INNER JOIN app_userGroups ON app_users.userID       = app_userGroups.userID
						INNER JOIN app_groups	  ON app_userGroups.groupID = app_groups.groupID
				   	   WHERE app_users.accID = '{$accID}' AND app_groups.groupID = '2'
					  ) AS totStaff
					
					, (SELECT count(*) FROM app_users
				  		INNER JOIN app_userGroups ON app_users.userID       = app_userGroups.userID
						INNER JOIN app_groups	  ON app_userGroups.groupID = app_groups.groupID
				   	   WHERE app_users.accID = '{$accID}' AND app_groups.groupID = '3'
					  ) AS totClients
					  
					, (SELECT count(*) FROM app_tasks
						INNER JOIN app_projects   ON app_tasks.projID       = app_projects.projID
					    INNER JOIN app_users      ON app_projects.clientID  = app_users.userID
					   WHERE app_projects.accID = '{$accID}' AND app_tasks.type = 'task'
					  ) AS totTasks
					  
					, (SELECT count(*) FROM app_screenshots
						INNER JOIN app_tasks     ON app_screenshots.taskID = app_tasks.taskID
				   		INNER JOIN app_projects  ON app_tasks.projID       = app_projects.projID
					   WHERE app_projects.accID = '{$accID}'
					  ) AS totScreenshots
					
					,  app_users.totLogins
					,  app_users.lastLogin
				
				FROM app_accounts
				
				INNER JOIN app_users ON app_accounts.accID = app_users.accID
				
				WHERE app_accounts.accID = '{$accID}' AND app_users.userID = '{$userID}'";
		
		// Execute the query
		$result = $dbh->query($sql);
		$stats  = $result->fetchRow();
		
		// Calculate the total used disk space
		$totDiskSpace = $stats['totDocSpace'] + $stats['totScreenshotSpace'];
		array_push_associative($stats, array('totDiskSpace' => $totDiskSpace));
		
		// Calculate the usage percentage
		$usage = array(
		  'usageStaff'      => (100 * ($stats['totStaff']     / $stats['accStaff']))
		, 'usageDiskSpace'  => (100 * ($stats['totDiskSpace'] / $stats['accDiskSpace']))
		, 'usageProjects'   => (100 * ($stats['totProjects']  / $stats['accProjects']))
		);
		
		// Fix issues with a zero percentage
		if($usage['usageStaff'] 	== 0) $usage['usageStaff'] 	   = 1;
		if($usage['usageDiskSpace'] == 0) $usage['usageDiskSpace'] = 1;
		if($usage['usageProjects'] 	== 0) $usage['usageProjects']  = 1;
		
		// Get the colours for the status bars
		$colours = array(
		  'colourStaff'     => $this->getStatColour($usage['usageStaff'])
		, 'colourDiskSpace' => $this->getStatColour($usage['usageDiskSpace'])
		, 'colourProjects'  => $this->getStatColour($usage['usageProjects'])
		);
		
		array_push_associative($stats, $usage);
		array_push_associative($stats, $colours);
		
		return($stats);
	}
	
   /**
    * Calculate the correct colour of the supplied
	* statistic.
	*
	* Returns: Green, Yellow or Red.
	*
	* Green:	00-33%
	* Yellow:	34-66%
	* Red:		67-100%
	*
	* @access 	private
	* @param 	float $stat - The supplied percentage
	* @return 	string      - The name of the colour to use (Green, Yellow or Red)
    */
	private function getStatColour($stat)
	{
		if($stat < 34)
		{
			$colour = 'Green';
		}
		elseif($stat > 34 && $stat < 67)
		{
			$colour = 'Yellow';
		}
		else
		{
			$colour = 'Red';
		}
		
		return($colour);
	}
	
   /**
    * Load all payment records
	*
	* @access 	public
	* @return 	array      - An array of the payment information
    */
	public function loadPaymentsReceived()
	{
		$payments = array();
		
		$accID = $this->getAccID();
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "SELECT * FROM app_payments WHERE accID = '{$accID}'";
		
		// Execute the query
		$result = $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			array_push($payments, $row);
		}
		
		return($payments);
	}
	
   /**
    * Load all upgrade records
	*
	* @access 	public
	* @return 	array      - An array of the upgrade information
    */
	public function loadUpgradeList()
	{
		$upgrades = array();
	
		$accID = $this->getAccID();
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "SELECT * FROM app_upgrades WHERE accID = '{$accID}'";
		
		// Execute the query
		$result = $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			array_push($upgrades, $row);
		}
		
		return($upgrades);
	}
	
   /**
    * Load the status of the accounts API
	*
	* Checks if it's turned on or off.
	*
	* @access 	public
	* @return 	boolean	- true or false depending on the API status
    */
	public function loadApiStatus()
	{
		$accID = $this->getAccID();
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "SELECT api FROM app_accounts WHERE accID = '{$accID}'";
		
		// Execute the query
		$result = $dbh->query($sql);
		
		$row = $result->fetchRow();
		
		return($row['api']);
	}

   /**
    * Set the status of the accounts API
	*
	* Set it to either on or off.
	*
	* @access 	public
	* @param	boolean	$switch - On or Off depending which way to set the API.
	* @return	void
    */
	public function setApiStatus($switch)
	{
		$accID = $this->getAccID();
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "UPDATE app_accounts SET api = '{$switch}' WHERE accID = '{$accID}'";
		
		$affected = $dbh->exec($sql);
	}

   /**
    * Load the billing information for the account
	*
	* Includes address and credit card information
	*
	* @access 	public
	* @return 	array	- an associative array of the address and billing details
    */
	public function loadBillingInfo()
	{
		$accID = $this->getAccID();
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "SELECT addCountry
					  ,addStreet
					  ,addCity
					  ,addState
					  ,addZipCode
					  ,email
					  ,ccType
					  ,ccName
					  ,ccExp
					  ,ccNumber
					  
				FROM app_accounts WHERE accID = '{$accID}'";
		
		// Execute the query
		$result = $dbh->query($sql);
		
		$row = $result->fetchRow();
		
		// Create number mask
		if(strlen($row['ccNumber']) == 16)
		{
			$ccMask = '************'.$row['ccNumber']{12}.$row['ccNumber']{13}.$row['ccNumber']{14}.$row['ccNumber']{15};
			
			array_push_associative($row, array('ccMask' => $ccMask));
		}
		
		return($row);
	}
	
   /**
    * Login the user in to Footprint
	*
    * Takes the account name, the username and the password
	* via the $formVars variable and checks it against all
	* the users in the system.
	*
	* If a user is found with matching credentials then
	* the users key information is set to the session['user']
	* variable.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	array   $formVars - The user's login credentials
	* @param 	boolean $encrypt  - Optional parameter which sets whether the submitted password will be encrypted or not.
	* @return 	boolean
    */
	public  function login($formVars, $encrypt=true)
	{	
		// Test the username and password parameters
		if (empty($formVars['account']) || empty($formVars['username']) || empty($formVars['password']))
		{
			return(false);
		}
	
		// Create a digest of the password
		if($encrypt)
		{
			$passwordDigest = md5(trim($formVars['password']));
		}
		else
		{
			$passwordDigest = $formVars['password'];
		}
	
		// Formulate the SQL find the user
		$sql = "SELECT app_users.`password`
					 , app_users.`userID`
					 , app_users.`accID`
					 , app_users.`username`
					 , app_users.`firstname`
					 , app_users.`lastname`
					 , app_users.`email`
					 , app_users.`clientOrganisation`
					 , app_accounts.`prefix`
					 , app_accounts.`organisation`
					 , app_accounts.`accDiskSpace`
					 , app_accounts.`accStaff`
					 , app_accounts.`accProjects`
					 , app_accounts.`cssZoneA`
					 , app_accounts.`cssZoneB`
					 , app_accounts.`cssZoneC`
					 , app_accounts.`cssZoneD`
					 , app_accounts.`cssScheme`
					 , app_accounts.`rssKey`
					 , app_accounts.`ownerID`
					 , tmp_owner.firstname  AS ownerFirstname
					 , tmp_owner.lastname   AS ownerLastname
					 , tmp_owner.email      AS ownerEmail
					 , app_timezones.`code` AS timezone
					 , app_timezones.`id`   AS tzID
					 , app_groups.groupName
					 , app_groups.groupID
								
				FROM app_users
				
				INNER JOIN app_accounts           ON app_users.accID      = app_accounts.accID
				INNER JOIN app_users AS tmp_owner ON app_accounts.ownerID = tmp_owner.userID
				LEFT OUTER JOIN app_timezones     ON app_timezones.id     = app_accounts.timezone
				
				INNER JOIN app_userGroups ON app_users.userID       = app_userGroups.userID
				INNER JOIN app_groups     ON app_userGroups.groupID = app_groups.groupID 
				
				WHERE app_users.username  = '{$formVars['username']}'
				  AND app_users.password  = '{$passwordDigest}'
				  AND app_accounts.prefix = '{$formVars['account']}'";
		
		$dbh = dbConnection::get()->handle();
		
		// Execute the query
		$result = $dbh->query($sql);
		
		// One Row? Excellent, then the user was found.
		if($result->numRows() != 1)
		{	
			return(false);
		}
		else
		{
			$details = $result->fetchRow();
			
			// Assign UserID/AccID to Class Variable
			$this->setAccID($details['accID']);
			$this->setUserID($details['userID']);
			
			// Cache User Details and Permissions into Session
			$_SESSION['user']           = $details;
			$_SESSION['user']['userIP'] = $_SERVER["REMOTE_ADDR"];
			$_SESSION['user']['perms']  = $this->loadPermissions($details['userID']);
			
			// Update 'Last Login' and 'Total Login'
			$this->updateLoginLog();
			
			// Update Activity Log
			$this->updateActivityLog('login');
			
			return(true);
		}
	}
	
   /**
    * Login Wrapper for use with SmartyValidate
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	array $formVars - The user's login credentials
	* @return 	boolean
    */
	public  function loginWrapper($account, $empty, &$params, &$formvars)
	{
		// Test Parameters
		if (!isset($account)
		 || !isset($formvars[$params['field2']])
		 || !isset($formvars[$params['field3']])
		  ) return($empty);
		
		$formVars = array(
			'account' => cleanValue($account)
		 , 'username' => cleanValue($formvars[$params['field2']])
		 , 'password' => cleanValue($formvars[$params['field3']])
		);
		
		return($this->login($formVars));
	}
	
	public function loginByOpenID($openID, $prefix)
	{
		if(empty($openID) || empty($prefix)) return(false);
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "SELECT app_users.`username`, app_users.`password`, app_accounts.prefix AS account

				FROM app_openIDs

				INNER JOIN app_users    ON app_openIDs.userID = app_users.userID
        		INNER JOIN app_accounts ON app_users.accID    = app_accounts.accID

        		WHERE app_openIDs.openid_url = '{$openID}'
				  AND app_accounts.prefix    = '{$prefix}'";
		
		// Execute the query
		$res = $dbh->query($sql);	
		
		return($this->login($res->fetchRow(), false));
	}
	
   /**
    * Update the user's login log details
	*
    * Increment the total number of logins for the user.
	* Update the last login date.
	* Make a note of the login in the system history table.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	private
	* @return 	boolean
    */
	private function updateLoginLog()
	{
		$accID  = $this->getAccID();
		$userID = $this->getUserID();
		
		$dbh = dbConnection::get()->handle();
		
		$now = time();
		
		// Update Total Number of Logins
		$sql = "UPDATE app_users SET totLogins = totLogins+1, lastLogin = '{$now}' WHERE userID = '{$userID}'";

		$affected = $dbh->exec($sql);

		// Check for Error
		if (PEAR::isError($affected))
		{
    		die($affected->getMessage());
		}
		
		return(true);
	}
	
   /**
    * Create a New Account on Footprint
	*
    * Provided information includes:
    * 
    * - Name
    * - Email
    * - Username
    * - Password
    * - Company
    * - Country
    * - Timezone
    * - Prefix
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	array	- The form variables provided by the user
	* @return 	integer - The new accounts accID
    */
	public function signupBeta($vars)
	{
		// Timestamp
		$timestamp = time();
	
		// Encrypt Password
		$md5pass = md5($vars['password']);
		
		// Extract Firstname & Lastname
		$lastname  = extractNames($vars['name'], 'lastname');
		$firstname = extractNames($vars['name'], 'firstname');
		
		$dbh   = dbConnection::get()->handle();

		// Create System Account
		// *************************************************************
		$sql = "INSERT INTO app_accounts 
				 ( organisation
				 , prefix
				 , timezone
				 , accDiskSpace
				 , accStaff
				 , accProjects
				 , addCountry
				 , email
				 , dateCreated
				 )
				 
				 VALUES
				 ('{$vars['company']}'
				 ,'{$vars['prefix']}'
				 ,'{$vars['timezone']}'
				 ,'1.07375e+09'
				 ,'3'
				 ,'50'
				 ,'{$vars['country']}'
				 ,'{$vars['email']}'
				 ,'{$timestamp}'
				 )";
		
		$affected = $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch AccID
		$accID = $dbh->lastInsertID('app_accounts', 'accID');
		
		// Create New User
		// *************************************************************
		$sql = "INSERT INTO app_users
				 ( accID
				 , username
				 , password
				 , firstname
				 , lastname
				 , email
				 , createdOn
				 )
				 
				 VALUES
				 ('{$accID}'
				 ,'{$vars['username']}'
				 ,'{$md5pass}'
				 ,'{$firstname}'
				 ,'{$lastname}'
				 ,'{$vars['email']}'
				 ,'{$timestamp}'
				 )";
		
		$affected = $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch UserID
		$userID = $dbh->lastInsertID('app_users', 'userID');
		
		// Add User to Designers Group
		// *************************************************************
		$sql = "INSERT INTO app_userGroups (userID, groupID) VALUES ('{$userID}', '1')";
		
		$affected = $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Make New User the Account Owner
		// *************************************************************
		$sql = "UPDATE app_accounts SET ownerID = '{$userID}' WHERE accID = '{$accID}'";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);

		return($accID);
	}
	
   /**
    * Update the activity log
	*
    * Update the activity log for the user's account.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	string	- The action name for the activity being logged.
	* @param	integer	- (optional) The unique identifier of the new activity item
	* @return 	boolean - Success or Failure
    */
	public  function updateActivityLog($action, $id='')
	{
		$accID  = $this->getAccID();
		$userID = $this->getUserID();
		$info   = $this->loadUserInfo();
		$view   = false;
		
		$dbh = dbConnection::get()->handle();
		
		$now = time();
		
		// Set for Group
		switch ($info['groupID'])
		{
		case 3:		// Client
			$view = false;
			$org  = $info['clientOrganisation'];
			$url  = "/app/clientView.php?id={$userID}";
			break;
			
		case 2:		// Staff
			$view = false;
			$org  = $info['organisation'];
			$url  = "/app/staffView.php?id={$userID}";
			break;
			
		case 1:		// Designer
			$view = true;
			$org  = $info['organisation'];
			$url  = "/app/settings1.php";
			break;
		}
		
		// Determine the Action Type
		switch ($action)
		{
		case "login":
		
			$comment = "<a href='{$url}'>{$info['groupName']} Login</a> by {$org} ({$info['lastname']}, {$info['firstname']})";
			break;
		
		case "staffNew":
			
			$view = false;
			$comment = "<a href='/app/staff.php'>New Staff</a> for {$org} ({$info['lastname']}, {$info['firstname']})";
			break;
			
		case "staffEdit":
		
			$view = false;
			$comment = "<a href='/app/staff.php'>Staff Info Updated</a> for {$org} ({$info['lastname']}, {$info['firstname']})";
			break;
			
		case "clientNew":
		
			$view = false;
			$comment = "<a href='/app/clients.php'>New Client</a> for {$org} ({$info['lastname']}, {$info['firstname']})";
			break;
		
		case "clientEdit":
		
			$view = false;
			$comment = "<a href='/app/clients.php'>Client Info Updated</a> for {$org} ({$info['lastname']}, {$info['firstname']})";
			break;
		
		case "projectNew":
		
			$view = false;
			$comment = "<a href='/app/projects.php'>New Project</a> for {$org} ({$info['lastname']}, {$info['firstname']})";
			break;
			
		case "projectEdit":
		
			$view = false;
			$comment = "<a href='/app/projects.php'>Project Info Updated</a> for {$org} ({$info['lastname']}, {$info['firstname']})";
			break;
		
		case "taskCommentNew":
		
			$view    = false;
			$comment = "<a href='/app/taskView.php?id={$id}'>New Comment Added</a> by {$info['firstname']} {$info['lastname']}";
			break;
		
		case "requestReject":
		
			$view    = false;
			$comment = "<a href='/app/requestView.php?id={$id}'>A Request was Rejected</a> by {$info['firstname']} {$info['lastname']}";
			break;
		
		case "requestConvert":
		
			$view    = false;
			$comment = "<a href='/app/taskView.php?id={$id}'>A Request was Upgraded to a Task</a> by {$info['firstname']} {$info['lastname']}";
			break;
		
		case "taskNew":
		
			$view    = false;
			$comment = "<a href='/app/tasks.php'>New Task</a> created by {$org}";
			break;
		
		case "taskEdit":
		
			$view    = false;
			$comment = "<a href='/app/tasks.php'>Task Info Updated</a> by {$org}";
			break;
		
		case "requestNew":
		
			$view    = false;
			$comment = "<a href='/app/tasks.php'>New Request</a> created by {$org}";
			break;
		
		case "requestEdit":
		
			$view    = false;
			$comment = "<a href='/app/requests.php'>Request Updated</a> created by {$org}";
			break;
		
		case "documentNew":
		
			$view    = false;
			$comment = "<a href='/app/documentVersions.php?id={$id}'>New Document Uploaded</a> by {$info['firstname']} {$info['lastname']}";
			break;
		
		case "documentUpdate":
		
			$view    = false;
			$comment = "<a href='/app/documentVersions.php?id={$id}'>Document Updated</a> by {$info['firstname']} {$info['lastname']}";
			break;
		
		case "screenshotCommentNew":
		
			$view    = false;
			$comment = "<a href='/app/screenshotView.php?id={$id}'>New Comment Added</a> by {$info['firstname']} {$info['lastname']}";
			break;
		
		case "screenshotNew":
		
			$view    = false;
			$comment = "<a href='/app/screenshotView.php?id={$id}'>New Screenshot Uploaded</a> by {$info['firstname']} {$info['lastname']}";
			break;
		}

		$com = cleanValue($comment);
		
		$sql = "INSERT INTO app_history (action, accID, eventDate, comment, adminOnly)
				
				VALUES ('{$action}', '{$accID}', '$now', '$com', '$view')";
		
		$affected = $dbh->exec($sql);

		// Check for Error
		if (PEAR::isError($affected))
		{
    		die($affected->getMessage());
		}
		
		return(true);
	}

   /**
    * Load Basic User Information
	*
    * If the user information exists in the session then
	* it is loaded in from there. If not, then it is loaded
	* in from the users table in the system database.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	array - Associative Array of User Info
    */
	public function loadUserInfo()
	{
		if(isset($_SESSION['user']))
		{
			return($_SESSION['user']);
		}
		else
		{
			$userID = $this->getUserID();
		
			// Load the User Details
			$sql = "SELECT app_users.`password`
					 	 , app_users.`userID`
					 	 , app_users.`accID`
					 	 , app_users.`username`
					 	 , app_users.`firstname`
					 	 , app_users.`lastname`
					 	 , app_users.`email`
						 , app_users.`clientOrganisation`
					 	 , app_accounts.`prefix`
					 	 , app_accounts.`organisation`
					 	 , app_accounts.`cssZoneA`
					 	 , app_accounts.`cssZoneB`
					 	 , app_accounts.`cssZoneC`
					 	 , app_accounts.`cssZoneD`
						 , app_accounts.`cssScheme`
					 	 , app_timezones.`code`
					 	 , app_timezones.`id` as tzID
						 , app_groups.groupName
					 	 , app_groups.groupID
								
					FROM app_users
					
					INNER JOIN app_accounts   ON app_users.accID        = app_accounts.accID
					INNER JOIN app_timezones  ON app_timezones.id       = app_accounts.timezone
					
					INNER JOIN app_userGroups ON app_users.userID       = app_userGroups.userID
					INNER JOIN app_groups     ON app_userGroups.groupID = app_groups.groupID 
					
					WHERE app_users.userID = '{$userID}'";
					
			$dbh = dbConnection::get()->handle();
		
			// Execute the query
			$result = $dbh->query($sql);
			
			return($result->fetchRow());
		}
	}	

   /**
    * Load User Information based on their email address (and account name)
	*
    * If the user information exists in the session then
	* it is loaded in from there. If not, then it is loaded
	* in from the users table in the system database.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	string - Email of user's account
	* @return 	array  - Associative Array of User Info
    */
	public function loadUserFromEmail($email)
	{
		$prefix = $this->getPrefix();
		
		if(empty($email) || empty($prefix)) return(false);
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "SELECT userID FROM app_users

				INNER JOIN app_accounts ON app_users.accID = app_accounts.accID

				WHERE app_users.email     = '{$email}'
				  AND app_accounts.prefix = '{$prefix}'";
		
		$res = $dbh->query($sql);
			
		$row = $res->fetchRow();
		
		$this->setUserID($row['userID']);
		
		return($this->loadUserInfo());
	}

   /**
    * Loads all assigned permissions for the logged user
	*
	* The permissions will be loaded based on which group(s)
	* the user is assigned to.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	private
	* @return 	array - An associative array of the loaded permissions
	*/
	private function loadPermissions()
	{
		$perms = array();
		
		$uid   = $this->getUserID();
		
		$dbh   = dbConnection::get()->handle();
	
		$sql   = "SELECT DISTINCT permission
					
				  FROM app_userGroups AS ug
				  
				  INNER JOIN app_groupPerms  AS gp ON gp.groupID = ug.groupID
				  INNER JOIN app_permissions AS p  ON p.permID   = gp.permID
	
				  WHERE ug.userID = '{$uid}'";
		
		// Execute the query
		$result = $dbh->query($sql);
			
		while ($row = $result->fetchRow())
		{
			array_push_associative($perms, array($row['permission'] => true));
		}
		
		return($perms);
	}
	
   /**
    * Checks if a given permission is assigned to the logged user
	*
	* If the list of assigned permissions don't exist in the
	* session then they're loaded in from the database.
	*
	* @access 	public
	* @param 	string $perm - The name of the permission that needs checking
	* @return 	boolean
	*/
	public  function checkPermission($perm)
	{	
		$check  = false;
		
		if (!isset($_SESSION['user']['perms']))
		{
			$_SESSION['user']['perms'] = $this->loadPermissions();
		}
	
		if (isset($_SESSION['user']['perms']))
		{
			if (array_key_exists($perm, $_SESSION['user']['perms']))
			{
				$check = true;
			}
		}
		
		return($check);
	}
	
   /**
    * Checks if a restricted limit has been reached or not.
	*
	* Currently there are limits on: Staff, Projects, Diskspace
	*
	* Accepted types are: 'staff', 'projects', 'diskspace'
	*
	* @access 	public
	* @param 	string $type - The name of the restricted limit type that needs checking
	* @return 	boolean		 - Whether or not the specified limit has been reached
	*/
	public  function checkLimits($type)
	{
		$within = true;
		$stats  = $this->loadAccStats();
		
		switch ($type)
		{
		case 'staff':
			
			if($stats['totStaff'] 	  >= $stats['accStaff']) 	 $within = false;
			break;
			
		case 'projects':
			
			if($stats['totProjects']  >= $stats['accProjects'])	 $within = false;
			break;
			
		case 'diskspace':

			if($stats['totDiskSpace'] >= $stats['accDiskSpace']) $within = false;
			break;
		}
		
		return($within);
	}

   /**
    * Check if the user is logged into Footprint
	*
	* Check if the user's session exists and that the IP of the user
	* is the same as the one that set the session in the first place.
	* This protects against session hijacking.
	*
	* The method will redirect the user to the Footprint login page
	* if they are not authenticated.
	*
	* @access 	public
	* @return 	void
	*/
	public  function authenticate($method='session')
	{	
		if($method == 'http')
		{	
			// Use HTTP Authentication
			require_once('Auth/HTTP.php');
			
			$options = array('dsn'	=> 'mysql://footpr1_user:lamenux@84.51.233.254/footpr1_db'
				,       'table'	=> 'app_users'
				, 'usernamecol'	=> 'username'
				, 'passwordcol'	=> 'password'
				,   'cryptType'	=> 'md5'
				,   'db_fields' => '*');
			
			$a = new Auth_HTTP("MDB2", $options);
			
			$a->setCancelText('<h2>Login Failed</h2>');
			$a->setRealm('Protected RSS Feed');
			
			$a->start();
			
			if($a->getAuth())
			{
				// Set UserID and AccID
				$this->setAccID($a->getAuthData('accid'));
				$this->setUserID($a->getAuthData('userid'));
				
				$result = true;
			}
			else
			{
				$result = false;
			}
				
			return($result);
		}
		else
		{		
			// Use Session Authentication
			if (!isset($_SESSION['user']))
			{	
				header('Location: http://'.$_SERVER['HTTP_HOST'].'/login/');
				exit;
			}
	
			// Check if the request is from a different IP address to previously
			if (!isset($_SESSION['user']['userIP']) || ($_SESSION['user']['userIP'] != $_SERVER['REMOTE_ADDR']))
			{
				// The request did not originate from the machine
				// that was used to create the session.
				// THIS IS POSSIBLY A SESSION HIJACK ATTEMPT
	
				header("Location: http://".$_SERVER['HTTP_HOST']."/login/");
				exit;
			}
		}	
	}
	
   /**
    * Loads all the available timezones listed in the database
	*
	* This is used anywhere in the application that needs a list of
	* the global timezones. It's used to set a user's personal
	* timezone to their local time.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	integer	- (optional )The ID of a specific timezone to return
	* @return 	array	- An associative array of the global timezones
	*/
	public  function loadTimezones($id=NULL)
	{
		$zones = array();
		
		$dbh   = dbConnection::get()->handle();
	
		$sql   = "SELECT id, text, code FROM app_timezones";
		
		if(is_numeric($id))
		{
			$sql .= " WHERE id = '{$id}'";
			
			// Execute the query
			$result = $dbh->query($sql);
				
			return($result->fetchRow());
		}
		else
		{
			// Execute the query
			$result = $dbh->query($sql);
				
			while ($row = $result->fetchRow())
			{
				array_push_associative($zones, array($row['id'] => $row['text']));
			}
		
			return($zones);
		}
	}

   /**
    * Loads all the staff listed in the logged user's account
	*
	* This allows a designer to view all of their staff that
	* have been added to their Footprint account.
	*
	* Dependant on: SmartyPaginate, class.db.inc.php
	* 
	* @access 	public
	* @param	boolean - Optional parameter that decides if a detailed list should be provided
	* @return 	array 	- An associative array of the designer's staff
	*/
	public  function loadAllStaff($details=true, $paginate=false)
	{
		$staff  = array();
		$pName  = $this->getPage();
		$accID  = $this->getAccID();
		
		$dbh    = dbConnection::get()->handle();
		
		$clause = " FROM app_users
				  
				  	INNER JOIN app_userGroups ON app_users.userID       = app_userGroups.userID
					INNER JOIN app_groups	  ON app_userGroups.groupID = app_groups.groupID
				  
				  WHERE app_users.accID = '{$accID}' AND app_groups.groupID = '2'";
		
		if($paginate)
		{
			$sql	= "SELECT count(*) AS total {$clause}";
		
			$result = $dbh->query($sql);
			$count  = $result->fetchRow();
		
			SmartyPaginate::setTotal($count['total'], $pName);
			$dbh->setLimit(SmartyPaginate::getLimit($pName), SmartyPaginate::getCurrentIndex($pName));
		}
		
		$sql   = "SELECT  app_users.userID
						, app_users.firstname
						, app_users.lastname";
		
		if($details)
		{
			$sql .= " , app_users.email
					  , app_users.lastLogin";
		}
		
		$sql .= $clause;
		
		$result = $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			if($details)
			{
				array_push($staff, $row);
			}
			else
			{
				array_push_associative($staff, array($row['userID'] => $row['firstname'].' '.$row['lastname']));
			}
		}
		
		return($staff);
	}
	
   /**
    * Loads all the clients listed in the logged user's account
	*
	* This will return an array of clients for the logged user in
	* paginated chunks. 
	*
	* Dependant on: SmartyPaginate, class.db.inc.php
	*
	* @access 	public
	* @param	boolean 	- Optional parameter that decides if a detailed list should be provided
	* @param	boolean		- Optional parameter [NOT IN USE] that filters all but the clients who have projects assigned to the logged user
	* @param	boolean		- Optional parameter to prevent the method from paginating the results	
	* @param	boolean		- Optional parameter to filter for only clients that have a project created for them
	* @return 	array 		- An associative array of all the clients for the logged user's account
	*/
	public  function loadClients($details=true, $assignedOnly=false, $paginate=true, $onlyWithProjects=false)
	{	
		$users  = array();
		$pName  = $this->getPage();
		$accID  = $this->getAccID();
		$join   = '';
		
		$dbh    = dbConnection::get()->handle();
		
		$clause = "FROM app_users
				  
				  	INNER JOIN app_userGroups ON app_users.userID       = app_userGroups.userID
					INNER JOIN app_groups	  ON app_userGroups.groupID = app_groups.groupID
				  
				   WHERE app_users.accID = '{$accID}' AND app_groups.groupID = '3'";
		
		if($onlyWithProjects)
		{
			$clause .= " AND (SELECT count(*) FROM app_projects WHERE clientID = app_users.userID) > 0";
		}
		
		if($paginate)
		{
			$sql	= "SELECT count(*) AS total {$clause}";
		
			$result = $dbh->query($sql);
			$count  = $result->fetchRow();
		
			SmartyPaginate::setTotal($count['total'], $pName);
			$dbh->setLimit(SmartyPaginate::getLimit($pName), SmartyPaginate::getCurrentIndex($pName));
		}
		
		$sql    = "SELECT app_users.userID, app_users.clientOrganisation, app_users.firstname, app_users.lastname ";
		
		if($details)
		{
			$sql .= ", app_users.email
					 , app_users.lastLogin ";
		}
		
		$sql .= $clause.' ORDER BY app_users.clientOrganisation ASC';
		
		$result = $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			if($details)
			{
				array_push($users, $row);
			}
			else
			{
				if(empty($row['clientOrganisation']))
				{
					$tag = $row['lastname'].', '.$row['firstname'];
				}
				else
				{
					$tag = $row['clientOrganisation'];
				}
			
				array_push_associative($users, array($row['userID'] => $tag));
			}
		}
		
		return($users);
	}
	
   /**
    * Loads all the assigned clients listed in the logged user's account
	*
	* This will return an array of clients for the logged user in
	* paginated chunks. It's primary use is for staff accounts. These account types
	* only have permission to access client information for projects they're
	* assigned to.
	*
	* Dependant on: SmartyPaginate, class.db.inc.php
	*
	* @access 	public
	* @param	boolean 	- Optional parameter that decides if a detailed list should be provided
	* @param	boolean		- Optional parameter to prevent the method from paginating the results
	* @param	boolean		- Optional parameter to filter for only clients that have a project created for them
	* @return 	array 		- An associative array of the logged user's assigned clients
	*/
	public  function loadAssignedClients($details=true, $paginate=true, $onlyWithProjects=false)
	{	
		$users  = array();
		$pName  = $this->getPage();
		$accID  = $this->getAccID();
		$userID = $this->getUserID();
		
		$dbh    = dbConnection::get()->handle();
		
		$clause = " FROM app_users

					LEFT OUTER JOIN app_projects ON app_users.userID    = app_projects.clientID

					INNER JOIN app_staffProjects ON app_projects.projID = app_staffProjects.projectID

					INNER JOIN app_users AS tmp_staff ON app_staffProjects.staffID = tmp_staff.userID

                   WHERE tmp_staff.userID = '{$userID}' AND app_users.accID = '{$accID}'";
		
		if($onlyWithProjects)
		{
			$clause .= " AND (SELECT count(*) FROM app_projects WHERE clientID = app_users.userID) > 0";
		}
		
		if($paginate)
		{
			$sql	= "SELECT count(*) AS total {$clause}";
		
			$result = $dbh->query($sql);
			$count  = $result->fetchRow();
		
			SmartyPaginate::setTotal($count['total'], $pName);
			$dbh->setLimit(SmartyPaginate::getLimit($pName), SmartyPaginate::getCurrentIndex($pName));
		}
		
		$sql    = "SELECT app_users.userID, app_users.clientOrganisation, app_users.firstname, app_users.lastname";
		
		if($details)
		{
			$sql .= ", app_users.email
					 , app_users.lastLogin ";
		}
		
		$sql .= $clause;
		
		$result = $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			if($details)
			{
				array_push($users, $row);
			}
			else
			{
				if(empty($row['clientOrganisation']))
				{
					$tag = $row['lastname'].', '.$row['firstname'];
				}
				else
				{
					$tag = $row['clientOrganisation'];
				}
			
				array_push_associative($users, array($row['userID'] => $tag));
			}
		}
		
		return($users);
	}
	
   /**
    * Loads information for the selected client
	*
	* This will return an array of the client's information.
	*
	* The difference between this method and client->loadClient() is that this method
	* checks if any of the client's projects are assigned to the staff member.
	* If they aren't, then the method will return false.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	integer 	- The clientID of the requested client
	* @return 	array 		- An associative array of all selected the client's information.
	*/
	public  function loadAssignedClient($cid)
	{	
		$userID = $this->getUserID();
	
		$dbh   = dbConnection::get()->handle();
		
		$sql   = "SELECT  app_users.userID
						, app_users.username
						, app_users.firstname
						, app_users.lastname
						, app_users.email
						, app_users.lastLogin
						, app_users.totLogins
						, app_users.createdOn
						, app_users.clientOrganisation
					
					FROM app_users
					
					LEFT OUTER JOIN app_projects ON app_users.userID    = app_projects.clientID

					INNER JOIN app_staffProjects ON app_projects.projID = app_staffProjects.projectID

					INNER JOIN app_users AS tmp_staff ON app_staffProjects.staffID = tmp_staff.userID

                  WHERE tmp_staff.userID = '{$userID}' AND app_users.userID = '{$cid}'";
		
		$result = $dbh->query($sql);
		
		return($result->fetchRow());
	}	
	
   /**
    * Loads information for both staff and the designer
	* so that they can have their information put together
	* for the list of people who can manage a project.
	*
	* This will return an array of the management's details.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	array 		- An associative array of all selected the user's information.
	*/
	public  function loadManagement()
	{
		// Load Staff and Designer
		$staff      = $this->loadAllStaff(false);
		$designer   = array($_SESSION['user']['userID'] => $_SESSION['user']['firstname'].' '.$_SESSION['user']['lastname']);
		
		return($designer + $staff);
	}
	
   /**
    * Loads all the projects listed in the logged user's account
	*
	* This will return an array of projects for the logged user in
	* paginated chunks.
	*
	* Dependant on: SmartyPaginate, class.db.inc.php
	*
	* @access 	public
	* @param	integer 	- An optional clientID that will force the method to filter for that client only
	* @param	boolean 	- An optional flag to prevent the full project details being displayed
	* @param	boolean 	- An optional flag to prevent the result from being paginated
	* @return 	array 		- An associative array of all the projects for the logged user's account
	*/
	public  function loadAllProjects($client='', $details=true, $paginate=true)
	{	
		$projects = array();
		$pName    = $this->getPage();
		$accID    = $this->getAccID();
		
		$dbh      = dbConnection::get()->handle();
		
		$clause = "FROM app_projects
					
				   INNER JOIN app_users AS tmp_designers ON app_projects.assignedTo = tmp_designers.userID
				   INNER JOIN app_users ON app_projects.clientID = app_users.userID
					
				   WHERE app_projects.accID = '{$accID}'";
		
		if(is_numeric($client))
		{
			$clause .= " AND app_projects.clientID = {$client}";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $clause .= " AND app_projects.visibility = '1'";
		}
		
		$sql	= "SELECT count(*) AS total {$clause}";
		
		$result = $dbh->query($sql);
		$count  = $result->fetchRow();
		
		if($paginate)
		{
			SmartyPaginate::setTotal($count['total'], $pName);
			$dbh->setLimit(SmartyPaginate::getLimit($pName), SmartyPaginate::getCurrentIndex($pName));
		}
		
		$sql	= "SELECT  app_projects.name
				  , app_projects.dateCreated
				  , app_projects.projID
				  , app_projects.description
				  , tmp_designers.firstname
				  , tmp_designers.lastname
				  , app_users.userID
				  , CONCAT(app_users.lastname, ', ', app_users.firstname) as userFullname
				  , app_users.clientOrganisation {$clause} ORDER BY app_projects.projID DESC";
		
		$result = $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			if($details)
			{
				array_push($projects, $row);
			}
			else
			{
				array_push_associative($projects, array($row['projID'] => $row['name']));
			}
		}
		
		return($projects);
	}
	
   /**
    * Loads all the assigned projects listed in the logged user's account
	*
	* This will return an array of projects for the logged user in
	* paginated chunks. It's primary use is for staff accounts. These account types
	* only have permission to access projects that they have been assigned to.
	*
	* Dependant on: SmartyPaginate, class.db.inc.php
	*
	* @access 	public
	* @param	integer 	- An optional clientID that will force the method to filter for that client only
	* @param	boolean 	- An optional flag to prevent the full project details being displayed
	* @param	boolean 	- An optional flag to prevent the result from being paginated
	* @return 	array 		- An associative array of all the logged user's assigned projects
	*/
	public  function loadAssignedProjects($client='', $details=true, $paginate=true)
	{	
		$projects  = array();
		$pName     = $this->getPage();
		$accID     = $this->getAccID();
		$userID    = $this->getUserID();
		
		$dbh    = dbConnection::get()->handle();
		
		$clause = "FROM app_projects

           			INNER JOIN app_staffProjects          ON app_projects.projID       = app_staffProjects.projectID
           			INNER JOIN app_users AS tmp_staff     ON app_staffProjects.staffID = tmp_staff.userID
           			INNER JOIN app_users AS tmp_designers ON app_projects.assignedTo   = tmp_designers.userID
				    INNER JOIN app_users                  ON app_projects.clientID     = app_users.userID

				   WHERE tmp_staff.userID = '{$userID}' AND app_projects.accID = '{$accID}'";
		
		if(is_numeric($client))
		{
			$clause .= " AND app_projects.clientID = {$client}";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $clause .= " AND app_projects.visibility = '1'";
		}
		
		$sql	= "SELECT count(*) AS total {$clause}";
		
		$result = $dbh->query($sql);
		$count  = $result->fetchRow();
		
		if($paginate)
		{
			SmartyPaginate::setTotal($count['total'], $pName);
			$dbh->setLimit(SmartyPaginate::getLimit($pName), SmartyPaginate::getCurrentIndex($pName));
		}
		
		$sql    = "SELECT   app_projects.name
						  , app_projects.dateCreated
						  , app_projects.projID
						  , tmp_designers.firstname
						  , tmp_designers.lastname
						  , app_users.userID
						  , app_users.firstname as userFirstname
				  		  , app_users.lastname  as userLastname
						  , app_users.clientOrganisation {$clause} ORDER BY app_projects.projID DESC";
		
		$result = $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			if($details)
			{
				array_push($projects, $row);
			}
			else
			{
				array_push_associative($projects, array($row['projID'] => $row['name']));
			}
		}
		
		return($projects);
	}
	
   /**
    * Loads all the tasks listed in the logged user's account
	*
	* This will return an array of projects for the logged user in
	* paginated chunks.
	*
	* Dependant on: SmartyPaginate, class.db.inc.php
	*
	* @access 	public
	* @param	integer 	- An optional projID that will force the method to filter for that project only
	* @param	integer 	- An optional userID that will force the method to filter for that client  only
	* @param	boolean 	- An optional flag to prevent the full task details being displayed
	* @param	boolean 	- An optional flag to prevent the result from being paginated
	* @return 	array 		- An associative array of all the logged user's project tasks
	*/
	public function loadAllTasks($project='', $client='', $details=true, $paginate=true)
	{
		$tasks  = array();
		$pName  = $this->getPage();
		$accID  = $this->getAccID();
		$userID = $this->getUserID();
		
		$dbh    = dbConnection::get()->handle();
		
		$clause = "FROM app_tasks

					INNER JOIN app_projects      ON app_tasks.projID      = app_projects.projID
					INNER JOIN app_users		 ON app_projects.clientID = app_users.userID

				   WHERE app_projects.accID = '{$accID}' AND app_tasks.type = 'task'";
		
		if(is_numeric($project))
		{
			$clause .= " AND app_projects.projID = {$project}";
		}
		if(is_numeric($client))
		{
			$clause .= " AND app_projects.clientID = {$client}";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $clause .= " AND app_projects.visibility = '1'";
		}
		
		$sql	= "SELECT count(*) AS total {$clause}";
		
		$result = $dbh->query($sql);
		$count  = $result->fetchRow();
		
		if($paginate)
		{
			SmartyPaginate::setTotal($count['total'], $pName);
			$dbh->setLimit(SmartyPaginate::getLimit($pName), SmartyPaginate::getCurrentIndex($pName));
		}
		
		$sql    = "SELECT   app_tasks.taskID  
						  ,	app_tasks.title
						  , app_tasks.description
						  , app_tasks.createdOn
						  , app_tasks.status
						  , app_projects.name
						  , app_projects.projID
						  , app_users.clientOrganisation
						  , app_users.userID {$clause} ORDER BY app_tasks.taskID DESC";
		
		$result = $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			if($details)
			{
				array_push($tasks, $row);
			}
			else
			{
				array_push_associative($tasks, array($row['taskID'] => $row['title']));
			}
		}
		
		return($tasks);
	}
	
   /**
    * Loads all the assigned tasks for the logged user's account
	*
	* This will return an array of tasks for the logged user in
	* paginated or non paginated chunks. It's primary use is for staff accounts.
	*
	* These account types only have permission to access tasks in projects that they have
	* been assigned to.
	*
	* Dependant on: SmartyPaginate, class.db.inc.php
	*
	* @access 	public
	* @param	integer 	- An optional projID that will force the method to filter for that project only
	* @param	boolean 	- An optional flag to prevent the full task details being displayed
	* @param	boolean 	- An optional flag to prevent the result from being paginated
	* @return 	array 		- An associative array of all the logged user's assigned project tasks
	*/
	public function loadAssignedTasks($project='', $details=true, $paginate=true)
	{
		$tasks  = array();
		$pName  = $this->getPage();
		$accID  = $this->getAccID();
		$userID = $this->getUserID();
		
		$dbh    = dbConnection::get()->handle();
		
		$clause = "FROM app_tasks

					INNER JOIN app_projects      ON app_tasks.projID    = app_projects.projID
           			INNER JOIN app_staffProjects ON app_projects.projID = app_staffProjects.projectID
					INNER JOIN app_users		 ON app_projects.clientID = app_users.userID

				   WHERE app_projects.accID = '{$accID}'
				   
				   AND app_tasks.type            = 'task'
				   AND app_staffProjects.staffID = '{$userID}'";
		
		if(is_numeric($project))
		{
			$clause .= " AND app_projects.projID = {$project}";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $clause .= " AND app_projects.visibility = '1'";
		}
		
		$sql	= "SELECT count(*) AS total {$clause}";
		
		$result = $dbh->query($sql);
		$count  = $result->fetchRow();
		
		if($paginate)
		{
			SmartyPaginate::setTotal($count['total'], $pName);
			$dbh->setLimit(SmartyPaginate::getLimit($pName), SmartyPaginate::getCurrentIndex($pName));
		}
		
		$sql    = "SELECT   app_tasks.taskID  
						  ,	app_tasks.title
						  , app_tasks.createdOn
						  , app_projects.name
						  , app_projects.projID
						  , app_users.clientOrganisation
						  , app_users.userID {$clause}";
		
		$result = $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			if($details)
			{
				array_push($tasks, $row);
			}
			else
			{
				array_push_associative($tasks, array($row['taskID'] => $row['title']));
			}
		}
		
		return($tasks);
	}	
	
   /**
    * Counts the total number of tasks the logged user has access to.
	*
	* BASED ON A SYSTEM SEARCH IT APPEARS AS IF THIS METHOD IS NO LONGER IN USE.
	* POSSIBLE CANDIDATE FOR DELETION.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	boolean 	- Whether to count only the assigned tasks or not (used for staff)
	* @return 	integer		- A whole number of the amount of available tasks
	*/
	public function countTasks($assignedOnly=false)
	{
		$accID  = $this->getAccID();
		$dbh    = dbConnection::get()->handle();
		$join   = '';
		
		if($assignedOnly)
		$join   = "INNER JOIN app_staffProjects ON app_projects.projID = app_staffProjects.projectID";
		
		$sql    = "SELECT count(*) AS total FROM app_tasks

					INNER JOIN app_projects      ON app_tasks.projID    = app_projects.projID {$join}
					INNER JOIN app_users		 ON app_projects.clientID = app_users.userID

				   WHERE app_projects.accID = '{$accID}' AND app_tasks.type = 'task'";
		
		$result = $dbh->query($sql);
		$count  = $result->fetchRow();
		
		return($count['total']);
	}
	
	/**
    * Loads all the requests listed in the logged user's account
	*
	* This will return an array of requests for the logged user in
	* paginated chunks.
	*
	* Dependant on: SmartyPaginate, class.db.inc.php
	*
	* @access 	public
	* @param	integer 	- An optional projID that will force the method to filter for that project only
	* @param	integer 	- An optional clientID that will force the method to filter for that client only
	* @return 	array 		- An associative array of all the logged user's pending requests
	*/
	public function loadAllRequests($project='', $client='')
	{
		$requests = array();
		$pName    = $this->getPage();
		$accID    = $this->getAccID();
		
		$dbh = dbConnection::get()->handle();
		
		$clause = "FROM app_tasks

					INNER JOIN app_projects      ON app_tasks.projID      = app_projects.projID
					INNER JOIN app_users		 ON app_projects.clientID = app_users.userID

				   WHERE app_projects.accID = '{$accID}' AND app_tasks.type = 'request'";
				   
		if(is_numeric($project))
		{
			$clause .= " AND app_projects.projID = {$project}";
		}
		if(is_numeric($client))
		{
			$clause .= " AND app_users.userID    = {$client}";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $clause .= " AND app_projects.visibility = '1'";
		}
		
		$sql	= "SELECT count(*) AS total {$clause}";
		
		$result = $dbh->query($sql);
		$count  = $result->fetchRow();
		
		SmartyPaginate::setTotal($count['total'], $pName);
		$dbh->setLimit(SmartyPaginate::getLimit($pName), SmartyPaginate::getCurrentIndex($pName));
		
		$sql    = "SELECT   app_tasks.taskID AS requestID
						  ,	app_tasks.title
						  , app_tasks.description
						  , app_tasks.createdOn
						  , app_tasks.status
						  , app_projects.name
						  , app_projects.projID
						  , app_users.clientOrganisation
						  , app_users.userID {$clause} ORDER BY app_tasks.taskID DESC";
		
		$result = $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			array_push($requests, $row);
		}
		
		return($requests);
	}
	
   /**
    * Loads all the assigned requests listed in the logged user's account
	*
	* This will return an array of requests for the logged user in
	* paginated chunks.
	*
	* Dependant on: SmartyPaginate, class.db.inc.php
	*
	* @access 	public
	* @param	integer 	- An optional userID that will force the method to filter for that client  only
	* @return 	array 		- An associative array of all the logged user's project requests
	*/
	public function loadAssignedRequests($client='')
	{
		$requests = array();
		$pName    = $this->getPage();
		$accID    = $this->getAccID();
		$userID   = $this->getUserID();
		
		$dbh = dbConnection::get()->handle();
		
		$clause = "FROM app_tasks

					INNER JOIN app_projects      ON app_tasks.projID      = app_projects.projID
					INNER JOIN app_staffProjects ON app_projects.projID   = app_staffProjects.projectID
					INNER JOIN app_users		 ON app_projects.clientID = app_users.userID
					
				   WHERE app_projects.accID = '{$accID}'
				   
				   AND app_tasks.type            = 'request'
				   AND app_staffProjects.staffID = '{$userID}'";
				   
		if(is_numeric($client))
		{
			$clause .= " AND app_users.userID    = {$client}";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $clause .= " AND app_projects.visibility = '1'";
		}
		
		$sql	= "SELECT count(*) AS total {$clause}";
		
		$result = $dbh->query($sql);
		$count  = $result->fetchRow();
		
		SmartyPaginate::setTotal($count['total'], $pName);
		$dbh->setLimit(SmartyPaginate::getLimit($pName), SmartyPaginate::getCurrentIndex($pName));
		
		$sql    = "SELECT   app_tasks.taskID AS requestID
						  ,	app_tasks.title
						  , app_tasks.description
						  , app_tasks.createdOn
						  , app_tasks.status
						  , app_projects.name
						  , app_projects.projID
						  , app_users.clientOrganisation
						  , app_users.userID {$clause} ORDER BY app_tasks.taskID DESC";
		
		$result = $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			array_push($requests, $row);
		}
		
		return($requests);
	}
	
   /**
    * Loads all the documents listed in the logged user's account
	*
	* This will return an array of documents for the logged user in
	* paginated or non paginated chunks.
	*
	* Dependant on: SmartyPaginate, class.db.inc.php
	*
	* @access 	public
	* @param	integer 	- $task		- An optional taskID that will force the method to filter for that task only
	* @param	integer 	- $client	- An optional clientID to filter for that client only
	* @param	boolean 	- $paginate	- An optional flag to prevent the result from being paginated
	* @return 	array 		- An associative array of all the logged user's pending requests
	*/
	public function loadAllDocuments($task='', $client='', $paginate=true)
	{
		$documents = array();
		$pName     = $this->getPage();
		$accID     = $this->getAccID();
		
		$dbh = dbConnection::get()->handle();
		
		$clause = "WHERE app_projects.accID = '{$accID}'";
		
		if(is_numeric($task))   $clause .= " AND app_documents.taskID  = '{$task}'";
		if(is_numeric($client))
		{
			$clause .= " AND app_projects.clientID = '{$client}' AND app_documents.clientAccess > 0";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $clause .= " AND app_projects.visibility = '1'";
		}
		
		$sql = "SELECT  app_documentVersions.docID
					  , MAX(app_documentVersions.`version`) AS version
					  ,	(SELECT SUM(size) FROM app_documentVersions WHERE docID = app_documents.docID) AS size
					  , MAX(app_documentVersions.versionID) AS versionID
					  ,	app_documents.title AS docTitle
					  , app_documents.docType
					  , app_documents.taskID
					  , app_documents.lastAccessed
					  , app_documents.author
					  , app_documents.clientAccess
					  , app_tasks.title
					  , (SELECT count(*)             AS total FROM app_documents
							INNER JOIN app_tasks     ON app_documents.taskID = app_tasks.taskID
							INNER JOIN app_projects  ON app_tasks.projID     = app_projects.projID
					        {$clause}) AS total
					
				FROM app_documentVersions

					INNER JOIN app_documents ON app_documentVersions.docID = app_documents.docID
					INNER JOIN app_tasks     ON app_documents.taskID       = app_tasks.taskID
					INNER JOIN app_projects  ON app_tasks.projID           = app_projects.projID {$clause}
		
				GROUP BY app_documentVersions.docID ORDER BY app_documents.docID DESC";
		
		if($paginate) $dbh->setLimit(SmartyPaginate::getLimit($pName), SmartyPaginate::getCurrentIndex($pName));
		
		$result = $dbh->query($sql);
		
		if($paginate)
		{
			$count = $result->fetchCol('total');
			
			if(isset($count[0]))
			{
				SmartyPaginate::setTotal($count[0], $pName);
			}
			$result->seek(0);
		}
		
		while($row = $result->fetchRow())
		{
			array_push($documents, $row);
		}
		
		return($documents);
	}
	
   /**
    * Loads all the assigned documents listed in the logged user's account
	*
	* This will return an array of documents for the logged user in
	* paginated or non paginated chunks.
	*
	* Dependant on: SmartyPaginate, class.db.inc.php
	*
	* @access 	public
	* @param	integer 	- $task		- An optional taskID that will force the method to filter for that task only
	* @param	boolean 	- $paginate	- An optional flag to prevent the result from being paginated
	* @return 	array 		- An associative array of all the logged user's pending requests
	*/
	public function loadAssignedDocuments($task='', $paginate=true)
	{
		$documents = array();
		$pName     = $this->getPage();
		$accID     = $this->getAccID();
		$userID    = $this->getUserID();
		
		$dbh = dbConnection::get()->handle();
		
		$clause = "WHERE app_projects.accID = '{$accID}'
					 AND app_staffProjects.staffID = '{$userID}'";
		
		if(is_numeric($task)) $clause .= " AND app_documents.taskID = '{$task}'";
		
		$sql = "SELECT  app_documentVersions.docID
					  , MAX(app_documentVersions.`version`) AS version
					  ,	(SELECT SUM(size) FROM app_documentVersions WHERE docID = app_documents.docID) AS size
					  , app_documentVersions.versionID
					  ,	app_documents.title AS docTitle
					  , app_documents.docType
					  , app_documents.taskID
					  , app_documents.lastAccessed
					  , app_documents.author
					  , app_documents.clientAccess
					  , app_tasks.title
					  , (SELECT count(*) AS total FROM app_documents
							INNER JOIN app_tasks         ON app_documents.taskID = app_tasks.taskID
							INNER JOIN app_projects      ON app_tasks.projID     = app_projects.projID
							INNER JOIN app_staffProjects ON app_projects.projID  = app_staffProjects.projectID
					        {$clause}) AS total
					
				FROM app_documentVersions

					INNER JOIN app_documents     ON app_documentVersions.docID = app_documents.docID
					INNER JOIN app_tasks         ON app_documents.taskID       = app_tasks.taskID
					INNER JOIN app_projects      ON app_tasks.projID           = app_projects.projID
					INNER JOIN app_staffProjects ON app_projects.projID        = app_staffProjects.projectID {$clause}
		
				GROUP BY app_documentVersions.docID ORDER BY app_documents.docID DESC";
		
		if($paginate) $dbh->setLimit(SmartyPaginate::getLimit($pName), SmartyPaginate::getCurrentIndex($pName));
		
		$result = $dbh->query($sql);
		
		if($paginate)
		{
			$count = $result->fetchCol('total');
			
			if(isset($count[0]))
			{
				SmartyPaginate::setTotal($count[0], $pName);
			}
			$result->seek(0);
		}
		
		while($row = $result->fetchRow())
		{
			array_push($documents, $row);
		}
		
		return($documents);
	}
	
   /**
    * Load all the screenshot information
	*
	* This will return an array of screenshots for the logged user in
	* paginated or non paginated chunks.
	*
	* Dependant on: SmartyPaginate
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	integer - $task			- An optional taskID that will force the method to filter for that task only
	* @param	integer - $client		- An optional clientID to filter for that client only
	* @param	boolean - $assignedOnly - A marker to filter all but the images that are attached to an assigned project.
	* @param	boolean - $paginate		- An optional flag to prevent the result from being paginated
	* @return 	array 	- An associative array of all the logged user's pending requests
	*/
	public function loadScreenshots($task='', $client='', $size='d', $assignedOnly=false, $paginate=true)
	{
		$screenshots = array();
		$pName  = $this->getPage();
		$accID  = $this->getAccID();
		$userID = $this->getUserID();

		$dbh    = dbConnection::get()->handle();
		
		$join	= "INNER JOIN app_tasks     ON app_screenshots.taskID = app_tasks.taskID
				   INNER JOIN app_projects  ON app_tasks.projID       = app_projects.projID";
		
		if($assignedOnly)
		$join .= " INNER JOIN app_staffProjects ON app_projects.projID = app_staffProjects.projectID";
		
		$clause = "WHERE app_projects.accID = '{$accID}'";
		
		if($assignedOnly)		$clause .= " AND app_staffProjects.staffID = '{$userID}'";
		if(is_numeric($task))   $clause .= " AND app_screenshots.taskID    = '{$task}'";
		if(is_numeric($client))
		{
			$clause .= " AND app_projects.clientID = '{$client}'";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $clause .= " AND app_projects.visibility = '1'";
		}
		
		$sql = "SELECT  this.screenshotID
					  , MAX(this.`version`) AS version
					  ,	this.size
					  , MAX(this.id) AS id
					  ,	app_screenshots.title       AS imgTitle
					  ,	app_screenshots.description AS imgDesc
					  , app_screenshots.docType
					  , app_screenshots.taskID
					  , app_screenshots.dateCreated
					  , app_screenshots.author
					  , app_screenshots.clientAccess
					  , app_tasks.title
					  , app_projects.name as project
					  , app_projects.projID
					  , app_users.clientOrganisation as clientOrg
					  , app_users.userID as clientID
					  , (SELECT count(*) FROM app_comments WHERE parentID = this.screenshotID AND parentType = 'screenshot') AS comments
					  , (SELECT count(*) FROM app_screenshots {$join} {$clause}) AS total
					
				FROM app_screenshotVersions AS this

				INNER JOIN app_screenshots ON this.screenshotID     = app_screenshots.screenshotID {$join}
				INNER JOIN app_users       ON app_projects.clientID = app_users.userID
				
				{$clause} GROUP BY this.screenshotID ORDER BY app_screenshots.screenshotID DESC";
		
		if($paginate) $dbh->setLimit(SmartyPaginate::getLimit($pName), SmartyPaginate::getCurrentIndex($pName));
		
		$result = $dbh->query($sql);
		
		// Paginate
		if($paginate)
		{
			$count = $result->fetchCol('total');
			
			if(isset($count[0]))
			{
				SmartyPaginate::setTotal($count[0], $pName);
			}
			$result->seek(0);
		}
		
		// Initialise Query String Data
		require_once('Crypt/HMAC.php');
		require_once('HTTP/Request.php');

		$s3     = new s3();
		$bucket = 'screenshots.footprinthq.com';
		
		// Load Screenshots
		while($row = $result->fetchRow())
		{
			// Calculate Querystring for S3 Access
			$key  = $row['id'].$size;
			$auth = $s3->qStrAuthentication($bucket, $key, 320); // valid for 5 mins
			array_push_associative($row, array('auth' => $auth, 'key' => $key));
		
			array_push($screenshots, $row);
		}
		
		return($screenshots);
	}
	
   /**
    * Get the stored filter information for a paginated dataset.
	*
	* This is used so that paginated information maintains it's
	* filter information across each page leaf without having to
	* amend the url.
	*
	* However, problems arise with this if a filter was applied when it was used previously
	* and then it was attempted to be used by the same page with either a new filter or no filter.
	*
	* This will return the selected filter, if there is one.
	*
	* @access 	public
	* @param	array   - $filter - The full $_GET dataset sent to the page.
	* @return 	integer - Returns the id of the item to filter for.
	*/
	public function loadFilterID($filter=NULL)
	{
		$page = $this->getPage();
	
		if(isset($filter['id']))
		{
			SmartyPaginate::disconnect($page);
			SmartyPaginate::connect($page);
			SmartyPaginate::setLimit(PER_PAGE, $page);
			
			if(is_numeric($filter['id']))
			{
				$newFilter = cleanValue($filter['id']);
				$_SESSION['filters'][$page] = $newFilter;
			}
			else
			{
				$newFilter = '';
				unset($_SESSION['filters'][$page]);
			}
		}
		elseif(isset($_SESSION['filters'][$page]) && isset($filter['next']))
		{
			$newFilter = $_SESSION['filters'][$page];
		}
		else
		{
			$newFilter = '';
		}
		
		return($newFilter);
	}
	
   /**
    * Update the profile of the logged user
	*
	* This includes personal details such as name, email,
	* username, password, timezone and organisation name.
	*
	* @access 	public
	* @param	array   - $vars - Submitted form variables in a cleaned state
	* @return 	boolean - True if successful, False if not.
	*/
	public function updateProfile($vars, $group)
	{
		$accID  = $this->getAccID();
		$userID = $this->getUserID();
		
		$dbh = dbConnection::get()->handle();
		
		$now = time();
		
		// Extract Firstname & Lastname
		$lastname  = extractNames($vars['name'], 'lastname');
		$firstname = extractNames($vars['name'], 'firstname');
		
		// Encrypt the password
		$password  = md5($vars['password']); 
		
		// Determine which organisation to update
		if($group == 'Client')
		{
		  $table = 'app_users';
			$org = 'clientOrganisation';
		}
		else
		{
		  $table = 'app_accounts';
			$org = 'organisation';
		}
		
		// Update Total Number of Logins
		$sql = "UPDATE app_users, app_accounts
				
				SET    app_users.username = '{$vars['username']}'
				 ,    app_users.firstname = '{$firstname}'
				 ,     app_users.lastname = '{$lastname}'
				 ,        app_users.email = '{$vars['email']}'";
		
		if($_SESSION['user']['groupName'] != 'Staff') 
		{
			$sql .= ",".$table.".".$org." = '{$vars['organisation']}'";
		}
		
		if($_SESSION['user']['groupName'] == 'Designer') 
		{
			$sql .= " , app_accounts.timezone = '{$vars['timezone']}'";
		}
		
			$sql .=	" , app_users.password    = '{$password}'
				
				WHERE app_users.userID = '{$vars['userID']}'
				AND   app_users.accID  = app_accounts.accID";
		
		$affected = $dbh->exec($sql);

		// Check for Error
		if (PEAR::isError($affected))
		{
    		//die($affected->getMessage());
			return(false);
		}
		else
		{
			// Update Session Data
			$_SESSION['user']['username']  = $vars['username'];
			$_SESSION['user']['lastname']  = $lastname;
			$_SESSION['user']['firstname'] = $firstname;
			$_SESSION['user']['email'] 	   = $vars['email'];
			
			if($_SESSION['user']['groupName'] != 'Staff') 
			{
				$_SESSION['user'][$org] 	   = $vars['organisation'];
			}
			
			// Set New Timezone Info (if applicable)
			if($_SESSION['user']['groupName'] == 'Designer')
			{
				$tz = $this->loadTimezones($vars['timezone']);
				$_SESSION['user']['tzID']	   = $vars['timezone'];
				$_SESSION['user']['timezone']  = $tz['code'];
			}
		
			return(true);
		}
	}

   /**
    * Update the style colours for the account
	*
	* @access 	public
	* @param    integer - $style - The selected CSS Scheme
	* @return 	boolean - True if successful, False if not.
	*/
	public function updateColours($style)
	{	
		if(empty($style)) return(false);
		
		$accID = $this->getAccID();
		$dbh   = dbConnection::get()->handle();
		
		// Get cssZone Colours
		$sql = "SELECT * FROM app_schemes WHERE id = '{$style}'";
		$res = $dbh->query($sql);		
		$css = $res->fetchAll();
		
		if(empty($css[0])) return(false);
		
		// Update Database cssScheme
		$sql = "UPDATE app_accounts SET
					
				   cssScheme = '{$style}'
				 ,  cssZoneA = '{$css[0]['cssZoneA']}'
			     ,  cssZoneB = '{$css[0]['cssZoneB']}'
				 ,  cssZoneC = '{$css[0]['cssZoneC']}'
				 ,  cssZoneD = '{$css[0]['cssZoneD']}'
				 
				 WHERE accID = '{$accID}'";
		
		$affected = $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Update the Session
		$_SESSION['user']['cssScheme'] = $style;
		$_SESSION['user']['cssZoneA']  = $css[0]['cssZoneA'];
		$_SESSION['user']['cssZoneB']  = $css[0]['cssZoneB'];
		$_SESSION['user']['cssZoneC']  = $css[0]['cssZoneC'];
		$_SESSION['user']['cssZoneD']  = $css[0]['cssZoneD'];
		
		return(true);
	}

  /**
    * Update the logo for the account
	*
	* @access 	public
	* @param    file - $logo - The uploaded logo
	* @return 	boolean - True if successful, False if not.
	*/
	public function updateLogo(&$logo)
	{	
		$time    = time();
		$accID   = $accID = $this->getAccID();
		$tmpName = 'logo-'.$accID.'-'.$time;
		$dbh     = dbConnection::get()->handle();
		
		$handle = new upload($logo);

 		if ($handle->uploaded)
		{
			// Upload Settings
			$handle->image_y      		=  60;
			$handle->image_x            = 170;
			$handle->image_resize       = true;
			$handle->file_max_size 		= '1048576';
			
			$src = $handle->Process();
			$img = addslashes($src);
			
			// Insert to DB
			$sql = "UPDATE app_accounts SET
					
				            logo = '{$img}'
				 ,  logoMIMEName = '{$handle->file_new_name_ext}'
			     ,  logoMIMEType = '{$handle->file_src_mime}'
				 
				 WHERE accID = '{$accID}'";
		
			$affected = $dbh->exec($sql);
			if (PEAR::isError($affected)) return(false);
			
			// Update Session Logo
			$_SESSION['logo']['data'] = $src;
			$_SESSION['logo']['mime'] = $handle->file_src_mime;
			
			$handle->clean();
			
			return(true);
		}
		
		return(false);	
	}
}

?>