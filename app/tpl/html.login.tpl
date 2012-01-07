<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>A Project Collaboration Tool for Web Designers - Footprint - Login</title>
	<meta name="description" content="Login to your Footprint account. You'll need your account name, email address and password." />
	<meta name="keywords" content="login, access page, footprint, account, log, log in" />
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/screen.css" />
	
	<script type="text/javascript" src="/jscript/plugins/jQuery.js"></script>
	<script type="text/javascript" src="/jscript/plugins/jQuery.url.js"></script>
	<script type="text/javascript" src="/jscript/plugins/jCorners.js"></script>
	<script type="text/javascript" src="/jscript/library/lang.js"></script>
	<script type="text/javascript" src="/jscript/library/base.scripts.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{	
		$('#loginLogoBanner').corner('15px top');
	
		$('#username').focus();

		$('#login').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			login(formVars);
			
			return(false);
						
    	});

  	});
	
	</script>
	
	<style>
		
		#loginLogoBanner {
		
			background-color:[~$accColour|default:'#003366'~];
			color: #FFFFFF;
			font-size: 20px;
			width=100%;
			padding:10px;	
		}
		
	</style>
	
</head>

<body>

<div id='container'>

	<div id='loginBox'>
		
		<div id='loginLogoBanner'>
			<img src='/app/inc/viewLogo.php?prefix=[~$account~]' alt='Account Login' />
		</div>
		
		<div id='loginForm'>
		
			<div id='jNotice'></div>
			
			[~ validate id='account'  message=$text.account         append='error' ~]
			[~ validate id='username' message=$text.username        append='error' ~]
			[~ validate id='password' message=$text.password        append='error' ~]
			[~ validate id='login'    message=$text.credentialCheck append='error' ~]
			
			[~if $error~]
				<div class='warning'>
				  <ul>
					[~foreach from=$error item="val"~]<li>[~$val~]</li>[~/foreach~]
				  </ul>
				</div>
			[~/if~]
			
			<form name='login' id='login' action='index.php' method='post'>
			<input type='hidden' name='account' value='[~$account~]' />
			
				<table>
				[~if $no_account~]
				<tr>
				<td align='right'><label for='account'>Account</label></td>
				<td><input id='account' name='account' value='[~$account~]' class='highPriority' /></td>
				</tr>
				[~/if~]
				<tr>
				<td align='right'><label for='username'>Username</label></td>
				<td><input id='username' name='username' value='[~$username~]' class='highPriority' /></td>
				</tr>
				<tr>
				<td align='right'><label for='password'>Password</label></td>
				<td><input type='password' id='password' name='password' value='' class='highPriority' /></td>
				</tr>
				<tr>
				<td colspan='2' align='right'>
					<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
					<input type='submit' id='submit' name='submit' value='Login' />
				</td>
				</tr>
				</table>
				
			</form>
			
			<div>
				<a href='/reminder/'>Forgot your password?</a>
			</div>
			
			<br />
			
			<div class='smallPrint'>
				This is a Secure Server. JavaScript &amp; Cookies must be enabled.
			</div>
			
		</div>
	
	</div>
	
	<div id='loginOpenID'>
		<a href='/openid/' class='openIDlink'>Login with an OpenID</a>
	</div>
	
</div>

</body>
</html>
