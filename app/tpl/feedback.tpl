[~*
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
*~]
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Feedback - [~$user.organisation~] - Footprint</title>
	
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" value="no-cache, no store, must-revalidate">
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/app/css/screen.css" />
	
	<script type="text/javascript" src="/app/jscript/plugins/jQuery.js"></script>
	<script type="text/javascript" src="/app/jscript/lang.js"></script>
	<script type="text/javascript" src="/app/jscript/base.scripts.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{
		$('#subject').focus();
		
		$('#feedback').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('feedback', formVars);
			
			return(false);
			
    	});
  	});
	
	</script>
	
	<style type="text/css">
		[~include file='inc.css.tpl'~]
	</style>
	
</head>

<body>
<a name='top'></a>
[~include file='inc.nav.tpl'~]

<div id='content'>

	<h1 id='headerFeedback'>We Love Feedback</h1>
	
	<div id='jNotice'></div>
			
	[~ validate id='subject' 	message=$text.subject   append='error' ~]
	[~ validate id='comments' 	message=$text.comments  append='error' ~]
		
		[~if $error~]
			<div class='warning'>
			[~if $error.message~]
				<h3>$error.message</h3>
			[~/if~]
			  <ul>
				[~foreach from=$error item="val"~]<li>[~$val~]</li>[~/foreach~]
			  </ul>
			</div>
		[~/if~]
		
		<form name='feedback' id='feedback' action='/app/feedback.php' method='post'>
		<input type='hidden' name='referrer' value='[~$referrer~]' />
		<table class='formTable'>
		<tr>
		 <td><label for='subject'>Subject</label></td>
		 <td><input name='subject' value='[~$subject~]' id='subject' /> <span class='required'>*</span></td>
		 <td><div class='formTip'>Please enter a subject title for your feedback.</div></td>
		</tr>
		<tr>
		 <td colspan='2'>
			<label for='comments' class='textarea'>Comments <span class='required'>*</span></label>
			<textarea name='comments'>[~$comments~]</textarea>
		 </td>
		 <td><div class='formTip'>Please give as much information as possible. It'll help us fix the issue faster.</div></td>
		</tr>
		</table>
		
		<div class='submit'>
			<input type='submit' id='submit' name='submit' value='Send Feedback' />
			<img src='/app/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
		</div>
		
		<div class='smallPrint'>
			Fields marked with a <strong>*</strong> are required.
		</div>
		
		</form>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
