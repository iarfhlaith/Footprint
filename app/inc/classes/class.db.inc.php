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