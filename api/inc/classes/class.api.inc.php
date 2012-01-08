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

/**
 * Project:     Footprint API - A Programmers Interface to the Footprint Web Application
 * File:        class.api.inc.php
 */

class footprintAPI extends Auth_HTTP
{
   /**
    * Check the Header Information to see if
	* the conditions are good enough to start
	* operating as an API.
	*
	* Otherwise the system will display the usage
	* for the operation in question.
	*
	* Conditions that must be met are:
	*
	* 1.	-  HTTP_Accept 	must be	'application/xml'
	* 2.	-  HTTPS		must be	'on' (disabled for now)
	*
	* @access 	public
	* @param	array	- An associative array of the $_SERVER vars available to the main script
	* @return 	boolean - true or false if the conditions have been met.
	*/
	public function checkConditions($vars)
	{
		/*
		if(!isset($vars['HTTPS']) || $vars['HTTPS'] != 'on')
		{
			return(false);
		}
		*/
		
		if(!isset($vars['HTTP_ACCEPT']) || $vars['HTTP_ACCEPT'] != 'application/xml')
		{
			return(false);
		}
	
		return(true);	
	}
}
?>