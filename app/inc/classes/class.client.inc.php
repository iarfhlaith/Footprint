<?php
/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        class.client.inc.php
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
class client
{
   /**
    * The variables submitted in the form
    *
    * @var 	public object
    */
	private $vars;

   /**
    * The clientID of the selected client
    *
    * @var 	public object
    */
	private $clientID;
	
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
    * The class constructor.
	*
	* It sets up the userID and the accID for the logged
	* user.
	*
    */
	public  function __construct()
	{
		$this->setAccID($this->getAccID());
		$this->setUserID($this->getUserID());
	}

   /**
    * Gets the form variables submitted
    *
	* @access 	public
	* @return 	array - Returns the form variables
    */
	public function getFormVars()
	{
		return($this->vars);
	}
	
   /**
    * Sets the form variables submitted
	*
	* @param array $vars - An array of the form variables submitted
	*
	* @access 	public
	* @return 	void
    */
	public function setFormVars($vars)
	{
		$this->vars = $vars; 
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
    * Sets the clientID
    *
	* @access 	public
	* @return 	void
    */
	public  function select($id)
	{
		$this->clientID = $id;
	}
	
   /**
    * Gets the clientID
    *
	* @access 	public
	* @return 	integer - The clientID of the selected client
    */
	public  function getClientID()
	{
		return($this->clientID);
	}
	
   /**
    * Load information for the selected client
	*
	* This will return an array of the client's information.
	*
	* Dependant on: class.db.inc.php
	*
	* @acccess 	public
	* @return 	array - An associative array of all selected the client's information.
	*/
	public  function loadClient()
	{	
		$cid   = $this->getClientID();
		$aid   = $this->getAccID();
	
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
						, app_users.clientOrganisation AS organisation
						, app_users.invited
					
					FROM app_users
					
				  	INNER JOIN app_userGroups ON app_users.userID       = app_userGroups.userID
					INNER JOIN app_groups	  ON app_userGroups.groupID = app_groups.groupID
				  
				  WHERE app_users.userID   = '{$cid}'
				    AND app_users.accID    = '{$aid}'
					AND app_groups.groupID = '3'";
		
		$result =& $dbh->query($sql);
		
		$client = $result->fetchRow();
		
		if(!empty($client))
		{
			array_push_associative($client, array('name' => $client['firstname'].' '.$client['lastname']));
		}
		
		return($client);
	}
	
   /**
    * Create a new client for the logged user's account
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	integer|void - The id of the newly added client
	*/
	public function create()
	{
		$inviteStatus = false;
		$vars = $this->getFormVars();
		
		// Timestamp
		$timestamp = time();
	
		// Generate Password
		if(empty($vars['password']))
		{
			$vars['password'] = $this->generatePassword();
			
			// Set the generated password so the invite email can use it.
			$this->vars['password'] = $vars['password'];
		}
		$md5pass = md5($vars['password']);
		
		// Extract Firstname & Lastname
		$lastname  = extractNames($vars['name'], 'lastname');
		$firstname = extractNames($vars['name'], 'firstname');
		
		// Mark Invitation Status
		if($vars['invite'] == 'yes') $inviteStatus = true;
		
		$dbh   = dbConnection::get()->handle();
		
		// Add Client Record
		$sql = "INSERT INTO app_users
				 ( accID
				 , username
				 , password
				 , firstname
				 , lastname
				 , email
				 , createdOn
				 , clientOrganisation
				 , invited
				 )
				 
				VALUES
				 ('{$vars['accID']}'
				 ,'{$vars['username']}'
				 ,'{$md5pass}'
				 ,'{$firstname}'
				 ,'{$lastname}'
				 ,'{$vars['email']}'
				 ,'{$timestamp}'
				 ,'{$vars['organisation']}'
				 ,'{$inviteStatus}')";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch UserID
		$id = $dbh->lastInsertID('app_users', 'userID');
		
		// Add Client to Client Group
		$sql = "INSERT INTO app_userGroups (userID, groupID) VALUES ('{$id}', '3')";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Send Email Invitation (if requested)
		if(isset($vars['invite'])) $this->invite();
		
		return($id);
	}

   /**
    * Update details of existing client
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function update()
	{
		$vars = $this->getFormVars();
		
		// Timestamp
		$timestamp = time();
	
		// Update Password
		if(!empty($vars['password']))
		{
			$md5pass = md5($vars['password']);
		}
		
		// Extract Firstname & Lastname
		$lastname  = extractNames($vars['name'], 'lastname');
		$firstname = extractNames($vars['name'], 'firstname');
		
		$dbh   = dbConnection::get()->handle();
		
		// Update Client Record
		$sql = "UPDATE app_users SET
		
				    			    username = '{$vars['username']}'
				 , 				   firstname = '{$firstname}'
				 ,  			    lastname = '{$lastname}'
				 ,     				   email = '{$vars['email']}'
				 ,     	  clientOrganisation = '{$vars['organisation']}'";
		
		if(!empty($vars['password']))
			$sql .= ", password = '{$md5pass}' ";
		
		if(isset($vars['invite']))
			$sql .= ", invited = '1' ";
		
		$sql .= "WHERE userID = '{$vars['userID']}'";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Send Email Invitation (if requested)
		if(isset($vars['invite'])) $this->invite();
		
		return(true);
	}
	
   /**
    * Delete selected client(s)
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function delete($list)
	{
		if(empty($list)) return(false);
		
		$sel = arrayToList($list, 'index');
		$dbh = dbConnection::get()->handle();

		// Build list of projects belonging to all selected clients
		$projects    =  array();
		$sql         =  "SELECT projID FROM app_projects WHERE clientID IN ({$sel})";
		$result      =& $dbh->query($sql);
		while($row   =  $result->fetchRow()) array_push($projects, $row['projID']);
		$listProjs   =  arrayToList($projects);
		
		// Build list of tasks and requests assigned to above projects
		$tasks       =  array();
		$sql         =  "SELECT taskID FROM app_tasks WHERE projID IN ({$listProjs})";
		$result      =& $dbh->query($sql);
		while($row   =  $result->fetchRow()) array_push($tasks, $row['taskID']);
		$listTasks   =  arrayToList($tasks);
		
		// Build list of screenshots assigned to tasks above
		$screens     =  array();
		$sql         =  "SELECT screenshotID FROM app_screenshots WHERE taskID IN ({$listTasks})";
		$result      =& $dbh->query($sql);
		while($row   =  $result->fetchRow()) array_push($screens, $row['screenshotID']);
		$listScreens =  arrayToList($screens);
		
		// Build list of documents assigned to tasks above
		$docs        =  array();
		$sql         =  "SELECT docID FROM app_documents WHERE taskID IN ({$listTasks})";
		$result      =& $dbh->query($sql);
		while($row   =  $result->fetchRow()) array_push($docs, $row['docID']);
		$listDocs    =  arrayToList($docs);
		
		// Delete core client data
		$sql = "DELETE FROM app_users 				WHERE userID 		IN ({$sel})";
		$affected =& $dbh->exec($sql);
		
		$sql = "DELETE FROM app_userGroups 			WHERE userID 		IN ({$sel})";
		$dbh->exec($sql);
		
		$sql = "DELETE FROM app_projects 			WHERE clientID 		IN ({$sel})";
		$dbh->exec($sql);
		
		$sql = "DELETE FROM app_tasks 				WHERE projID 		IN ({$listProj})";
		$dbh->exec($sql);
		
		$sql = "DELETE FROM app_documents 			WHERE taskID 		IN ({$listTasks})";
		$dbh->exec($sql);
		
		$sql = "DELETE FROM app_documentVersions 	WHERE docID 		IN ({$listDocs})";
		$dbh->exec($sql);
		
		$sql = "DELETE FROM app_screenshots 		WHERE taskID 		IN ({$listTasks})";
		$dbh->exec($sql);
		
		$sql = "DELETE FROM app_screenshotVersions 	WHERE screenshotID 	IN ({$listScreens})";
		$dbh->exec($sql);
		
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
    * Import clients in bulk
	*
	* @param	integer - The length of the required password
	* @return 	string	- A randomly grnerated password string
	*/
	public function import(&$file, $accID, $type)
	{
		$valid = true;
		$vars  = array();
	
		if(!isset($file['tmp_name']) || !is_numeric($accID) || empty($type)) return false;
		
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
			
			// Read the rows into an array
			$lines = file($file['tmp_name'], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

			foreach ($lines as $line)
			{	
    			// Split each row by comma
				$arr = explode(',', $line);
				
				// Set password				
				$pass  = '';
				if(isset($arr[3])) $pass = $arr[3];

				// Build compatible array structure
				$vars = array(    'accID' => $accID
						 ,         'name' => trim($arr[1])
						 ,        'email' => trim($arr[2])
						 ,     'username' => trim($arr[2])
						 ,     'password' => trim($pass)
						 , 'organisation' => trim($arr[0]));
				
				if(isset($arr[4])) array_push_associative($vars, array(  'invite' => trim($arr[4])));
				
				// Add Client
				$newID = $this->create($vars);
				
				if(!is_numeric($newID)) $valid = false;
			}
		}
		return($valid);
	}

   /**
    * Generates an alpha numeric password with 7 characters 
	*
	* @access 	private
	* @param	integer - The length of the required password
	* @return 	string	- A randomly grnerated password string
	*/
	private function generatePassword($length=7)
	{
		$pass = '';
		$salt = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
		
		$saltLength = strlen($salt);
		
		mt_srand((double)microtime()*1000000);
		
		for($i = 0; $i < $length; $i++)
		{
			$pass .= $salt[mt_rand(0,$saltLength-1)];
		}
		
		return($pass);
	}
	
   /**
    * Send an invitation to the user along with their username and password.
	*
	* Dependant on: class.mailer.inc.php, class.db.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function invite()
	{
		$now  = time();
		$vars = $this->getFormVars();
		$dbh  = dbConnection::get()->handle();

		// Load Email Text
		$email = file_get_contents(APP_ROOT.'/inc/emails/english/client.invitation.txt');
		
		if(empty($vars['password']))
		{
			$vars['password'] = 'Your password is unchanged. For security, we encrypt all passwords and cannot access them directly.';
		}
		
		// Merge Variables into Email
		$email = str_replace('[~name~]'         , $vars['name']	                	, $email);
		$email = str_replace('[~organisation~]' , $_SESSION['user']['organisation']	, $email);
		$email = str_replace('[~prefix~]'       , $_SESSION['user']['prefix']   	, $email);
		$email = str_replace('[~username~]'     , $vars['username']	    			, $email);
		$email = str_replace('[~password~]'     , $vars['password']	    			, $email);
		$email = str_replace('[~owner_name~]'   , $_SESSION['user']['firstname'].' '.$_SESSION['user']['lastname']   , $email);
		
		$subj  = 'Access Granted for '.$vars['name'];
		
		$recipient = html_entity_decode($vars['email'], ENT_QUOTES);
		
		// Send Reset Email
		$mail = new mailer;
		$mail->from($_SESSION['user']['email'], $_SESSION['user']['firstname'].' '.$_SESSION['user']['lastname'].'('.$_SESSION['user']['organisation'].')');
		$mail->add_recipient($recipient);
		$mail->subject($subj);
		$mail->message($email);
		$result = $mail->send();
		
		// Scrub Email Content
		$cleanEmail = cleanValue($email);
		
		// Save A Copy
		$sql = "INSERT INTO app_emails (accID, content, dateCreated, sendStatus, subject, sentTo, type)
				
				VALUES ('{$_SESSION['user']['accID']}'
					   ,'{$cleanEmail}'
					   ,'{$now}'
					   ,'{$result}'
					   ,'{$subj}'
					   ,'{$recipient}'
					   ,'Client Invitation'
					   )";
		
		$affected =& $dbh->exec($sql);
		
		return(true);
	}
	
}
?>