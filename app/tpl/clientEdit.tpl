<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Edit Client - [~$user.organisation~] - Footprint</title>
	
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
		
		$('#clientEdit').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('clientEdit', formVars);
			
			return(false);
			
    	});
		
		$('#newPass1, #newPass2').val('');
  	});
	
	</script>
	
	<style type="text/css">
		[~include file='inc.css.tpl'~]
	</style>
	
</head>

<body>

[~include file='inc.nav.tpl'~]

<div id='content'>
	
	<h1 id='headerClient'>Edit Client</h1>
	
	<div id='jNotice'></div>
			
	[~ validate id='name'  		message=$text.name       append='error' ~]
	[~ validate id='email' 		message=$text.email      append='error' ~]
	[~ validate id='passWeak' 	message=$text.passWeak   append='error' ~]
	[~ validate id='passDiff' 	message=$text.passDiff   append='error' ~]
	[~ validate id='userValid' 	message=$text.userValid  append='error' ~]
	[~ validate id='userUnique' message=$text.userUnique append='error' ~]
	
	[~if $error~]
		<div class='warning'>
		  <ul>
			[~foreach from=$error item="val"~]<li>[~$val~]</li>[~/foreach~]
		  </ul>
		</div>
	[~/if~]
	
	<form name='clientEdit' id='clientEdit' action='/app/clientEdit.php' method='post'>
	<input name='id' value='[~$client.userID~]' type='hidden' />
	<table class='formTable'>
	<tr>
	 <td><label for='organisation'>Organisation</label></td>
	 <td colspan='2'><input name='organisation' value='[~$client.organisation~]' id='organisation' /> <span class='subtle'>(optional)</span></td>
	</tr>
	<tr>
	 <td><label for='name'>Contact Name</label></td>
	 <td colspan='2'><input name='name' value='[~$client.name~]' /> <span class='required'>*</span></td>
	</tr>
	<tr>
	 <td><label for='email'>Contact Email</label></td>
	 <td colspan='2'><input name='email' value='[~$client.email~]' /> <span class='required'>*</span></td>
	</tr>
	<tr>
	 <td><label for='username'>Username</label></td>
	 <td><input name='username' value='[~$client.username~]' class='minor' /> <span class='required'>*</span></td>
	 <td><div class='formTip'>Must be unique and at least 5 chars long. Accepted chars: A-Z, 0-9, the underscore and no spaces.</div></td>
	</tr>
	<tr>
	 <td><label for='newPass1'>New Password</label></td>
	 <td><input type='password' name='newPass1' id='newPass1' value='' class='minor' /></td>
	 <td><div class='formTip'>Must be 5 characters or more. If left blank, the password will not be changed.</div></td>
	</tr>
	<tr>
	<tr>
	 <td><label for='password'>Confirm Password</label></td>
	 <td colspan='2'><input name='newPass2' id='newPass2' type='password' value='' /></td>
	</tr>
	<tr>
	 <td><label for='invite'>Invitation Status</label></td>
	 <td colspan='2'>
	 	<span class='highlight'>[~if $client.invited~]Sent[~else~]Not Sent[~/if~].</span>
		<input type='checkbox' class='checkbox' name='invite' id='invite' value='yes' />
		<span class='smallPrint'>Send invitation [~if $client.invited~] again[~else~] for the first time[~/if~]</span>
	 </td>
	</tr>
	</table>
	
	<div class='submit'>
		<input type='submit' id='submit' name='submit' value='Save Changes' />
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
