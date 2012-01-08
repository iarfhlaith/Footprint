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

// Define API Root
define("API_ROOT", WEB_ROOT.'/api');

// Use HTTP Authentication
require_once('Auth/HTTP.php');

// Extend the HTTP Authentication
require_once(API_ROOT.'/inc/classes/class.api.inc.php');

// Reset Smarty Variables for API folder
$smarty->template_dir = WEB_ROOT.'/api/tpl';
$smarty->compile_dir  = WEB_ROOT.'/api/tpl_c';

$options = array('dsn'	=> 'mysql://footpr1_user:lamenux@84.51.233.254/footpr1_db'
		,       'table'	=> 'app_users'
		, 'usernamecol'	=> 'username'
		, 'passwordcol'	=> 'password'
		,   'cryptType'	=> 'md5'
		,   'db_fields' => '*');

$api = new footprintAPI('MDB2', $options);

$api->setRealm('Footprint');

?>