<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>A Project Collaboration Tool for Web Designers - Footprint - OpenID</title>
	<meta name="description" content="Login to your Footprint account using OpenID." />
	<meta name="keywords" content="login, signin page, footprint, openid" />
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/screen.css" />
	
	<script type="text/javascript" src="/jscript/plugins/jQuery.js"></script>
	<script type="text/javascript" src="/jscript/plugins/jCorners.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{	
		$('#loginLogoBanner').corner('15px top');
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
		
			[~if $error~]
				<div class='warning'>
				  <ul>
					[~foreach from=$error item="val"~]<li>[~$val~]</li>[~/foreach~]
				  </ul>
				</div>
			[~/if~]
			
			<div>
				<a href='/openid'>Try again with OpenID</a> | <a href='/login'>Go back to the normal login</a>
			</div>
			
			<br />
			
			<div class='smallPrint'>
				OpenID is a free single digital identity for you on the Internet.
				<a href='http://www.openid.net' target='_blank'>Find out more</a>
			</div>
			
		</div>
	
	</div>
	
</div>

</body>
</html>