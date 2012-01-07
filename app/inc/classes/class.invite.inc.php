<?php
/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        class.project.inc.php
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
class invite
{
	public function process($code, $accID)
	{
		$dbh = dbConnection::get()->handle();
		
		// Mark Code as Used
		$sql = "UPDATE pro_invitations SET usedBy = '{$accID}' WHERE code = '{$code}'";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		return(true);
	}
}