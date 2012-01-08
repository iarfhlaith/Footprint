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

$addLength = strlen($_SERVER["SCRIPT_FILENAME"]) - strlen($_SERVER["SCRIPT_NAME"]);

// Global Constants
define("WEB_ROOT", substr($_SERVER["SCRIPT_FILENAME"], 0, $addLength));
define("APP_ROOT", WEB_ROOT.'/app');
define("PER_PAGE", 15);

define("DB_USERNAME"   , 'DATABASE_USER');
define("DB_PASSWORD"   , 'DATABASE_PASSWORD');
define("DB_HOST"       , 'DATABASE_SERVER_IP');
define("DB_DATABASE"   , 'DATABASE');

define("SESSION_PATH"  , 'PATH_TO_SESSION_DIR');
define("UPLOAD_PATH"   , 'PATH_TO_UPLOADS_DIR');

define("LIVE_SMARTY_PATH"  , "PATH_TO_LIVE_SMARTY_DIR");
define("LIVE_PEAR_PATH"    , "PATH_TO_LIVE_PEAR_DIR");
define("LIVE_OPENID_PATH"  , "PATH_TO_LIVE_OPENID_DIR");
define("LIVE_ACC_ROOT"     , "PATH_TO_LIVE_ACC_ROOT");

define("LOCAL_SMARTY_PATH" , "PATH_TO_LOCAL_SMARTY_DIR");
define("LOCAL_PEAR_PATH"   , "PATH_TO_LOCAL_PEAR_DIR");
define("LOCAL_OPENID_PATH" , "PATH_TO_LOCAL_OPENID_DIR");
define("LOCAL_ACC_ROOT"    , "PATH_TO_LOCAL_ACC_ROOT");

define("IN_BETA"       , TRUE);
define("ENC_KEY"       , 'ENTER_RANDOM_STRING_40_CHARACTERS_LONG');
define("SUPPORT_NAME"  , 'Footprint Support');
define("SUPPORT_EMAIL" , 'support@footprintapp.com');

// Amazon AWS Access Codes
define("AWS_KEY"  , 'YOUR_AWS_KEY');
define("AWS_SEC"  , 'YOUR_AWS_SECRET');

?>