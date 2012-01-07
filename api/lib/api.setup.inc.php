<?php
/**
 * Project:     Footprint API - A Programmers Interface to the Footprint Web Application
 * File:        api.setup.inc.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Ltd.
 *
 * This software is protected under Irish Copyright Law.
 *
 * @link http://www.footprintapp.com/
 * @copyright 2007-2009 Webstrong Ltd
 * @author Iarfhlaith Kelly <ik at webstrong dot ie>
 * @package Footprint
 * @version 1.0
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. http://www.footprintapp.com/forums
 *
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