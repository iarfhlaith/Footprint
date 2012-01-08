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
	<title>OpenID - [~$user.organisation~] - Footprint</title>
	
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
		$('#openid_url').focus();

		handleMessages();
		handleOpenIDDeletion();
		
		$('#settings5').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('settings5', formVars);
			
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

	<h1 id='headerSettings'>Settings</h1>
	
	[~if $message~][~include file='inc.msg.tpl'~][~/if~]
	
	<div id='jNotice'></div>
	[~ validate id='openid_url'    message=$text.openid_url    append='error' ~]
	[~ validate id='openid_unique' message=$text.openid_unique append='error' ~]
		
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
	
	[~include file='inc.tab.tpl'~]
	
	<div class='settingOptions'>
	
		<h2><img src='/app/media/images/content/openidLogo.gif' alt='OpenID' /></h2>
		
		<p>
			OpenID is a free and easy way to use a single digital identity across the Internet. You can
			use it as an alternative way to login to your account instead of having to remember your
			username and password.
		</p>

		<h3>Attach an OpenID to Your Account</h3>
		
		<form name='settings5' id='settings5' action='/app/settings5.php' method='post'>
		<table class='formTable'>
		<tr>
	 	 <td><label for='openid'>OpenID</label></td>
	 	 <td>
	 	 	<input name='openid_url' id='openid_url' value='' /> <input type='submit' id='innerSubmit' name='submit' value='Attach' />
			<img src='/app/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
			</td>
		</tr>
		</table>
		</form>
		
		[~if $openIDs~]
		
		<h4>The following OpenID's are attached to your account, you can use any of them to sign in.</h4>
		
		<table class='dataListing'>
			<tbody>
			[~ foreach name=openIDs item=openID from=$openIDs ~]
	 		<tr class='[~ cycle values="odd,even" name="rowBackground" ~]' id='openid_[~$smarty.foreach.openIDs.iteration~]'>
				<td>[~$openID~]</td><td class='last'><a href='#' class='delete' id='[~$smarty.foreach.openIDs.iteration~]' rel='[~$openID~]' >Remove</a> &raquo;</td>
			</tr>
			[~/foreach~]
			</tbody>
		</table>
		
		[~/if~]
		
		<div>
			<br /><br /><br />
		</div>
		
	
	</div>
	
</div>

[~include file='inc.end.tpl'~]

</body>
</html>
