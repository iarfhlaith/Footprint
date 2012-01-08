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
require_once ('lib/initialise.php');

// Start Footprint
$fp     = new footprint;
$openID = new openid;

// Authenticate User
$fp->authenticate();

// Check ID was submitted in GET
if(!empty($_GET))
{
	if(isset($_GET['id']))
	{
		// Instantiate Class
		$openID->setOpenID($_GET['id']);
		$openID->setAccID($_SESSION['user']['accID']);
		$openID->setUserID($_SESSION['user']['userID']);
		
		// Check User has permission to delete the comment		
		if($openID->isOwner($_GET['id']))
		{
			$openID->detachOpenID();
		}
	}
}
?>