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
	<script type="text/javascript" src="/jscript/library/lang.js"></script>
	<script type="text/javascript" src="/jscript/library/base.scripts.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{	
		$('#loginLogoBanner').corner('15px top');
		$('#openid_url').focus();
		
		$('#openid').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			openid(formVars);
			
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
			
			[~ validate id='openid'         message=$text.openid   append='error' ~]
			[~ validate id='isSystemOpenID' message=$text.notFound append='error' ~]
			
			[~if $error~]
				<div class='warning'>
				  <ul>
					[~foreach from=$error item="val"~]<li>[~$val~]</li>[~/foreach~]
				  </ul>
				</div>
			[~/if~]
			
			<form name='openid' id='openid' action='index.php' method='post'>
			
				<table>
				<tr>
					<td align='right'><label for='openid_url'>OpenID</label></td>
					<td>
						<input id='openid_url' name='openid_url' value='' class='highPriority' />
						<div class='smallPrint'>Example: username.myopenid.com</div>
					</td>
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
				<a href='/login/'>Go back to the normal login</a>
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