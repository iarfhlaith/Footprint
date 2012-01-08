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

require_once ('../lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Notes on Authentication
//
// I need to extend the PEAR Auth HTTP Class so that I can perform authentication 
// based on the username, password AND the account name (eg. 'webstrong').
//
// At the moment, only the username and password is checked. So if a user on a different account
// has the same username and password, it will lead to security holes and unexpected behavour.
//
// This is also true for the authentication process within the API.
//

// Authenticate User
$fp->authenticate('http');

// Fetch Recent Activity
$activity = $fp->loadRecentActivity();

// Assign Variables
$smarty->assign('activity', $activity);

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('feed.tpl');

?>