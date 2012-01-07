<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        index.php
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

require_once ('../lib/initialise.php');

//For the Menu
$smarty->assign('page'       , array('home' => true));

// Trim the Whitespace
$smarty->load_filter('output','trimwhitespace');

// Display in Template
$smarty->display('home.tpl');
 
?>