<?php
/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        class.comment.inc.php
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
class comment
{
   /**
    * Stores which type of parent the comment has. (task, project, screenshot etc.)
    *
    * @var 	private string
    */
	private $type;

   /**
    * The unique ID of the comment's parent
    *
    * @var 	private integer
    */
	private $parentID;

   /**
    * The userID of the comment author
    *
    * @var 	private integer
    */
	private $authorID;

   /**
    * The class constructor.
	*
	* It sets up the userID and the accID for the logged
	* user.
	*
    */
	public  function __construct(){}
	
   /**
    * Sets the comment's parent type
	*
	* @param string $type - The comment's parent type
	*
	* @access 	public
	* @return 	void
    */
	public  function setType($type)
	{
		$this->type = $type; 
	}
	
   /**
    * Sets the comment's parent ID number
    *
	* @access 	public
	* @param	integer	- The ID of the parent object (task, project, screenshot etc.)
	* @return 	void
    */
	public  function setParent($parent)
	{
		$this->parentID = $parent;
	}

  /**
    * Sets the userID of the comment author
    *
	* @access 	public
	* @param	integer	- The userID of the comment author
	* @return 	void
    */
	public  function setAuthor($userID)
	{
		$this->authorID = $userID;
	}

   /**
    * Gets the comment's parent type
	*
	* @access 	public
	* @return 	string	- The comment's parent type
    */
	public  function getType()
	{
		return($this->type); 
	}
	
   /**
    * Gets the comment's parent ID number
	*
	* @access 	private
	* @return 	string	- The comment's parent ID number
    */
	public  function getParent()
	{
		return($this->parentID); 
	}
	
   /**
    * Gets the userID of the comments author
	*
	* @access 	private
	* @return 	string	- The userID of the comments author
    */
	public  function getAuthor()
	{
		return($this->authorID); 
	}
	
  /**
    * Sets the account ID
    *
	* @access 	public
	* @param	integer	- The account ID
	* @return 	void
    */
	public  function setAccID($accID)
	{
		$this->accID = $accID;
	}

   /**
    * Gets account ID
	*
	* @access 	public
	* @return 	integer	- The account ID
    */
	public  function getAccID()
	{
		return($this->accID); 
	}

   /**
    * Load the selected comment
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	integer	- The unique identifier for the comment 
	* @return 	array 	- An associative array of the comment information
	*/
	public  function loadComment($id)
	{
		if(!is_numeric($id)) return(false);

		$dbh   = dbConnection::get()->handle();
		
		$sql   = "SELECT  app_comments.id
						, app_comments.comment
						, app_comments.dateCreated
						, app_users.firstname
						, app_users.lastname
						, app_comments.author
					
					FROM app_comments
					
					INNER JOIN app_users ON app_comments.author = app_users.userID
				  
				  WHERE app_comments.id = '{$id}'";
		
		$result  =& $dbh->query($sql);
		$comment = $result->fetchRow();
		
		return($comment);
	}
	
   /**
    * Load all the comments
	*
	* This will return the details of a task
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.footprint.inc.php
	*
	* @access 	public
	* @param	integer	- An optional filter that limits the number of comments returned
	* @return 	array 	- An associative array of the returned comments
	*/
	public  function loadAll($amount='')
	{
		$comments = array();
	
		$type     = $this->getType();
		$parentID = $this->getParent();
		
		$dbh   = dbConnection::get()->handle();
		
		$sql   = "SELECT  app_comments.id
						, app_comments.comment
						, app_comments.dateCreated
						, app_users.firstname
						, app_users.lastname
						, app_comments.author
					
					FROM app_comments
					
					INNER JOIN app_users ON app_comments.author = app_users.userID
				  
				  WHERE app_comments.parentID = '{$parentID}' AND app_comments.parentType = '{$type}'
				  
				  ORDER BY app_comments.dateCreated DESC";
		
		if(is_numeric($amount))
		{
			$dbh->setLimit($amount);
		}
		
		$result =& $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			array_push($comments, $row);
		}
		
		return($comments);
	}
	
   /**
    * Save a comment
	*
	* Save a comment to the database
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	string	- The comment text
	* @param	boolean	- Whether to notify other interested parties about the new comment via email
	* @return 	boolean	- True or False depending on whether the comment saved correctly 
	*/
	public  function create($comment, $notify=false)
	{
		// Timestamp
		$timest = time();
		
		// Load Details
		$author = $this->getAuthor();
		$parent = $this->getParent();
		$type   = $this->getType();
		
		// Check Data Quality
		if(empty($comment) || !is_numeric($author) || !is_numeric($parent) || empty($type)) return(false);
		
		// Connect to Database
		$dbh    = dbConnection::get()->handle();
		
		// Build SQL
		$sql = "INSERT INTO app_comments
				
				(parentID, parentType, comment, dateCreated, author)
				
				VALUES ('{$parent}', '{$type}', '{$comment}', '{$timest}', '{$author}')";
			
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch CommentID
		$id = $dbh->lastInsertID('app_comments', 'id');
		
		// Notify Other Users (if requested)
		if($notify) $this->notify($comment);
		
		return($id);
	}

   /**
    * Update a comment
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	integer	- The unique identifier for the comment
	* @param	string	- The new text for the comment
	* @return 	boolean	- True or False depending on whether the comment updated correctly
	*/
	public  function update($id, $comment)
	{
		if(!is_numeric($id) || empty($comment)) return(false);
		
		$dbh   = dbConnection::get()->handle();

		$sql = "UPDATE app_comments SET comment = '{$comment}' WHERE id = '{$id}'";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		return(true);
	}

   /**
    * Wrapper for isAuthor method for use with SmartyValidate
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param 	integer $commentID - The unique identifier of the comment
	* @param 	array   $formVars  - The submitted form details
	* @return 	boolean
    */
	public  function isAuthorWrapper($commentID, $empty, &$params, &$formvars)
	{
		// Test Parameters
		if (!isset($commentID)) return($empty);
		
		$commentID = cleanValue($commentID);
		
		return($this->isAuthor($commentID, $_SESSION['user']['userID']));
	}

   /**
    * Check if a particular comment is owned by a particular author
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	integer	- The unique identifier of the comment
	* @param	integer	- The unique identifier of the author
	* @return 	boolean	- True or False depending on whether the comment is owned by the author
	*/
	public  function isAuthor($commentID, $author)
	{
		// Check Data Quality
		if(!is_numeric($commentID) || !is_numeric($author)) return(false);
		
		// Connect to Database
		$dbh = dbConnection::get()->handle();
		
		// Build SQL
		$sql = "SELECT * FROM app_comments WHERE id = '{$commentID}' AND author = '{$author}'";
		
		// Execute the query
		$result =& $dbh->query($sql);
		
		// One Row? Excellent, then the comment is owned by the author
		if($result->numRows() == 1) return(true);
		
		return(false);
	}
	
   /**
    * Delete a single comment
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	integer	- The unique identifier of the comment
	* @return 	boolean	- True or False depending on whether the comment deleted correctly
	*/
	public  function delete($commentID)
	{
		// Check Data Quality
		if(!is_numeric($commentID)) return(false);
		
		// Connect to Database
		$dbh    = dbConnection::get()->handle();
		
		// Build SQL
		$sql = "DELETE FROM app_comments WHERE id = '{$commentID}'";
		
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
    * Notify OTHER users via email of the new comment
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	private
	* @param	string	-	The comment...
	* @return 	void
	*/
	private function notify($comment)
	{
		$timest     = time();
		$type       = $this->getType();
		$list       = $this->loadInterestedParties();
		$authorName = $_SESSION['user']['firstname'].' '.$_SESSION['user']['lastname'];
		
		// Connect to Database
		$dbh    = dbConnection::get()->handle();
		
		// Load Email Text
		$email  = file_get_contents(APP_ROOT.'/inc/emails/english/comment.new.txt');
		
		foreach($list AS $vars)
		{
			$copy = $email;
			
			// Merge Variables into Email
			$copy = str_replace('[~firstname~]'   , $vars['firstname']			     , $copy);
			$copy = str_replace('[~comment~]'     , $comment  			     		 , $copy);
			$copy = str_replace('[~author~]'      , $authorName			     		 , $copy);
			$copy = str_replace('[~prefix~]'      , $_SESSION['user']['prefix']      , $copy);
			$copy = str_replace('[~organisation~]', $_SESSION['user']['organisation'], $copy);
			
			$subj  = "New Comment by ".$authorName." on ".$_SESSION['user']['organisation']."'s Online Services";
	
			$recipient = html_entity_decode($vars['email'], ENT_QUOTES);
	
			// Send Notification Email
			$mail = new mailer;
			$mail->from($_SESSION['user']['ownerEmail'], $_SESSION['user']['ownerFirstname'].' '.$_SESSION['user']['ownerLastname'].'('.$_SESSION['user']['organisation'].')');
			$mail->add_recipient($recipient);
			$mail->subject($subj);
			$mail->message($copy);
			//$result = $mail->send();
	
			// Scrub Email Content
			$cleanEmail = cleanValue($copy);
			$cleanSubj  = cleanValue($subj);
	
			// Save A Copy
			$sql = "INSERT INTO app_emails (accID, content, dateCreated, sendStatus, subject, sentTo, type)
			
					VALUES ('{$_SESSION['user']['accID']}'
						   ,'{$cleanEmail}'
						   ,'{$timest}'
						   ,'{$result}'
						   ,'{$cleanSubj}'
						   ,'{$recipient}'
						   ,'New Comment on a {$type}'
						   )";
	
			$dbh->exec($sql);
		}
	}

   /**
    * Load a List of Interested Parties
    * 
    * Including...
    * - Account Owner (all cases)
    * - Staff members (if assigned)
    * - Client (if has access)
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	private
	* @return 	array	- An array of userIDs who are interested in the comment
	*/
	private function loadInterestedParties()
	{	
		$parties      = array();
		$parent       = $this->getParent();
		$type         = $this->getType();
		
		if($type == 'screenshot')
		{
			// Load the grandparent taskID of the comment.
			$parent = $this->loadScreenshotParent($parent);
		}
		
		$currentUser  = $_SESSION['user']['userID'];
		$accountOwner = array('userID' => $_SESSION['user']['ownerID']
						 , 'firstname' => $_SESSION['user']['ownerFirstname']
						 ,     'email' => $_SESSION['user']['ownerEmail']);

		// Connect to Database
		$dbh = dbConnection::get()->handle();
		
		// Fetch staff who are assigned to the project
		$sql = "SELECT app_staffProjects.staffID AS userID
					 , app_users.firstname
					 , app_users.email
		
				FROM app_staffProjects
				
				INNER JOIN app_users ON app_staffProjects.staffID   = app_users.userID
				INNER JOIN app_tasks ON app_staffProjects.projectID = app_tasks.projID

				WHERE app_tasks.taskID = '{$parent}'
				  AND app_staffProjects.staffID != '{$currentUser}'";
		
		$res =& $dbh->query($sql);
		while($row = $res->fetchRow()) array_push($parties, $row);
		
		// Fetch Client if they have access rights
		$sql = "SELECT app_projects.clientID AS userID
					 , app_users.firstname
					 , app_users.email
				
				FROM app_projects

				INNER JOIN app_users ON app_projects.clientID = app_users.userID
				INNER JOIN app_tasks ON app_projects.projID   = app_tasks.projID

				WHERE app_tasks.taskID = '{$parent}'
				  AND visibility >= '1' AND clientID != '{$currentUser}'";
		
		$res =& $dbh->query($sql);
		while($row = $res->fetchRow()) array_push($parties, $row);
		
		// Push Account Owner onto Array
		if($accountOwner['userID'] != $currentUser) array_push($parties, $accountOwner);
		
		return($parties);
	}

  /**
    * Load the task parent id of the supplied screenshot child id.
    *
	* Dependant on: class.db.inc.php
	*
	* @access 	private
	* @return 	array	- An array of userIDs who are interested in the comment
	*/
	private function loadScreenshotParent($parent)
	{
		if(!is_numeric($parent)) return(false);
		
		// Connect to Database
		$dbh = dbConnection::get()->handle();
		
		$sql = "SELECT taskID FROM app_screenshots WHERE screenshotID = '{$parent}'";
		
		$result  =& $dbh->query($sql);
		$data    = $result->fetchRow();
		
		return($data['taskID']);
	}
}
?>