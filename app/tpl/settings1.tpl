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
	
		$('#organisation').focus();
		
		$('#settings1').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('settings1', formVars);
			
			return(false);
    	});
		
		$('#password, #confirm').val('');
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
			
	[~ validate id='name'  		message=$text.name       append='error' ~]
	[~ validate id='email' 		message=$text.email      append='error' ~]
	[~ validate id='confirm' 	message=$text.confirm    append='error' ~]
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
	
	[~include file='inc.tab.tpl'~]
	
	<div class='settingOptions'>
	
		<form name='settings1' id='settings1' action='/app/settings1.php' method='post'>
		<table class='formTable mini'>
		
		[~if $user.groupName != 'Staff'~]
		<tr>
	 	 <td><label for='organisation'>Organisation</label></td>
	 	 <td colspan='3'><input name='organisation' value='[~ $organisation ~]' id='organisation' /></td>
		</tr>
		[~/if~]
		
		<tr>
	 	 <td><label for='name'>Name</label></td>
	 	 <td><input name='name' value='[~$name~]' /> <span class='required'>*</span></td>
		</tr>
		<tr>
		 <td><label for='email'>Email</label></td>
	 	 <td>
		 	<input name='email' value='[~ $email ~]' /> <span class='required'>*</span>
			<p class='subtle'>All your notification emails will be sent to the above address</p>
		 </td>
		</tr>
		<tr>
		 <td><label for='username'>Username</label></td>
	 	 <td>
		 	<input name='username' value='[~ $username ~]' class='minor' /> <span class='required'>*</span>
			<p class='subtle'>Min 5 characters using only numbers, letters or the underscore</p>
		 </td>
		</tr>
		<tr>
		 <td><label for='password'>New Password</label></td>
	 	 <td><input type='password' name='password' value='' class='minor' id='password' /></td>
		</tr>
		<tr>
		 <td><label for='confirm'>Confirm Password</label></td>
	 	 <td><input type='password' name='confirm' value='' class='minor' id='confirm' /><p class='subtle'>&nbsp;</p></td>
		</tr>
		
		[~if $user.groupName == 'Designer'~]
		<tr>
		 <td><label for='request'>Timezone</label></td>
		 <td colspan='3'>
		 	[~ html_options name='timezone' options=$timezones selected=$timezone ~]
			<p class='subtle'>
				Any updates to your timezone will only affect new actions.<br />
				Existing timestamps will not be affected.
			</p>
		 </td>
		</tr>
		[~/if~]
		
		</table>
		
		<div class='submit'>
			<input type='submit' id='submit' name='submit' value='Save Changes' />
			<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
		</div>
		
		<div class='smallPrint'>
			Fields marked with a <strong>*</strong> are required.
		</div>
		
		</form>
	
	</div>
	
</div>

[~include file='inc.end.tpl'~]

</body>
</html>
