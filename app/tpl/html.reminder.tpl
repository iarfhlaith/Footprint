<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>A Project Collaboration Tool for Web Designers - Footprint - Password Reminder</title>
	<meta name="description" content="Forgotten your password? We'll send it to your email address." />
	<meta name="keywords" content="email reminder, forgotten password, footprint, prompt, forget, password, remind me" />
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/screen.css" />
	
	<script type="text/javascript" src="/jscript/plugins/jQuery.js"></script>
	<script type="text/javascript" src="/jscript/plugins/jCorners.js"></script>
	<script type="text/javascript" src="/jscript/library/lang.js"></script>
	<script type="text/javascript" src="/jscript/library/base.scripts.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{	
		$('#loginLogoBanner').corner('15px top');
		$('#email').focus();

		$('#reminder').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			remind(formVars);
			
			return(false);
			
    	});
		
  	});
	
	</script>
	
	<style>
		
		#loginLogoBanner {
		
			background-color:[~$accColour|default:'#003366'~];
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
		
		[~if $valid~]	
			  <div class='success'><ul><li>[~$text.success~]</li></ul></div>
		[~else~]
			
			[~ validate_set_params pre="<li>" post="</li>" ~]
			[~ validate id='emailValidate' message=$text.emailValidate assign='error'  ~]
			[~ validate id='emailCheck'    message=$text.emailCheck    assign='error'  ~]
			
			[~if $error~]
				<div class='warning'><ul><li>[~$error~]</li></ul></div>
			[~/if~]
			
			<form name='reminder' id='reminder' action='index.php' method='post'>
			<input type='hidden' name='account' value='[~$account~]' />
			
				<p>
					Enter your email address and we'll send you a new password.
				</p>
			
				<table>
				<tr>
				<td align='right'><label for='account'>Email</label></td>
				<td>
					<input type='text' id='email' name='email' value='[~$email~]' class='highPriority' />
				</td>
				</tr>
				<tr>
				<td colspan='2' align='right'>
					<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
					<input type='submit' id='submit' name='submit' value='Send Password' />
				</td>
				</tr>
				</table>
				
			</form>
			
		[~/if~]
			
		<div><a href='/login/'>Return to login page</a></div>
			
		</div>
	
	</div>
	
	<div id='loginOpenID'>
		<a href='/openid/' class='openIDlink'>Login with an OpenID</a>
	</div>
	
</div>

</body>
</html>