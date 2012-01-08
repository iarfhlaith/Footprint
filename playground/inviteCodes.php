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
 *
 * Generate Invitation Codes 100 at a time.
 * 
 *
 **/

/*
require_once ('../app/lib/initialise.php');

// Force Error Level
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'on');

$dbh   = dbConnection::get()->handle();

for($i=0; $i<100; $i++)
{
	$code = generateInviteCode();
	
	echo ('<br>'.$code);
	
	$sql = "INSERT INTO pro_invitations (code) VALUES ('{$code}')";
	
	$affected =& $dbh->exec($sql);
	if (PEAR::isError($affected)) return(false);
}

function generateInviteCode($length=6)
{
	$pass = '';
	$salt = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
	
	$saltLength = strlen($salt);
	
	mt_srand((double)microtime()*1000000);
	
	for($i = 0; $i < $length; $i++)
	{
		$pass .= $salt[mt_rand(0,$saltLength-1)];
	}
	
	return($pass);
}
*/
?>