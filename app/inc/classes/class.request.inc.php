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
class request
{
   /**
    * The requestID of the selected request
    *
    * @var 	public object
    */
	private $requestID;
	
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
	* @access 	private
	* @return 	void
    */
	private function setUserID($userID)
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
	* @access 	private
	* @param 	integer $accid - The accID of the logged in person
	* @return 	void
    */
	private function setAccID($accID)
	{
		$this->accID = $accID; 
	}

   /**
    * Sets the projectID
    *
	* @access 	public
	* @return 	void
    */
	public  function select($id)
	{
		$this->requestID = $id;
	}
	
   /**
    * Create a new request for the selected user and project
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	integer|void - The id of the newly added request
	*/
	public function create($vars)
	{
		// Timestamp
		$timestamp = time();
		
		$userID = $this->getUserID();
		
		$dbh    = dbConnection::get()->handle();
		
		// Add Client Record
		$sql = "INSERT INTO app_tasks
				 ( projID
				 , title
				 , description
				 , assignedTo
				 , status
				 , createdBy
				 , type
				 , createdOn
				 )
				 
				VALUES
				 ('{$vars['project']}'
				 ,'{$vars['request']}'
				 ,'{$vars['description']}'
				 ,'{$vars['manager']}'
				 ,''
				 ,'{$userID}'
				 ,'request'
				 ,'{$timestamp}'
				 )";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch RequestID
		$id = $dbh->lastInsertID('app_tasks', 'taskID');
		
		return($id);
	}

   /**
    * Update details of existing request
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function update($vars)
	{	
		$dbh = dbConnection::get()->handle();

		$sql = "UPDATE app_tasks SET
					
					    projID = '{$vars['project']}'
				 ,       title = '{$vars['title']}'
			     , description = '{$vars['description']}'
				 ,  assignedTo = '{$vars['manager']}'
				 ,      status = 'Draft'
				 
				  WHERE taskID = '{$vars['requestID']}'";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		return(true);
	}
	
   /**
    * Delete selected request(s)
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function delete($list)
	{
		if(empty($list)) return(false);
		
		if(is_array($list))
		{
			$sel  = arrayToList($list, 'index');
		}
		else $sel = $list;
		
		$dbh = dbConnection::get()->handle();

		$sql = "DELETE FROM app_tasks WHERE taskID IN ({$sel}) AND type = 'request'";
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
    * Convert selected request(s) into tasks
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function convert($list)
	{
		if(empty($list)) return(false);
		
		if(is_array($list))
		{
			$sel  = arrayToList($list, 'index');
		}
		else $sel = $list;
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "UPDATE app_tasks SET type = 'task', status = 'N/A' WHERE taskID IN ({$sel})";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		return(true);
	}

  /**
    * Reject selected request(s)
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function reject($list, $note=false)
	{
		if(empty($list)) return(false);
		
		if(is_array($list))
		{
			$sel  = arrayToList($list, 'index');
		}
		else $sel = $list;
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "UPDATE app_tasks SET status = 'Rejected'";
		
		if($note)
		{
			$note = cleanValue($note);
			$sql .= ", replyNote = '{$note}'";
		}
		
		$sql .= " WHERE taskID IN ({$sel}) AND type = 'request'";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		return(true);
	}

   /**
    * Gets the requestID
    *
	* @access 	public
	* @return 	integer - The requestID of the selected request
    */
	public  function getRequestID()
	{
		return($this->requestID);
	}
	
   /**
    * Load information for the selected request
	*
	* This will return the details of a request
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.footprint.inc.php
	*
	* @access 	public
	* @param	integer	- An optional filter that ensures only requests owned by the provided client can be accessed 
	* @return 	array 	- An associative array of the request information
	*/
	public  function loadRequest($client='')
	{
		$rid   = $this->getRequestID();
		
		$dbh   = dbConnection::get()->handle();
		
		$sql   = "SELECT  app_tasks.taskID
						, app_tasks.projID
						, app_tasks.title
						, app_tasks.description
						, app_tasks.status
						, app_tasks.createdOn
						, app_tasks.replyNote
						, app_tasks.projID AS project
						, app_projects.name
						, app_users.firstname
						, app_users.lastname
						, tmp_clients.clientOrganisation
					
					FROM app_tasks
					
					INNER JOIN app_projects ON app_tasks.projID    = app_projects.projID
					INNER JOIN app_users	ON app_tasks.createdBy = app_users.userID
					
					INNER JOIN app_users AS tmp_clients ON app_projects.clientID = tmp_clients.userID
				  
				  WHERE app_tasks.taskID = '{$rid}' AND app_tasks.type = 'request'";
		
		if(is_numeric($client))
		{
			$sql .= " AND app_projects.clientID = '{$client}'";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $sql .= " AND app_projects.visibility = '1'";
		}
		
		$result =& $dbh->query($sql);
		
		return($result->fetchRow());
	}

   /**
    * Load information for the selected request
	*
	* This will return the details of a request
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.footprint.inc.php
	*
	* @access 	public
	* @return 	array - An associative array of the request information
	*/
	public  function loadAssignedRequest()
	{
		$rid   = $this->getRequestID();
		
		$dbh   = dbConnection::get()->handle();
		
		$sql   = "SELECT  app_tasks.taskID
						, app_tasks.projID
						, app_tasks.title
						, app_tasks.description
						, app_tasks.status
						, app_tasks.createdOn
						, app_tasks.replyNote
						, app_projects.name
						, app_users.firstname
						, app_users.lastname
						, tmp_clients.clientOrganisation
					
					FROM app_tasks
					
					INNER JOIN app_projects ON app_tasks.projID    = app_projects.projID
					INNER JOIN app_users	ON app_tasks.createdBy = app_users.userID
					
					INNER JOIN app_staffProjects ON app_projects.projID = app_staffProjects.projectID
					
					INNER JOIN app_users AS tmp_clients ON app_projects.clientID = tmp_clients.userID
				  
				  WHERE app_tasks.taskID = '{$rid}' AND app_tasks.type = 'request'";
		
		$result =& $dbh->query($sql);
		
		return($result->fetchRow());
	}	
}
?>