<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        config_sample.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Internet Solutions.
 *
 * This software is protected under Irish CopyRight Law.
 *
 * @link http://www.footprinthq.com/
 * @copyright 2007-2008 Webstrong Internet Solutions
 * @author Iarfhlaith Kelly <ik at webstrong dot net>
 * @package Footprint
 * @version 1.0
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. http://www.footprinthq.com/forums
 *
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

define("LOCAL_SMARTY_PATH" , "PATH_TO_LOCAL_SMARTY_DIR");
define("LOCAL_PEAR_PATH"   , "PATH_TO_LOCAL_PEAR_DIR");
define("LOCAL_OPENID_PATH" , "PATH_TO_LOCAL_OPENID_DIR");

?>