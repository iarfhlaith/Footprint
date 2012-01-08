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
	<title>Edit Comment - [~$user.organisation~] - Footprint</title>
	
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
		$('#comment').focus();
		
		$('#commentEdit').submit(function ()
		{	
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('commentEdit', formVars, 'id=[~$sourceid~]');
			
			return(false);
			
    	});
  	});
	
	</script>
	
	<style type="text/css">
		[~include file='inc.css.tpl'~]
	</style>
	
</head>

<body>

[~include file='inc.nav.tpl'~]

<div id='content'>

	<h1 id='headerComment'>Edit Comment</h1>
	
	<div id='jNotice'></div>
			
	[~ validate id='comment' message=$text.comment append='error' ~]
	[~ validate id='author'  message=$text.author  append='error' ~]
	
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
	
	<form name='commentEdit' id='commentEdit' action='/app/commentEdit.php' method='post'>
	<input name='id' value='[~$comment.id~]' type='hidden' />
	<input name='source' value='[~$source~]' type='hidden' />
	<input name='sourceid' value='[~$sourceid~]' type='hidden' />
	<table class='formTable'>
	<tr>
	 <td>
	 	<label for='description' class='textarea'>Comment <span class='required'>*</span></label>
		<textarea name='comment'>[~$comment.comment~]</textarea>
	 </td>
	</tr>
	</table>
	
	<div class='submit'>
		<input type='submit' id='submit' name='submit' value='Save Changes' />
		<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
		<p><a href='[~$source~]?id=[~$sourceid~]'>Cancel</a></p>
	</div>
	
	<div class='smallPrint'>
		Fields marked with a <strong>*</strong> are required.
	</div>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
