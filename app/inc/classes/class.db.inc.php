<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        class.db.inc.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Internet Solutions.
 *
 * This software is protected under Irish CopyRight Law.
 *
 * @link http://www.footprinthq.com/
 * @copyright 2007-2008 Webstrong Internet Solutions
 * @author Iarfhlaith Kelly <ik at webstrong dot net>
 * @package Footprint
 * @version 1.0
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. http://www.footprinthq.com/forums
 *
 */

class dbConnection
{
	private $_handle = null;

	public static function get()
	{
    	static $db = null;
	
		if ($db == null)
		{
			$db = new dbConnection();
		}
	
    	return $db;
	}

	private function __construct()
	{
		$dsn = array(
		   'phptype' => 'mysql'
		, 'username' => DB_USERNAME
		, 'password' => DB_PASSWORD
		, 'hostspec' => DB_HOST
		, 'database' => DB_DATABASE
	     );

		// Connect to Database
		$this->_handle = MDB2::connect($dsn);

		if (PEAR::isError($this->_handle))
		{
			header('Location: http://'.$_SERVER['SERVER_NAME'].'/app/error.php');
		}

		// Set Default Fetch Mode
		$this->_handle->setFetchMode(MDB2_FETCHMODE_ASSOC);
		
		// Keep Studly Caps Naming Convention
		$this->_handle->setOption('portability',MDB2_PORTABILITY_ALL ^ MDB2_PORTABILITY_FIX_CASE);
	}
  
	public function handle()
	{
		return $this->_handle;
	}
}

?>