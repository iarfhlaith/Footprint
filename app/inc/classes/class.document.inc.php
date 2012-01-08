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
class document
{
   /**
    * The docID of the selected document
    *
    * @var 	public object
    */
	private $docID;
	
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
    * Sets the docID
    *
	* @access 	public
	* @return 	void
    */
	public  function select($id)
	{
		$this->docID = $id;
	}
	
   /**
    * Gets the docID
    *
	* @access 	public
	* @return 	integer - The docID of the selected document
    */
	public  function getDocID()
	{
		return($this->docID);
	}
	
   /**
    * Load the details for the selected Document
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.footprint.inc.php
	*
	* @access 	public
	* @param	integer	- $clientID		- Filter the results based on the clientID provided.
	* @param	boolean - $assignedOnly - A marker to filter all but the docs that are attached to an assigned project.
	* @return 	array 	- The details of the selected document (including a list of previous versions)
	*/
	public function loadDocument($clientID='', $assignedOnly=false, $loadVersions=true)
	{
		$did   = $this->getDocID();
		$accID = $this->getAccID();

		$dbh   = dbConnection::get()->handle();
		
		$sql = "SELECT app_documents.title, app_documents.docType, app_documents.docID, app_documents.clientAccess
		
				FROM app_documents
				
				INNER JOIN app_tasks     ON app_documents.taskID = app_tasks.taskID
				INNER JOIN app_projects  ON app_tasks.projID     = app_projects.projID";
		
		if($assignedOnly)
		{
			$sql .= " INNER JOIN app_staffProjects ON app_projects.projID = app_staffProjects.projectID";
		}
		
		$sql .= " WHERE app_documents.docID = '{$did}'";
		
		if(is_numeric($clientID))
		{
			$sql .= " AND app_projects.clientID = '{$clientID}' AND app_documents.clientAccess > 0";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $sql .= " AND app_projects.visibility = '1'";
		}
		
		$result   =& $dbh->query($sql);
		$document = $result->fetchRow();
		
		if($loadVersions)
		{
			array_push_associative($document, array('versions' => $this->loadVersions()));
		}
		
		return($document);
	}

   /**
	* Load Document Information (not the actual document)
	* based on the versionID provided.
	*
	* Dependant on: class.db.inc.php
	*
	* @access	public
	* @param	integer - $versionID	- The unique id of the actual data (stored in Amazon's S3 service)
	* @param	integer	- $clientID		- Filter the results based on the clientID provided.
	* @param	boolean - $assignedOnly - A marker to filter all but the docs that are attached to an assigned project.
	* @return 	array 	- The details of the selected document (including a list of previous versions)	
	*/
	public function loadDocFromVersionID($versionID, $clientID='', $assignedOnly=false)
	{
		$accID = $this->getAccID();
		
		$dbh   = dbConnection::get()->handle();
		
		$sql = "SELECT app_documents.docID, app_documents.title, app_documents.mime, app_documents.docType
		
				FROM app_documents
				
				INNER JOIN app_documentVersions ON app_documents.docID  = app_documentVersions.docID
				INNER JOIN app_tasks            ON app_documents.taskID = app_tasks.taskID
				INNER JOIN app_projects         ON app_tasks.projID     = app_projects.projID";
		
		if($assignedOnly)
		{
			$sql .= " INNER JOIN app_staffProjects ON app_projects.projID = app_staffProjects.projectID";
		}
		
		$sql .= " WHERE app_documentVersions.versionID = '{$versionID}'";
		
		if(is_numeric($clientID))
		{
			$sql .= " AND app_projects.clientID = '{$clientID}' AND app_documents.clientAccess > 0";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $sql .= " AND app_projects.visibility = '1'";
		}
		
		$result =& $dbh->query($sql);
		$doc    = $result->fetchRow();
		
		if(isset($doc['docID']))
		{
			array_push_associative($doc, array('data' => $this->loadS3Object($versionID)));
		}
		
		return($doc);
	}

   /**
    * Load a list of all the document's versions for the selected document.
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.footprint.inc.php
	*
	* @access 	private
	* @return 	array 	- An associative array with information about the document's previous versions
	*/
	private function loadVersions()
	{
		$did   = $this->getDocID();
		$accID = $this->getAccID();
		
		$versions = array();
		
		$dbh   = dbConnection::get()->handle();
		
		$sql   = "SELECT  app_documentVersions.versionID
						, app_documentVersions.revisionDate
						, app_documentVersions.comment
						, app_documentVersions.version
						, app_documentVersions.size
						, app_documentVersions.author
						, app_users.firstname
						, app_users.lastname
					
					FROM app_documentVersions
					
					INNER JOIN app_users ON app_documentVersions.author = app_users.userID
					
					INNER JOIN app_documents ON app_documentVersions.docID = app_documents.docID
					INNER JOIN app_tasks     ON app_documents.taskID       = app_tasks.taskID
					INNER JOIN app_projects  ON app_tasks.projID           = app_projects.projID
				  
				  WHERE app_documentVersions.docID = '{$did}'
				    AND app_projects.accID         = '{$accID}'
				  
				  ORDER BY app_documentVersions.versionID DESC";
		
		$result =& $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			array_push($versions, $row);
		}
		
		return($versions);
	}
	
   /**
	* Load the S3 Object using the S3 PHP class and REST interface
	*
	* All Footprint document objects are stored in S3's documents.footprinthq.com bucket.
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.s3.inc.php
	*
	* @access	private
	* @param	integer - $id	- The id of the object. Which is also its name within the S3 bucket
	*/
	private function loadS3Object($id)
	{
		require_once('Crypt/HMAC.php');
		require_once 'HTTP/Request.php';

		$bucket = 'documents.footprinthq.com';

		$s3     = new s3();
		
		$data   = $s3->getObject($id , $bucket);
		$info   = $s3->getObjectInfo($id, $bucket);
		
		return(array('info' => $info, 'contents' => $data));
	}

   /**
	* Save the Document metadata into Database
	*
	* All Footprint document objects are stored in S3's documents.footprinthq.com bucket.
	* This method stores the associated metadata and then calls another method to insert
	* the actual file into S3.
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.upload.inc.php
	*
	* @access	private
	* @param	integer - $id	- The id of the object. Which is also its name within the S3 bucket
	*/
	public function save($vars, $file)
	{
		$date = time();
		$dbh  = dbConnection::get()->handle();
		
		// Check Vars and File are Not Empty
		if(empty($vars['name']) || empty($file)) return(false);
		
		// Create New Task if Necessary
		if(!empty($vars['newTaskName']))
		{
			$vars['task'] = $this->createNewTask($vars);
		}
		
		// Start Upload Class
		$handle = new upload($file);
		
		$fileMime = $handle->file_src_mime;
		$fileSize = $handle->file_src_size;
		$fileExt  = $handle->file_src_name_ext;
		$fileData = $handle->Process();
		
		// Insert Document Metadata
		$sql = "INSERT INTO app_documents
				 ( taskID
				 , title
				 , docType
				 , mime
				 , lastAccessed
				 , author
				 , clientAccess)
				 
				VALUES
				 ('{$vars['task']}'
				 ,'{$vars['name']}'
				 ,'{$fileExt}'
				 ,'{$fileMime}'
				 ,'{$date}'
				 ,'{$_SESSION['user']['userID']}'
				 ,'{$vars['access']}')";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch DocumentID
		$docID = $dbh->lastInsertID('app_documents', 'docID');
		
		// Insert Document Version Metadata
		$sql = "INSERT INTO app_documentVersions
				 ( docID
				 , revisionDate
				 , comment
				 , version
				 , size
				 , author)
				 
				VALUES
				 ('{$docID}'
				 ,'{$date}'
				 ,'Original'
				 ,'1'
				 ,'{$fileSize}'
				 ,'{$_SESSION['user']['userID']}')";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch DocumentID
		$verID = $dbh->lastInsertID('app_documentVersions', 'versionID');
		
		// Transfer file to S3
		if(!$this->uploadS3Object($verID, $fileData, $fileMime)) $docID = false;

		return($docID);
	}

   /**
	* Update the selected Document
	*
	* All Footprint document objects are stored in S3's documents.footprinthq.com bucket.
	* This method stores the associated metadata and then calls another method to insert
	* the actual file into S3.
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.upload.inc.php
	*
	* @access	private
	* @param	integer - $id	- The id of the object. Which is also its name within the S3 bucket
	*/
	public function update($vars, $file)
	{
		$date = time();
		$dbh  = dbConnection::get()->handle();
		
		// Check Vars and File are Not Empty
		if(empty($vars['id']) || empty($file)) return(false);
		
		// Start Upload Class
		$handle = new upload($file);
		
		$fileMime = $handle->file_src_mime;
		$fileSize = $handle->file_src_size;
		$fileExt  = $handle->file_src_name_ext;
		$fileData = $handle->Process();
		
		$nextVersion = $vars['version'] + 1;
		
		// Update Document Metadata
		$sql = "UPDATE app_documents SET mime = '{$fileMime}'
							   , clientAccess = '{$vars['access']}'
							   , lastAccessed = '{$date}'
							   ,      docType = '{$fileExt}'
				
				WHERE docID = '{$vars['id']}'";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Insert Document Version Metadata
		$sql = "INSERT INTO app_documentVersions
				 ( docID
				 , revisionDate
				 , comment
				 , version
				 , size
				 , author)
				 
				VALUES
				 ('{$vars['id']}'
				 ,'{$date}'
				 ,'{$vars['comment']}'
				 ,'{$nextVersion}'
				 ,'{$fileSize}'
				 ,'{$_SESSION['user']['userID']}')";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch DocumentID
		$verID = $dbh->lastInsertID('app_documentVersions', 'versionID');
		
		// Transfer file to S3
		if(!$this->uploadS3Object($verID, $fileData, $fileMime)) $vars['id'] = false;

		return($vars['id']);
	}

  /**
	* Create a New Task if Required.
	* 
	* This method provides the absolute minimum amount of information necessary
	* to create a new task. It uses the task class to actually create it.
	*
	* Dependant on: class.db.inc.php
	*
	* @access	private
	* @param	array   - $vars   - The data required to create a task.
	* @return	integer - $taskID - The unique identifier of the new task.
	*/
	private function createNewTask($vars)
	{
		$dbh  = dbConnection::get()->handle();
		
		$fp->task = new task;
		$taskVars = array('task' => $vars['newTaskName']
			,	   'description' => ''
			,		   'project' => $vars['project']
			,		   'manager' => $_SESSION['user']['userID']
			,		    'status' => 'N/A');
		
		$fp->task->setUserID($_SESSION['user']['userID']);
		$fp->task->create($taskVars);
		
		return($dbh->lastInsertID('app_tasks', 'taskID'));
	}	

   /**
	* Upload the S3 Object using the S3 PHP class and REST interface
	*
	* All Footprint document objects are stored in S3's documents.footprinthq.com bucket.
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.s3.inc.php
	*
	* @access	private
	* @param	integer - $id	- The id of the object. Which will also be its name within the S3 bucket
	* @param	mixed   - $data	- The actual data of the object.
	*/
	private function uploadS3Object($id, $data, $mime)
	{
		require_once('Crypt/HMAC.php');
		require_once 'HTTP/Request.php';
		
		$s3     = new s3();
		$bucket = 'documents.footprinthq.com';
		
		$result = $s3->putObject($id, $data, $bucket, 'private', $mime);
		
		return($result);
	}
	
   /**
    * Delete selected document(s)
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.s3.inc.php
	*
	* @access 	public
	* @param	array   - $list	- An array of the documentID's to be deleted
	* @param	boolean - $checkClientAccess - if true, the document metadata will be checked to see if the client has permission to delete the file(s).
	* @return 	boolean
	*/
	public function delete($list, $checkClientAccess=false)
	{
		if(empty($list)) return(false);
		
		$sel = arrayToList($list, 'index');
		$dbh = dbConnection::get()->handle();
		
		if($checkClientAccess)
		{
			if(!$this->clientHasAccess($list)) return(false);
		}
		
		$sql = "DELETE FROM app_documents 			WHERE docID 		IN ({$sel})";
		$affected = $dbh->exec($sql);
		
		$sql = "DELETE FROM app_documentVersions 	WHERE docID 		IN ({$sel})";
		$dbh->exec($sql);
		
		// We don't delete actual data from S3. This is a strategic decision so that it is possible (but difficult) to rescue a deleted file.
		
		// Check for Errors
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
    * Loads all the document information on the array submitted to the method.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	array	- $list An array of the documentID's to be renamed
	* @param	boolean - $checkClientAccess If true, the document metadata will be checked to see if the client has permission to rename the file(s).
	* @return 	array 	- An associative array of all the docs names, docTypes, and docIDs
	*/
	public function loadDocNames($list, $checkClientAccess=false)
	{
		$docNames = array();
		
		$dbh = dbConnection::get()->handle();
		
		if($checkClientAccess)
		{
			if(!$this->clientHasAccess($list)) return(false);
		}
		
		if(is_array($list))
		{
			$list = arrayToList($list, 'index');
		}
		else
		{
			$dbh->setLimit(1);
		}
		
		$sql = "SELECT app_documents.title AS docTitle
				     , app_documents.docType
					 , app_documents.docID
					 , app_documents.clientAccess AS access
					 , app_documentVersions.version
				
				FROM app_documents
				
				INNER JOIN app_documentVersions ON app_documents.docID = app_documentVersions.docID
				
				WHERE app_documents.docID IN ({$list}) ORDER BY app_documentVersions.version DESC";
		
		$result =& $dbh->query($sql);
		
		if(is_numeric($list))
		{
			return($result->fetchRow());
		}
		else
		{
			while($row = $result->fetchRow()) array_push($docNames, $row);
			return($docNames);
		}
	}
	
   /**
    * Loads all the document information so that the documentRename form 
    * can display correctly.
    * 
    * This method is a spin out from the loadDocNames() method. This
    * needed to happen because of the differences in sql statements between the two. loadDocNames() needed
    * version information and this request was returning more then one row for a single docID, so rather then
    * adapt the code to suit both circumstances I chose to split it into two methods instead.
    * 
    * This should make things more readable, scalable, and adaptable in the future.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	array	- $list An array of the documentID's to be renamed
	* @param	boolean - $checkClientAccess If true, the document metadata will be checked to see if the client has permission to rename the file(s).
	* @return 	array 	- An associative array of all the docs names, docTypes, and docIDs
	*/
	public function loadDocsForRename($list, $checkClientAccess=false)
	{
		$docNames = array();
		
		$dbh = dbConnection::get()->handle();
		
		if($checkClientAccess)
		{
			if(!$this->clientHasAccess($list)) return(false);
		}
		
		$list = arrayToList($list, 'index');
		
		$sql = "SELECT app_documents.title AS docTitle
				     , app_documents.docType
					 , app_documents.docID
					 , app_documents.clientAccess AS access
				
				FROM app_documents
				
				WHERE app_documents.docID IN ({$list})";
		
		$result =& $dbh->query($sql);
		
		while($row = $result->fetchRow())
		{
			array_push($docNames, $row);
		}
		
		return($docNames);
	}

   /**
    * Rename the selected document
    * 
    * The method also checks that the user has permission to make the change.
    * This is made on a settings level and also on an account level.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	integer	- $docID The unique identifier of the document
	* @param	string	- $newName The new name for the document
	* @param	boolean - $checkClientAccess If true, the document metadata will be checked to see if the client has permission to rename the file(s).
	* @return 	boolean	- true or false depending on whether the query was successful
	*/
	public function rename($docID, $newName, $checkClientAccess=false)
	{
		$dbh = dbConnection::get()->handle();
		
		if($checkClientAccess)
		{
			if(!$this->clientHasAccess(array($docID =>''))) return(false);
		}
		
		$sql = "UPDATE app_documents SET title = '{$newName}' WHERE docID = '{$docID}'";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		return(true);
	}

  /**
    * Check if the client is permitted to access ALL of the submitted documentIDs
    * 
    * If any of the docIDs that were passed in fail the test then the whole function
    * will return false.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	private
	* @param	array	- $list An array of the documentID's to be renamed
	* @return 	boolean	- true if the user has permission to access all of the selected documents.
	*/
	private function clientHasAccess($list)
	{
		$dbh = dbConnection::get()->handle();
		
		if(is_array($list))
		{
			$list = arrayToList($list, 'index');
		}
		
		$sql = "SELECT clientAccess FROM app_documents WHERE docID IN ({$list})";	
		$res =& $dbh->query($sql);
		
		while($row = $res->fetchRow())
		{
			if($row['clientAccess'] < 2) return(false);
		}
		
		return(true);
	}
	
  /**
    * Security measure to check if all the selected documents belong to the specified account
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	array	- $list    An array of the documentID's to be checked
	* @param	integer	- $accID   The accountID
	* @param	boolean	- $version Optional setting that makes the check be run on the versionID as opposed to the docID, which is done by default
	* @return 	boolean	- true if all the documents belong to the specified account.
	*/
	public function belong($list, $accID, $version=false)
	{
		$dbh = dbConnection::get()->handle();
		
		if(is_array($list))
		{
			$list = arrayToList($list, 'index');
		}
		
		$sql = "SELECT app_projects.accID

				FROM app_projects

				INNER JOIN app_tasks     ON app_projects.projID = app_tasks.projID
				INNER JOIN app_documents ON app_tasks.taskID    = app_documents.taskID";
		
		if($version)
		{
			$sql .= " INNER JOIN app_documentVersions ON app_documents.docID = app_documentVersions.docID
					  WHERE      app_documentVersions.versionID IN ({$list})";
		}
		else
		{
			$sql .= " WHERE app_documents.docID IN ({$list})";
		}
		
		$res =& $dbh->query($sql);
		
		while($row = $res->fetchRow())
		{	
			if($row['accID'] != $accID) return(false);
		}
		
		return(true);
	}
}
?>