<?php
/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        class.staff.inc.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Ltd.
 *
 * This software is protected under Irish Copyright Law.
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. @link http://www.footprintapp.com/forums
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
class staff
{
   /**
    * The variables submitted in the form
    *
    * @var 	public object
    */
	private $vars;
	
   /**
    * The staffID of the loaded staff member
    *
    * @var 	public object
    */
	private $staffID;
	
   /**
    * The class constructor.
	*
    */
	public  function __construct(){}

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
    * Sets the staffID
    *
	* @access 	public
	* @return 	void
    */
	public  function select($id)
	{
		$this->staffID = $id;
	}
	
   /**
    * Gets the staffID
    *
	* @access 	public
	* @return 	integer - The staffID of the loaded staff member
    */
	public  function getStaffID()
	{
		return($this->staffID);
	}
	
   /**
    * Load information for the selected staff member
	*
	* This will return an array of the staff member's information.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	array - An associative array of all the staff member's information.
	*/
	public  function loadStaff()
	{	
		$sid   = $this->getStaffID();
	
		$dbh   = dbConnection::get()->handle();
		
		$sql   = "SELECT  app_users.userID
						, app_users.username
						, app_users.firstname
						, app_users.lastname
						, app_users.email
						, app_users.lastLogin
						, app_users.totLogins
						, app_users.createdOn
						, app_users.invited
						, app_users.staffDefaultProjectAccess
					
					FROM app_users
				  
				  	INNER JOIN app_userGroups ON app_users.userID       = app_userGroups.userID
					INNER JOIN app_groups	  ON app_userGroups.groupID = app_groups.groupID
				  
				  WHERE app_users.userID = '{$sid}' AND app_groups.groupID = '2'"; // Staff
		
		$result =& $dbh->query($sql);
		
		return($result->fetchRow());
	}
	
   /**
    * Loads all the assigned projects for the selected staff member
	*
	* This will return an array of projects
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	array - An associative array of all the assigned projects for the selected staff member
	*/
	public  function loadStaffProjects()
	{
		$projects = array();
		
		$sid = $this->getStaffID();
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "SELECT app_projects.name, app_projects.projID
		
					FROM app_projects
				  
				  	INNER JOIN app_staffProjects ON app_projects.projID = app_staffProjects.projectID
				  
				  WHERE app_staffProjects.staffID = '{$sid}'";
		
		$result =& $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			array_push($projects, $row);
		}
		
		return($projects);
	}

   /**
    * Loads all staffID's of those with default access set to true.
	*
	* This will return an array of numbers representing the staff userIDs
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	integer - The accountID
	* @return 	array
	*/
	public function loadStaffWithDefaultAccess($accID)
	{
		if(!is_numeric($accID)) return(false);
		
		$staff = array();
		
		$dbh   = dbConnection::get()->handle();
		
		$sql   = "SELECT app_users.userID FROM app_users

				  	INNER JOIN app_userGroups ON app_users.userID       = app_userGroups.userID
					INNER JOIN app_groups	  ON app_userGroups.groupID = app_groups.groupID

				WHERE app_users.staffDefaultProjectAccess = '1' AND app_groups.groupName = 'Staff' AND app_users.accID = '{$accID}'";
		
		$res   =& $dbh->query($sql);
		
		while($row = $res->fetchRow())
		{
			array_push($staff, $row['userID']);
		}
		
		return($staff);
	}
	
   /**
    * Create a new staff member for the logged user's account
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	integer|void - The id of the newly added staff member
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
		
		// Mark Default Access Status
		if($vars['defaultAccess'] == 'yes') $defaultAccessStatus = true;
		
		$dbh   = dbConnection::get()->handle();
		
		// Add Staff Record
		$sql = "INSERT INTO app_users
				 ( accID
				 , username
				 , password
				 , firstname
				 , lastname
				 , email
				 , createdOn
				 , staffDefaultProjectAccess
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
				 ,'{$defaultAccessStatus}'
				 ,'{$inviteStatus}'
				 )";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch UserID
		$id = $dbh->lastInsertID('app_users', 'userID');
		
		// Add Staff to Staff Group
		$sql = "INSERT INTO app_userGroups (userID, groupID) VALUES ('{$id}', '2')";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Assign Any Selected Projects
		if(isset($vars['access']))
		{
			foreach($vars['access'] as $project => $value)
			{
				$sql = "INSERT INTO app_staffProjects (staffID, projectID) VALUES ('{$id}', '{$project}')";
				$affected =& $dbh->exec($sql);
				if (PEAR::isError($affected)) return(false);
			}
		}
		
		// Send Email Invitation (if requested)
		if(isset($vars['invite'])) $this->invite();
		
		return($id);
	}

   /**
    * Update details of existing staff member for the logged user's account
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function update()
	{
		$defaultAccessStatus = false;
		$vars = $this->getFormVars();
		
		// Timestamp
		$timestamp = time();
	
		// Update Password
		if(!empty($vars['password']))
		{
			$md5pass = md5($vars['password']);
		}
		
		// Update Default Access Status
		if(isset($vars['defaultAccess'])) $defaultAccessStatus = '1';
		
		// Extract Firstname & Lastname
		$lastname  = extractNames($vars['name'], 'lastname');
		$firstname = extractNames($vars['name'], 'firstname');
		
		$dbh   = dbConnection::get()->handle();
		
		// Update Staff Record
		$sql = "UPDATE app_users SET
		
				    			    username = '{$vars['username']}'
				 , 				   firstname = '{$firstname}'
				 ,  			    lastname = '{$lastname}'
				 , staffDefaultProjectAccess = '{$defaultAccessStatus}'
				 ,     				   email = '{$vars['email']}' ";

		if(!empty($vars['password']))
			$sql .= ", password = '{$md5pass}' ";
		
		if(isset($vars['invite']))
			$sql .= ", invited = '1' ";
		
		$sql .= "WHERE userID = '{$vars['userID']}'";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Assign Any Selected Projects
		if(isset($vars['access']))
		{
			// Remove previous selections
			$sql = "DELETE FROM app_staffProjects WHERE staffID = '{$vars['userID']}'";		
			$affected =& $dbh->exec($sql);
			if (PEAR::isError($affected)) return(false);
			
			foreach($vars['access'] as $index => $value)
			{
				$sql = "INSERT INTO app_staffProjects (staffID, projectID) VALUES ('{$vars['userID']}', '{$value}')";
				$affected =& $dbh->exec($sql);
				if (PEAR::isError($affected)) return(false);
			}
		}
		
		// Send Email Invitation (if requested)
		if(isset($vars['invite'])) $this->invite();
		
		return(true);
	}

   /**
    * Delete selected Staff Members
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function delete($list)
	{
		if(empty($list)) return(false);
		
		$dbh = dbConnection::get()->handle();
		
		$selected = '';
		
		foreach($list as $id => $staff)
		{
			$selected .= $id.',';
		}
		
		$selected .= '0';	// Dummy value to finish the list 
		
		$sql  = "DELETE FROM app_users WHERE userID IN ({$selected})";
		$affected =& $dbh->exec($sql);
		
		$sqli = "DELETE FROM app_userGroups WHERE userID IN ({$selected})";
		$dbh->exec($sqli);
		
		$sqlj = "DELETE FROM app_staffProjects WHERE staffID IN ({$selected})";
		$dbh->exec($sqlj);
		
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
	* Dependant on: class.mailer.inc.php
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
		$email = file_get_contents(APP_ROOT.'/inc/emails/english/staff.invitation.txt');
		
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
					   ,'Staff Invitation'
					   )";
		
		$affected =& $dbh->exec($sql);
		
		return(true);
	}
}
?>