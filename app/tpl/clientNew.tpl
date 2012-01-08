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
	<title>New Client - [~$user.organisation~] - Footprint</title>
	
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
		$('#organisation').focus();
		
		$('#clientNew').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('clientNew', formVars);
			
			return(false);
			
    	});
		
		matchFields('email', 'username');
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
	
	<h1 id='headerClient'>New Client</h1>
	
	<div id='jNotice'></div>
			
	[~ validate id='name'  		message=$text.name       append='error' ~]
	[~ validate id='email' 		message=$text.email      append='error' ~]
	[~ validate id='password' 	message=$text.password   append='error' ~]
	[~ validate id='userValid' 	message=$text.userValid  append='error' ~]
	[~ validate id='userUnique' message=$text.userUnique append='error' ~]
	
	[~if $error~]
		<div class='warning'>
		  <ul>
			[~foreach from=$error item="val"~]<li>[~$val~]</li>[~/foreach~]
		  </ul>
		</div>
	[~/if~]
	
	<form name='clientNew' id='clientNew' action='/app/clientNew.php' method='post'>
	<table class='formTable'>
	<tr>
	 <td><label for='organisation'>Organisation</label></td>
	 <td colspan='2'><input name='organisation' value='[~$organisation~]' id='organisation' /> <span class='subtle'>(optional)</span></td>
	</tr>
	<tr>
	 <td><label for='name'>Contact Name</label></td>
	 <td colspan='2'><input name='name' value='[~$name~]' /> <span class='required'>*</span></td>
	</tr>
	<tr>
	 <td><label for='email'>Contact Email</label></td>
	 <td colspan='2'><input name='email' value='[~$email~]' id='email' /> <span class='required'>*</span></td>
	</tr>
	<tr>
	 <td><label for='username'>Username</label></td>
	 <td><input name='username' value='[~$username~]' class='minor' id='username' /> <span class='required'>*</span></td>
	 <td><div class='formTip'>Must be at least 5 chars long. Accepted chars: A-Z, 0-9, the underscore and no spaces.</div></td>
	</tr>
	<tr>
	 <td><label for='password'>Password</label></td>
	 <td><input type='password' name='password' value='' class='minor' /></td>
	 <td><div class='formTip'>Min 5 characters. If no password is provided, it will be generated randomly.</div></td>
	</tr>
	<tr>
	 <td><label for='invite' class='checkbox'>Send Invitation</label></td>
	 <td colspan='2'>
	 	<input type='checkbox' class='checkbox' name='invite' value='yes' checked='checked' />
		<span class='smallPrint'>This will send the person's username and password to them by email.</span>
		</td>
	</tr>
	</table>
	
	<div class='submit'>
		<input type='submit' id='submit' name='submit' value='Save Client' />
		<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
		or <a href='/app/clients.php'>cancel</a>
	</div>
	
	<div class='smallPrint'>
		Fields marked with a <strong>*</strong> are required.
	</div>
	
	</form>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
