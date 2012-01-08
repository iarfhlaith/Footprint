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
	<title>Settings - [~$user.organisation~] - Footprint</title>
	
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" value="no-cache, no store, must-revalidate">
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/app/css/screen.css" />
	
	<script type="text/javascript" src="/app/jscript/plugins/jQuery.js"></script>
	<script type="text/javascript" src="/app/jscript/lang.js"></script>
	<script type="text/javascript" src="/app/jscript/base.scripts.js"></script>
	<script type="text/javascript" src="/app/jscript/fp.behaviour.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{	
		handleMessages();
	
		$('#submit').click(function ()
		{
			runFormVisualsSync();
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

	<h1 id='headerSettings'>Settings</h1>
	
	[~if $message~][~include file='inc.msg.tpl'~][~/if~]
	
	<div id='jNotice'></div>
			
	[~ validate id='logo' 	  message=$text.logo	 append='error' type=$mimeTypes ~]
	[~ validate id='logoSize' message=$text.logoSize append='error' ~]
	
	[~if $error~]
		<div class='warning'>
		  <ul>
			[~foreach from=$error item="val"~]<li>[~$val~]</li>[~/foreach~]
		  </ul>
		</div>
	[~/if~]
	
	[~include file='inc.tab.tpl'~]
	
	<div class='settingOptions'>
		
		<h2>Upload Your Own Logo</h2>
		
		<form name='settingsLogo' id='settingsLogo' enctype="multipart/form-data" method="post" action="/app/settingsLogo.php">
		
		<table class='formTable'>
		<tr>
		 <td><label for='logo'>Upload Logo</label></td>
		 <td>
		 	<input type='file' size='41' name='logo'>
			<p>Current Logo</p>
		 	<img src='/app/inc/viewLogo.php' />
		</td>
		 <td>
		 	<div class='formTip'>Your logo must be less than 1MB.
		 		<br /><br />It will be resized to 170x60 pixels.
		 		<br /><br />Supported formats: PNG, JPG, GIF.
			</div>
		 </td>
		</tr>
		</table>
		
		<div class='submit'>
			<input type='submit' id='submit' name='submit' value='Save Changes' />
			<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
		</div>
		
		</form>
		
	</div>
	
</div>

[~include file='inc.end.tpl'~]

</body>
</html>