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

// Include Config file
require_once('config.php');

if (preg_match("/footprintapp.com/i", $_SERVER['SERVER_NAME']))
{	
	// Set Paths to Key Libraries
	$smartyPath = LIVE_SMARTY_PATH;
	$pearPath   = LIVE_PEAR_PATH;
	$openidPath = LIVE_OPENID_PATH;
	
	define("ACC_ROOT", LIVE_ACC_ROOT);
}
else
{
	// Set Paths to Key Libraries
	$smartyPath = LOCAL_SMARTY_PATH;
	$pearPath   = LOCAL_PEAR_PATH;
	$openidPath = LOCAL_OPENID_PATH;
	
	define("ACC_ROOT", LOCAL_ACC_ROOT);
	
	// Force Error Level
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 'on');
}

// Config php.ini Commands
ini_set('session.use_trans_sid'	, false);
ini_set('session.save_path'		, WEB_ROOT.SESSION_PATH);
ini_set("upload_tmp_dir"		, WEB_ROOT.UPLOAD_PATH);
ini_set('include_path'			, '.' . PATH_SEPARATOR . $pearPath
							  		  . PATH_SEPARATOR . $smartyPath
							  		  . PATH_SEPARATOR . $openidPath);

// Get Subdomain / Account Name
list($accName) = explode(".",$_SERVER['SERVER_NAME']); 
if($accName == 'footprintapp') $accName = '';
				  
// Start The Session
session_set_cookie_params(86400, '/', $_SERVER['SERVER_NAME']);
session_name('SESSION_'.$accName);
session_start();

// Include PEAR MDB2
require_once('MDB2.php');

// Smarty Template Engine
require_once('Smarty.class.php');
require_once('SmartyPaginate.class.php');
require_once('SmartyValidate.class.php');
$smarty = new Smarty;

// Set Smarty Variables
$smarty->config_dir   = APP_ROOT.'/lib';
$smarty->template_dir = APP_ROOT.'/tpl';
$smarty->compile_dir  = APP_ROOT.'/tpl_c';

// Assign Info if User is Logged into System
if(isset($_SESSION['user']))
{
	$smarty->assign('user'   , $_SESSION['user']);
	$smarty->assign('IN_BETA', IN_BETA);
	
	// Set Server Timezone
	if(isset($_SESSION['user']['timezone']))
		putenv("TZ=".$_SESSION['user']['timezone']);
}

// Include Class Files
require_once (APP_ROOT.'/inc/classes/class.db.inc.php');
require_once (APP_ROOT.'/inc/classes/class.footprint.inc.php');
require_once (APP_ROOT.'/inc/classes/class.staff.inc.php');
require_once (APP_ROOT.'/inc/classes/class.client.inc.php');
require_once (APP_ROOT.'/inc/classes/class.project.inc.php');
require_once (APP_ROOT.'/inc/classes/class.request.inc.php');
require_once (APP_ROOT.'/inc/classes/class.task.inc.php');
require_once (APP_ROOT.'/inc/classes/class.comment.inc.php');
require_once (APP_ROOT.'/inc/classes/class.document.inc.php');
require_once (APP_ROOT.'/inc/classes/class.screenshot.inc.php');
require_once (APP_ROOT.'/inc/classes/class.openid.inc.php');
require_once (APP_ROOT.'/inc/classes/class.validator.inc.php');
require_once (APP_ROOT.'/inc/classes/class.feedback.inc.php');
require_once (APP_ROOT.'/inc/classes/class.invite.inc.php');

// Include Helper Files
require_once (APP_ROOT.'/inc/helpers/help.arrays.inc.php');

// Include Language Files
require_once (APP_ROOT.'/inc/config/english.php');

// Include Plugin Files
require_once (APP_ROOT.'/inc/plugins/amazon/class.s3.inc.php');
require_once (APP_ROOT.'/inc/plugins/mailer/class.mailer.inc.php');
require_once (APP_ROOT.'/inc/plugins/upload/class.upload.inc.php');
require_once (APP_ROOT.'/inc/plugins/encrypt/class.crypt.inc.php');
?>