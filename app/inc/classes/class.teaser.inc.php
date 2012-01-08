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

class teaser
{
	public function save($vars)
	{
		// Timestamp
		$timestamp = time();
		
		$dbh   = dbConnection::get()->handle();
		
		// Add Client Record
		$sql = "INSERT INTO pro_interested
				 ( firstname
				 , lastname
				 , email
				 , datetime
				 , ip
				 )
				 
				VALUES
				 ('{$vars['firstname']}'
				 ,'{$vars['lastname']}'
				 ,'{$vars['email']}'
				 ,'{$timestamp}'
				 ,'{$_SERVER['REMOTE_ADDR']}'
				 )";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Send Email Confirmation to the Person
		//
		// To Do...
		//
		
		return(true);
	}
}

?>