<?php
/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        class.task.inc.php
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
class task
{
   /**
    * Used to assign comment objects into a footprint task. 
    *
    * @var 	public object
    */
	public  $comments;

   /**
    * The requestID of the selected task
    *
    * @var 	public object
    */
	private $taskID;
	
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
		$this->taskID = $id;
	}
	
   /**
    * Create a new task for the selected user and project
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	integer|void - The id of the newly added task
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
				 ,'{$vars['task']}'
				 ,'{$vars['description']}'
				 ,'{$vars['manager']}'
				 ,'{$vars['status']}'
				 ,'{$userID}'
				 ,'task'
				 ,'{$timestamp}'
				 )";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch TaskID
		$id = $dbh->lastInsertID('app_tasks', 'taskID');
		
		return($id);
	}

   /**
    * Update details of existing task
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function update($vars)
	{	
		$dbh   = dbConnection::get()->handle();

		$sql = "UPDATE app_tasks SET
					
					    projID = '{$vars['project']}'
				 ,       title = '{$vars['title']}'
			     , description = '{$vars['description']}'
				 ,  assignedTo = '{$vars['manager']}'
				 ,      status = '{$vars['status']}'
				 
				  WHERE taskID = '{$vars['taskID']}'";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		return(true);
	}
	
   /**
    * Delete selected task(s)
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
		
		// Build list of screenshots assigned to selected tasks
		$screens     =  array();
		$sql         =  "SELECT screenshotID FROM app_screenshots WHERE taskID IN ({$sel})";
		$result      =& $dbh->query($sql);
		while($row   =  $result->fetchRow()) array_push($screens, $row['screenshotID']);
		$listScreens =  arrayToList($screens);
		
		// Build list of documents assigned to selected tasks
		$docs        =  array();
		$sql         =  "SELECT docID FROM app_documents WHERE taskID IN ({$sel})";
		$result      =& $dbh->query($sql);
		while($row   =  $result->fetchRow()) array_push($docs, $row['docID']);
		$listDocs    =  arrayToList($docs);

		$sql = "DELETE FROM app_tasks 				WHERE taskID 		IN ({$sel})";
		$affected =& $dbh->exec($sql);
		
		$sql = "DELETE FROM app_documents 			WHERE taskID 		IN ({$sel})";
		$dbh->exec($sql);
		
		$sql = "DELETE FROM app_documentVersions 	WHERE docID 		IN ({$listDocs})";
		$dbh->exec($sql);
		
		$sql = "DELETE FROM app_screenshots 		WHERE taskID 		IN ({$sel})";
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
    * Gets the taskID
    *
	* @access 	public
	* @return 	integer - The taskID of the selected task
    */
	public  function getTaskID()
	{
		return($this->taskID);
	}
	
   /**
    * Load information for the selected task
	*
	* This will return the details of a task
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.footprint.inc.php
	* Dependant on: class.comment.inc.php
	*
	* @access 	public
	* @param	integer	- An optional filter that ensures only tasks owned by the provided client can be accessed 
	* @return 	array 	- An associative array of the task information
	*/
	public  function loadTask($client='')
	{
		$tid   = $this->getTaskID();
		
		if(!is_numeric($tid)) return(false);
		
		$dbh   = dbConnection::get()->handle();
		
		$sql   = "SELECT  app_tasks.taskID
						, app_tasks.projID
						, app_tasks.title
						, app_tasks.description
						, app_tasks.status
						, app_tasks.createdOn
						, app_tasks.assignedTo AS manager
						, app_tasks.projID     AS project
						, app_projects.name
						, app_users.firstname
						, app_users.lastname
						, tmp_clients.clientOrganisation
					
					FROM app_tasks
					
					INNER JOIN app_projects ON app_tasks.projID    = app_projects.projID
					INNER JOIN app_users	ON app_tasks.createdBy = app_users.userID
					
					INNER JOIN app_users AS tmp_clients ON app_projects.clientID = tmp_clients.userID
				  
				  WHERE app_tasks.taskID = '{$tid}' AND app_tasks.type = 'task'";
		
		if(is_numeric($client))
		{
			$sql .= " AND app_projects.clientID = '{$client}'";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $sql .= " AND app_projects.visibility = '1'";
		}
		
		$result =& $dbh->query($sql);
		$task   = $result->fetchRow();
		
		// Load Task Comments
		$this->comments = new comment;
		$this->comments->setType('task');
		$this->comments->setParent($task['taskID']);
		
		$comments = $this->comments->loadAll();
		
		array_push_associative($task, array('comments' => $comments));
		
		return($task);
	}

   /**
    * Load information for the selected task
	*
	* This will return the details of a task
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.footprint.inc.php
	*
	* @access 	public
	* @return 	array - An associative array of the task information
	*/
	public  function loadAssignedTask()
	{
		$tid   = $this->getTaskID();
		
		if(!is_numeric($tid)) return(false);
		
		$dbh   = dbConnection::get()->handle();
		
		$sql   = "SELECT  app_tasks.taskID
						, app_tasks.projID
						, app_tasks.title
						, app_tasks.description
						, app_tasks.status
						, app_tasks.createdOn
						, app_projects.name
						, app_users.firstname
						, app_users.lastname
						, tmp_clients.clientOrganisation
					
					FROM app_tasks
					
					INNER JOIN app_projects ON app_tasks.projID    = app_projects.projID
					INNER JOIN app_users	ON app_tasks.createdBy = app_users.userID
					
					INNER JOIN app_staffProjects ON app_projects.projID = app_staffProjects.projectID
					
					INNER JOIN app_users AS tmp_clients ON app_projects.clientID = tmp_clients.userID
				  
				  WHERE app_tasks.taskID = '{$tid}' AND app_tasks.type = 'task'";
		
		$result =& $dbh->query($sql);
		$task   = $result->fetchRow();
		
		// Load Task Comments
		$this->comments = new comment;
		$this->comments->setType('task');
		$this->comments->setParent($task['taskID']);
		
		$comments = $this->comments->loadAll();
		
		array_push_associative($task, array('comments' => $comments));
		
		return($task);
	}	
}
?>