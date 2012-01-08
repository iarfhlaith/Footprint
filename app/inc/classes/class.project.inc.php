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
class project
{
   /**
    * The projectID of the selected project
    *
    * @var 	public object
    */
	private $projID;
	
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
    * Sets the projectID
    *
	* @access 	public
	* @return 	void
    */
	public  function select($id)
	{
		$this->projID = $id;
	}
	
   /**
    * Gets the projectID
    *
	* @access 	public
	* @return 	integer - The projID of the selected project
    */
	public  function getProjID()
	{
		return($this->projID);
	}
	
   /**
    * Load information for the selected project
	*
	* This will return the details of a project
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.footprint.inc.php
	*
	* @access 	public
	* @param	integer	- An optional filter that ensures only projects owned by the provided client can be accessed 
	* @return 	array 	- An associative array of the project information
	*/
	public  function loadProject($client='')
	{
		$aid = $this->getAccID(); 
		$pid = $this->getProjID();
		
		$dbh = dbConnection::get()->handle();
		
		$sql = "SELECT  app_projects.projID
						, app_projects.name
						, app_projects.description
						, app_projects.dateCreated
						, app_projects.visibility
						, app_projects.clientID   AS client
						, app_projects.assignedTo AS manager
						, (SELECT count(*) FROM app_tasks       WHERE projID = '{$pid}' and type = 'request') AS totRequests
						, (SELECT count(*) FROM app_tasks       WHERE projID = '{$pid}' and type = 'task') AS totTasks
						, (SELECT count(*) FROM app_screenshots INNER JOIN app_tasks ON app_screenshots.taskID = app_tasks.taskID WHERE app_tasks.projID = '{$pid}') AS totScreenshots
						, (SELECT count(*) FROM app_documents   INNER JOIN app_tasks ON app_documents.taskID   = app_tasks.taskID WHERE app_tasks.projID = '{$pid}') AS totDocuments
						, (SELECT SUM(size) FROM app_documentVersions
							INNER JOIN app_documents ON app_documentVersions.docID = app_documents.docID
							INNER JOIN app_tasks     ON app_documents.taskID       = app_tasks.taskID
						   WHERE app_tasks.projID = '{$pid}') AS totDocSize
						, tmp_clients.clientOrganisation
						, tmp_clients.userID
						, app_users.firstname
						, app_users.lastname
					
					FROM app_projects
					
					INNER JOIN app_users ON app_projects.assignedTo = app_users.userID
					INNER JOIN app_users AS tmp_clients ON app_projects.clientID = tmp_clients.userID
				  
				  WHERE app_projects.projID = '{$pid}' AND app_projects.accID = '{$aid}'";
		
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
    * Create a new project for the logged user's account
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	integer|void - The id of the newly added project
	*/
	public function create($vars)
	{
		// Timestamp
		$timestamp = time();
		
		$dbh   = dbConnection::get()->handle();
		
		// Add Client Record
		$sql = "INSERT INTO app_projects
				 ( accID
				 , clientID
				 , assignedTo
				 , dateCreated
				 , name
				 , description
				 , visibility
				 )
				 
				VALUES
				 ('{$vars['accID']}'
				 ,'{$vars['client']}'
				 ,'{$vars['manager']}'
				 ,'{$timestamp}'
				 ,'{$vars['name']}'
				 ,'{$vars['description']}'
				 ,'{$vars['visible']}')";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch ProjectID
		$id = $dbh->lastInsertID('app_projects', 'projID');

		// Give Access to Staff with Default Access Enabled
		$sql = '';
		foreach($vars['defaultAccess'] as $sid)
		{
			$sql .= "INSERT INTO app_staffProjects (staffID, projectID) VALUES ('{$sid}', '{$id}'); ";
		}
		if(!empty($sql)) $dbh->exec($sql);
		
		return($id);
	}

   /**
    * Update details of existing project
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function update($vars)
	{	
		$visibility = false;
		$dbh   = dbConnection::get()->handle();
		
		// Update Visibility Status
		if(isset($vars['visible'])) $visibility = '1';
		
		$sql = "UPDATE app_projects SET
		
				      clientID = '{$vars['client']}'
				 ,  assignedTo = '{$vars['manager']}'
				 ,		  name = '{$vars['name']}'
				 ,  visibility = '{$visibility}'
				 , description = '{$vars['description']}'
		
				WHERE projID = '{$vars['projID']}'";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		return(true);
	}

   /**
    * Delete selected project(s)
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
		
		// Build list of tasks and requests assigned to selected projects
		$tasks       =  array();
		$sql         =  "SELECT taskID FROM app_tasks WHERE projID IN ({$sel})";
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
		
		// Delete core project data
		$sql = "DELETE FROM app_projects 			WHERE projID 		IN ({$sel})";
		$affected =& $dbh->exec($sql);
		
		$sql = "DELETE FROM app_tasks 				WHERE projID 		IN ({$sel})";
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
    * Load information for the selected project
	*
	* This will return the details of a project
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.footprint.inc.php
	*
	* @access 	public
	* @return 	array - An associative array of the project information
	*/
	public  function loadAssignedProject()
	{
		$aid   = $this->getAccID(); 
		$pid   = $this->getProjID();
		
		$dbh   = dbConnection::get()->handle();
		
		$sql   = "SELECT  app_projects.projID
						, app_projects.name
						, app_projects.description
						, app_projects.dateCreated
						, app_projects.visibility
						, app_projects.clientID   AS client
						, app_projects.assignedTo AS manager
						, (SELECT count(*) FROM app_tasks       WHERE projID = '{$pid}' and type = 'request') AS totRequests
						, (SELECT count(*) FROM app_tasks       WHERE projID = '{$pid}' and type = 'task') AS totTasks
						, (SELECT count(*) FROM app_screenshots INNER JOIN app_tasks ON app_screenshots.taskID = app_tasks.taskID WHERE app_tasks.projID = '{$pid}') AS totScreenshots
						, (SELECT count(*) FROM app_documents   INNER JOIN app_tasks ON app_documents.taskID   = app_tasks.taskID WHERE app_tasks.projID = '{$pid}') AS totDocuments
						, (SELECT SUM(size) FROM app_documentVersions
							INNER JOIN app_documents ON app_documentVersions.docID = app_documents.docID
							INNER JOIN app_tasks     ON app_documents.taskID       = app_tasks.taskID
						   WHERE app_tasks.projID = '{$pid}') AS totDocSize
						, tmp_clients.clientOrganisation
						, app_users.firstname
						, app_users.lastname
					
					FROM app_projects
					
					INNER JOIN app_users ON app_projects.assignedTo = app_users.userID
					INNER JOIN app_users AS tmp_clients ON app_projects.clientID = tmp_clients.userID
					
					INNER JOIN app_staffProjects ON app_projects.projID = app_staffProjects.projectID
				  
				  WHERE app_projects.projID = '{$pid}' AND app_projects.accID = '{$aid}'";
		
		$result =& $dbh->query($sql);
		
		return($result->fetchRow());
	}	

}
?>