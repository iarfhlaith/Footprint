<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        viewLogo.php
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

// Include Settings
require_once ('../lib/initialise.php');

// Default Values
$prefix = '';

// Instantiate User Object
$fp = new footprint;

if(isset($_GET['prefix'])) 
{
	$prefix = cleanValue($_GET['prefix']);
}

// Display Logo
$fp->loadLogo($prefix);

?>