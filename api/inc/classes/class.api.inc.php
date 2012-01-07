<?php
/**
 * Project:     Footprint API - A Programmers Interface to the Footprint Web Application
 * File:        class.api.inc.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Ltd.
 *
 * This software is protected under Irish Copyright Law.
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. @link http://www.footprintapp.com/forums
 *
 * @link 		http://www.footprinthapp.com/
 * @copyright 	2007-2009 Webstrong Ltd
 * @author 		Iarfhlaith Kelly <ik at webstrong dot ie>
 * @package 	Footprint API
 * @version 	1.0
 */

/**
 * @package Footprint API
 *
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