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
class screenshot
{
   /**
    * The ssID (screenshotID) of the selected document
    *
    * @var 	public object
    */
	private $ssID;
	
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
    * Sets the ssID
    *
	* @access 	public
	* @return 	void
    */
	public  function select($id)
	{
		$this->ssID = $id;
	}
	
   /**
    * Gets the ssID
    *
	* @access 	public
	* @return 	integer - The ScreenshotID of the selected image
    */
	public  function getSsID()
	{
		return($this->ssID);
	}
	
   /**
    * Load the details for the selected Screenshot
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.footprint.inc.php
	*
	* @access 	public
	* @param	integer	- $clientID		- Filter the results based on the clientID provided.
	* @param	boolean - $assignedOnly - A marker to filter all but the docs that are attached to an assigned project.
	* @return 	array 	- The details of the selected screenshot (including a list of previous versions)
	*/
	public function loadScreenshot($clientID='', $assignedOnly=false, $loadVersions=true)
	{
		$ssID  = $this->getSsID();
		$accID = $this->getAccID();

		$dbh   = dbConnection::get()->handle();
		
		$sql   = "SELECT   app_screenshots.title
						 , app_screenshots.docType
						 , app_screenshots.mime
						 , app_screenshots.description
						 , app_screenshots.screenshotID
						 , app_screenshots.clientAccess
						 , MAX(app_screenshotVersions.`version`) AS version
						 , MAX(app_screenshotVersions.id)        AS versionID
						 , app_screenshotVersions.dimensions
						 , app_screenshotVersions.size
						 , app_screenshotVersions.dateCreated
						 , app_tasks.taskID
						 , app_tasks.title 		AS task
						 , app_projects.projID
						 , app_projects.name 	AS project
						 , app_users.userID 	AS clientID
						 , app_users.clientOrganisation
							
				  FROM app_screenshots
									
					INNER JOIN app_tasks     		  ON app_screenshots.taskID 	  = app_tasks.taskID
					INNER JOIN app_projects  		  ON app_tasks.projID       	  = app_projects.projID
					INNER JOIN app_users			  ON app_projects.clientID		  = app_users.userID
					INNER JOIN app_screenshotVersions ON app_screenshots.screenshotID = app_screenshotVersions.screenshotID";
		
		if($assignedOnly)
		{
			$sql .= " INNER JOIN app_staffProjects ON app_projects.projID = app_staffProjects.projectID";
		}
		
		$sql  .= " WHERE app_screenshots.screenshotID = '{$ssID}'";
		
		if(is_numeric($clientID))
		{
			$sql .= " AND app_projects.clientID = '{$clientID}'";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $sql.= " AND app_projects.visibility = '1'";
		}

		$sql  .= " GROUP BY app_screenshotVersions.screenshotID";
		
		$result     =& $dbh->query($sql);
		$screenshot = $result->fetchRow();
		
		// Load Versions
		if($loadVersions)
		{
			array_push_associative($screenshot, array('versions' => $this->loadVersions()));
		}
		
		// Load Comments & Direct Links
		if(isset($screenshot['screenshotID']))
		{
			$this->comments = new comment;
			$this->comments->setType('screenshot');
			$this->comments->setParent($screenshot['screenshotID']);
			
			array_push_associative($screenshot, array('comments' => $this->comments->loadAll()));
		
			// Initialise Query String Data
			require_once('Crypt/HMAC.php');
			require_once('HTTP/Request.php');
		
			$s3     = new s3();
			$bucket = 'screenshots.footprinthq.com';
		
			// Calculate Querystring for S3 Access
			$key   = $screenshot['versionID'].'b';
			$auth  = $s3->qStrAuthentication($bucket, $key,  320); // valid for 5 mins
			
			array_push_associative($screenshot, array('auth' => $auth, 'key' => $key));
		}
		
		return($screenshot);
	}

   /**
	* Load Screenshot Information (not the actual screenshot)
	* based on the versionID provided.
	*
	* Dependant on: class.db.inc.php
	*
	* @access	public
	* @param	integer - $versionID	- The unique id of the actual data (stored in Amazon's S3 service)
	* @param	char	- $size			- The required size of the screenshot (options are: a,b,c,d)
	* @param	integer	- $clientID		- Filter the results based on the clientID provided.
	* @param	boolean - $assignedOnly - A marker to filter all but the screenshots that are attached to an assigned project.
	* @return 	array 	- The details of the selected screenshot (including a list of previous versions)	
	*/
	public function loadScreenshotFromVersionID($versionID, $size='d', $clientID='', $assignedOnly=false)
	{
		$accID = $this->getAccID();
		
		$dbh   = dbConnection::get()->handle();
		
		// Ensure Size was a valid option
		if($size != 'a' && $size != 'b' && $size != 'c' && $size != 'd')
		{
			$size = 'd';
		}
		
		$sql = "SELECT app_screenshots.screenshotID
					 , app_screenshots.title
					 , app_screenshots.mime
					 , app_screenshots.docType
		
				FROM app_screenshots
				
				INNER JOIN app_screenshotVersions ON app_screenshots.screenshotID  = app_screenshotVersions.screenshotID
				INNER JOIN app_tasks              ON app_screenshots.taskID        = app_tasks.taskID
				INNER JOIN app_projects           ON app_tasks.projID              = app_projects.projID";
		
		if($assignedOnly)
		{
			$sql .= " INNER JOIN app_staffProjects ON app_projects.projID = app_staffProjects.projectID";
		}
		
		$sql .= " WHERE app_screenshotVersions.id = '{$versionID}'";
		
		if(is_numeric($clientID))
		{
			$sql .= " AND app_projects.clientID = '{$clientID}'";
			
			// Filter by Client Access if a Client is Logged In
			if($_SESSION['user']['groupID'] == '3') $sql .= " AND app_projects.visibility = '1'";
		}
		
		$result     =& $dbh->query($sql);
		$screenshot = $result->fetchRow();
		
		if(isset($screenshot['screenshotID']))
		{
			array_push_associative($screenshot, array('data' => $this->loadS3Object($versionID.$size)));
			
			// Initialise Query String Data
			require_once('Crypt/HMAC.php');
			require_once('HTTP/Request.php');
		
			$s3     = new s3();
			$bucket = 'screenshots.footprinthq.com';
		
			// Calculate Querystring for S3 Access
			$key   = $versionID.'a';
			$auth  = $s3->qStrAuthentication($bucket, $key,  320); // valid for 5 mins
			
			array_push_associative($screenshot, array('auth' => $auth, 'key' => $key));
		}
		
		return($screenshot);
	}

   /**
    * Load a list of all the screenshot's versions for the selected screenshot.
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.footprint.inc.php
	*
	* @access 	private
	* @return 	array 	- An associative array with information about the screenshots's previous versions
	*/
	private function loadVersions()
	{
		$ssID  = $this->getSsID();
		$accID = $this->getAccID();
		
		$versions = array();
		
		$dbh   = dbConnection::get()->handle();
		
		$sql   = "SELECT  app_screenshotVersions.id
						, app_screenshotVersions.dateCreated
						, app_screenshotVersions.dimensions
						, app_screenshotVersions.version
						, app_screenshotVersions.size
						, app_screenshotVersions.author
						, app_users.firstname
						, app_users.lastname
					
					FROM app_screenshotVersions
					
					INNER JOIN app_users ON app_screenshotVersions.author 			  = app_users.userID
					
					INNER JOIN app_screenshots ON app_screenshotVersions.screenshotID = app_screenshots.screenshotID
					INNER JOIN app_tasks       ON app_screenshots.taskID 			  = app_tasks.taskID
					INNER JOIN app_projects    ON app_tasks.projID     				  = app_projects.projID
				  
				  WHERE app_screenshotVersions.screenshotID = '{$ssID}'
				    AND app_projects.accID = '{$accID}'
				  
				  ORDER BY app_screenshotVersions.id DESC";
		
		$result =& $dbh->query($sql);
		
		// Initialise Query String Data
		require_once('Crypt/HMAC.php');
		require_once('HTTP/Request.php');

		$s3     = new s3();
		$bucket = 'screenshots.footprinthq.com';
		
		while($row = $result->fetchRow())
		{
			// Calculate Querystring for S3 Access
			$key  = $row['id'].'c';
			$auth = $s3->qStrAuthentication($bucket, $key, 320); // valid for 5 mins
			array_push_associative($row, array('auth' => $auth, 'key' => $key));
		
			array_push($versions, $row);
		}
		
		return($versions);
	}
	
   /**
	* Load the S3 Object using the S3 PHP class and REST interface
	*
	* All Footprint screenshot objects are stored in S3's screenshots.footprinthq.com bucket.
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
		
		$s3     = new s3();
		$bucket = 'screenshots.footprinthq.com';

		$data   = $s3->getObject($id , $bucket);
		$info   = $s3->getObjectInfo($id, $bucket);
		
		return(array('info' => $info, 'contents' => $data));
	}
	
   /**
	* Save the Screenshot metadata into Database
	*
	* All Footprint screenshot objects are stored in S3's screenshots.footprinthq.com bucket.
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
		$handleA = new upload($file);
		$handleB = new upload($file);
		$handleC = new upload($file);
		$handleD = new upload($file);
		
		// Process Original Image
		$fileMime['a'] = $handleA->file_src_mime;
		$fileSize['a'] = $handleA->file_src_size;
		$fileExtn['a'] = $handleA->file_src_name_ext;
		$fileData['a'] = $handleA->Process();
		
		// Generate 1st Thumbnail
		$handleB->image_resize   = true;
		$handleB->image_x        = 300;
		$handleB->image_ratio_y  = true;
		$fileMime['b'] = $handleB->file_src_mime;
		$fileData['b'] = $handleB->Process();
		
		// Generate 2nd Thumbnail
		$handleC->image_resize   = true;
		$handleC->image_x        = 100;
		$handleC->image_ratio_y  = true;
		$fileMime['c'] = $handleC->file_src_mime;
		$fileData['c'] = $handleC->Process();
		
		// Generate 3rd Thumbnail
		$handleD->image_resize   = true;
		$handleD->image_x        = 50;
		$handleD->image_ratio_y  = true;
		$fileMime['d'] = $handleD->file_src_mime;
		$fileData['d'] = $handleD->Process();
		
		// Load Original Image Dimensions
		$dimensions = $handleA->image_src_x.' x '.$handleA->image_src_y;
		
		// Insert Document Metadata
		$sql = "INSERT INTO app_screenshots
				 ( taskID
				 , title
				 , docType
				 , mime
				 , dateCreated
				 , author
				 , clientAccess)
				 
				VALUES
				 ('{$vars['task']}'
				 ,'{$vars['name']}'
				 ,'{$fileExtn['a']}'
				 ,'{$fileMime['a']}'
				 ,'{$date}'
				 ,'{$_SESSION['user']['userID']}'
				 ,'{$vars['access']}')";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch DocumentID
		$imgID = $dbh->lastInsertID('app_screenshots', 'screenshotID');
		
		// Insert Screenshot Version Metadata
		$sql = "INSERT INTO app_screenshotVersions
				 ( screenshotID
				 , size
				 , dimensions
				 , dateCreated
				 , version
				 , author)
				 
				VALUES
				 ('{$imgID}'
				 ,'{$fileSize['a']}'
				 ,'{$dimensions}'
				 ,'{$date}'
				 ,'1'
				 ,'{$_SESSION['user']['userID']}')";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch VersionID
		$verID = $dbh->lastInsertID('app_screenshotVersions', 'id');
		
		// Transfer file to S3
		if(!$this->uploadS3Object($verID.'a', $fileData['a'], $fileMime['a'])) $imgID = false;
		if(!$this->uploadS3Object($verID.'b', $fileData['b'], $fileMime['b'])) $imgID = false;
		if(!$this->uploadS3Object($verID.'c', $fileData['c'], $fileMime['c'])) $imgID = false;
		if(!$this->uploadS3Object($verID.'d', $fileData['d'], $fileMime['d'])) $imgID = false;

		return($imgID);
	}
	
   /**
	* Update the selected Screenshot
	*
	* All Footprint screenshot objects are stored in S3's screenshots.footprinthq.com bucket.
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
		$handleA = new upload($file);
		$handleB = new upload($file);
		$handleC = new upload($file);
		$handleD = new upload($file);
		
		// Process Original Image
		$fileMime['a'] = $handleA->file_src_mime;
		$fileSize['a'] = $handleA->file_src_size;
		$fileExtn['a'] = $handleA->file_src_name_ext;
		$fileData['a'] = $handleA->Process();
		
		$nextVersion = $vars['version'] + 1;
		
		// Load Original Image Dimensions
		$dimensions = $handleA->image_src_x.' x '.$handleA->image_src_y;
		
		// Update Screenshot Metadata
		$sql = "UPDATE app_screenshots SET mime = '{$fileMime['a']}'
							     , clientAccess = '{$vars['access']}'
							     ,  dateCreated = '{$date}'
							     ,      docType = '{$fileExtn['a']}'";
		
		if(!empty($vars['name'])) $sql .= ", title = '{$vars['name']}'";
		
		$sql .= " WHERE screenshotID = '{$vars['id']}'";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Insert Screenshot Version Metadata
		$sql = "INSERT INTO app_screenshotVersions
				 ( screenshotID
				 , size
				 , dimensions
				 , dateCreated
				 , version
				 , author)
				 
				VALUES
				 ('{$vars['id']}'
				 ,'{$fileSize['a']}'
				 ,'{$dimensions}'
				 ,'{$date}'
				 ,'{$nextVersion}'
				 ,'{$_SESSION['user']['userID']}')";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch VersionID
		$verID = $dbh->lastInsertID('app_screenshotVersions', 'id');
		
		// Generate 1st Thumbnail
		$handleB->image_resize   = true;
		$handleB->image_x        = 300;
		$handleB->image_ratio_y  = true;
		$fileMime['b'] = $handleB->file_src_mime;
		$fileData['b'] = $handleB->Process();
		
		// Generate 2nd Thumbnail
		$handleC->image_resize   = true;
		$handleC->image_x        = 100;
		$handleC->image_ratio_y  = true;
		$fileMime['c'] = $handleC->file_src_mime;
		$fileData['c'] = $handleC->Process();
		
		// Generate 3rd Thumbnail
		$handleD->image_resize   = true;
		$handleD->image_x        = 50;
		$handleD->image_ratio_y  = true;
		$fileMime['d'] = $handleD->file_src_mime;
		$fileData['d'] = $handleD->Process();

		// Transfer file to S3
		if(!$this->uploadS3Object($verID.'a', $fileData['a'], $fileMime['a'])) return(false);
		if(!$this->uploadS3Object($verID.'b', $fileData['b'], $fileMime['b'])) return(false);
		if(!$this->uploadS3Object($verID.'c', $fileData['c'], $fileMime['c'])) return(false);
		if(!$this->uploadS3Object($verID.'d', $fileData['d'], $fileMime['d'])) return(false);

		return($vars['id']);
	}

   /**
	* Upload the S3 Object using the S3 PHP class and REST interface
	*
	* All Footprint screenshot objects are stored in S3's screenshots.footprinthq.com bucket.
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
		$bucket = 'screenshots.footprinthq.com';
		
		$result = $s3->putObject($id, $data, $bucket, 'private', $mime);
		
		return($result);
	}
	
   /**
    * Delete selected screenshot(s)
	*
	* Dependant on: class.db.inc.php
	* Dependant on: class.s3.inc.php
	*
	* @access 	public
	* @param	array   - $list	- An array of the screenshotID's to be deleted
	* @param	boolean - $checkClientAccess - if true, the screenshot metadata will be checked to see if the client has permission to delete the file(s).
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
		
		$sql = "DELETE FROM app_screenshots			WHERE screenshotID	IN ({$sel})";
		$affected = $dbh->exec($sql);
		
		$sql = "DELETE FROM app_comments 			WHERE parentID 		IN ({$sel}) AND parentType = 'screenshot'";
		$dbh->exec($sql);
		
		$sql = "DELETE FROM app_screenshotVersions 	WHERE screenshotID	IN ({$sel})";
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
    * Check if the client is permitted to access ALL of the submitted screenshotIDs
    * 
    * If any of the screenshotIDs that were passed in fail the test then the whole function
    * will return false.
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	private
	* @param	array	- $list An array of the screenshotID's
	* @return 	boolean	- true if the user has permission to access all of the selected screenshots.
	*/
	private function clientHasAccess($list)
	{
		$dbh = dbConnection::get()->handle();
		
		if(is_array($list))
		{
			$list = arrayToList($list, 'index');
		}
		
		$sql = "SELECT clientAccess FROM app_screenshots WHERE screenshotID IN ({$list})";	
		$res =& $dbh->query($sql);
		
		while($row = $res->fetchRow())
		{
			if($row['clientAccess'] < 2) return(false);
		}
		
		return(true);
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
    * Security measure to check if all the selected screenshots belong to the specified account
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @param	array	- $list    An array of the screenshotID's to be checked
	* @param	integer	- $accID   The accountID
	* @param	boolean	- $version Optional setting that makes the check be run on the versionID as opposed to the screenshotID, which is done by default
	* @return 	boolean	- true if all the screenshots belong to the specified account.
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

				INNER JOIN app_tasks       ON app_projects.projID = app_tasks.projID
				INNER JOIN app_screenshots ON app_tasks.taskID    = app_screenshots.taskID";
		
		if($version)
		{
			$sql .= " INNER JOIN app_screenshotVersions ON app_screenshots.screenshotID = app_screenshotVersions.screenshotID
					  WHERE app_screenshotVersions.id   IN ({$list})";
		}
		else
		{
			$sql .= " WHERE app_screenshots.screenshotID IN ({$list})";
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