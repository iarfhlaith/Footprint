<?php

/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        help.arrays.inc.php
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

/////////////////////////////////////////////////////////////////////////////////////////////////////
function printArray($array)
{
	if (empty($array))
		return false;

	echo '<pre>';
	print_r($array);
	echo '</pre>';
	
	return true;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////
function array_push_associative(&$arr)
{
   $args = func_get_args();
   $ret  = 0;
   foreach ($args as $arg) {
       if (is_array($arg)) {
           foreach ($arg as $key => $value) {
               $arr[$key] = $value;
               $ret++;
           }
       }else{
           $arr[$arg] = "";
       }
   }
   return $ret;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////
function cleanValue($val)
{
	if ($val == "")
	{
		return $val;
	}
	
	/*
     * Sanitize input to prevent against XSS and other nasty stuff.
     * Taken from cakephp (http://cakephp.org)
     * Licensed under the MIT License
    */
	
	//Replace odd spaces with safe ones
	$val = str_replace(" ", " ", $val);
	$val = str_replace(chr(0xCA), "", $val);
	//Encode any HTML to entities (including \n --> <br />)
	$val = cleanHtml($val);
	//Double-check special chars and remove carriage returns
	//For increased SQL security
	$val = preg_replace("/\\\$/", "$", $val);
	$val = preg_replace("/\r/", "", $val);
	$val = str_replace("!", "!", $val);
	$val = str_replace("'", "'", $val);
	//Allow unicode (?)
	$val = preg_replace("/&amp;#([0-9]+);/s", "&#\\1;", $val);
	//Add slashes for SQL
	//$val = $this->sql($val);
	//Swap user-inputted backslashes (?)
	$val = preg_replace("/\\\(?!&amp;#|\?#)/", "\\", $val);
	return $val;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////
function cleanHtml($string, $remove = false)
{
	/*
     * Method to sanitize incoming html.
     * Taken from cakephp (http://cakephp.org)
     * Licensed under the MIT License
    */

	if ($remove)
	{
		$string = strip_tags($string);
	}
	else
	{
		$patterns = array("/\&/", "/%/", "/</", "/>/", '/"/', "/'/", "/\(/", "/\)/", "/\+/", "/-/");
		$replacements = array("&amp;", "&#37;", "&lt;", "&gt;", "&quot;", "&#39;", "&#40;", "&#41;", "&#43;", "&#45;");
		$string = preg_replace($patterns, $replacements, $string);
	}
	return $string;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////
function extractNames($fullName, $whichName)
{
	$gap = stripos($fullName, ' ');
	
	if($whichName == 'firstname')
	{
		if(!is_numeric($gap)) return($fullName);
		
		return(substr($fullName, 0, $gap));
	}
	elseif($whichName == 'lastname')
	{
		if(!is_numeric($gap)) return('');
		
		$lastLength = strlen($fullName) - $gap;
		return(substr($fullName, $gap+1, $lastLength));
	}
}


/////////////////////////////////////////////////////////////////////////////////////////////////////
function arrayToList($array, $phase = 'value')
{
	$list = '';
	
	foreach($array as $index => $value)
	{
		$list .= $$phase.',';
	}
	
	$list .= '0';
	
	return($list);
}


/////////////////////////////////////////////////////////////////////////////////////////////////////

?>