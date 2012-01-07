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
	
		$('#settings2').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('settings2', formVars);
			
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

	<h1 id='headerSettings'>Settings</h1>
	
	[~if $message~][~include file='inc.msg.tpl'~][~/if~]
	
	<div id='jNotice'></div>
			
	[~ validate id='style'	message=$text.style	append='error' ~]
	
	[~if $error~]
		<div class='warning'>
		  <ul>
			[~foreach from=$error item="val"~]<li>[~$val~]</li>[~/foreach~]
		  </ul>
		</div>
	[~/if~]
	
	[~include file='inc.tab.tpl'~]
	
	<div class='settingOptions'>
	
		[~if $user.cssScheme == '0'~]
			
			<div class='notice pointer'>
			<h2>You've got a Custom Skin</h2>
			<p>
				It looks like your account has been custom skinned by the Footprint Team. To make any changes to your colour scheme
				you'll need to contact us directly.
			</p>
			<h3>Why Can't I Change My Colour Scheme?</h3>
			<p>
				As things stand, Footprint lets users choose from one of several pre designed colour schemes, but for a small fee we'll
				customise your colour scheme to perfectly match your businesses brand. That's what's happened on your account, and to prevent 
				the custom settingsd from being overwritten, we've disabled this feature on your account.
			</p>
			<p>
				If you need some changes made, just <a href='mailto:support@footprintapp.com'>contact support</a> and we'll help out as best we can.
			</p>
		</div>
			
		[~else~]
		
			<h2>Choose your own Colour Scheme</h2>
		
			<form name='settings2' id='settings2' action='/app/settings2.php' method='post'>
	
			<table class='formTable'>
			<tr>
			<td>
				<input type='radio' name='style' value='1' class='radio' [~if $user.cssScheme == '1'~]checked='checked'[~/if~] />
				<img src='/app/media/images/custom/blue.gif' alt='Blue' />
			</td>
			<td>
				<input type='radio' name='style' value='4' class='radio' [~if $user.cssScheme == '4'~]checked='checked'[~/if~] />
				<img src='/app/media/images/custom/brown.gif' alt='Brown' />
			</td>
			<td>
				<input type='radio' name='style' value='5' class='radio' [~if $user.cssScheme == '5'~]checked='checked'[~/if~] />
				<img src='/app/media/images/custom/green.gif' alt='Green' />
			</td>
			</tr>
			<tr>
			<td>
				<input type='radio' name='style' value='6' class='radio' [~if $user.cssScheme == '6'~]checked='checked'[~/if~] />
				<img src='/app/media/images/custom/purple.gif' alt='Purple' />
			</td>
			<td>
				<input type='radio' name='style' value='3' class='radio' [~if $user.cssScheme == '3'~]checked='checked'[~/if~] />
				<img src='/app/media/images/custom/red.gif' alt='Red' />
			</td>
			<td>
				<input type='radio' name='style' value='2' class='radio' [~if $user.cssScheme == '2'~]checked='checked'[~/if~] />
				<img src='/app/media/images/custom/black.gif' alt='Black' />
			</td>
			</tr>
			</table>
			
			<div class='submit'>
				<input type='submit' id='submit' name='submit' value='Save Changes' />
				<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
			</div>
			
			</form>
		
		[~/if~]
		
	</div>
	
</div>

[~include file='inc.end.tpl'~]

</body>
</html>
