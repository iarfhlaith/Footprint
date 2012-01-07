<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Footprint - A Web Application for Web Designers built by Webstrong</title>
	<meta name="description" content="Footprint - A Web Application for Web Designers built by Webstrong" />
	<meta name="keywords" content="footprint, webstrong, web, application, software, design, web design" />
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="/teaser/style.css" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<script type="text/javascript" src="/teaser/jQuery.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{
		$('#firstname').focus();
	
		$('.input input').focus(function()
		{	
			$(this).css('background-image', 'url(/teaser/inputFocus.png)');
			
		});
		
		$('.input input').blur(function()
		{	
			$(this).css('background-image', 'url(/teaser/input.png)');
		});
		
		$('form').submit(function()
		{
			$('#loader').css('display', 'inline');
			$('.warning').css('display', 'none');
		});
		
  	});
	
	</script>
	
</head>

<body>

<div id='topContainer'>
	<div id='innerTop'>
		<img src='/teaser/spots.gif' alt='' id='icon' />
		<h1>Footprint</h1>
	<img src='/teaser/bubblePerson2.png' alt='Hello Web Designers. Are You Interested Now?' id='bubblePerson' />
	</div>
</div>

<div id='botContainer'>
	<div id='innerBot'>
		<h2>A Web Application built by Webstrong</h2>
		
		[~ if $success ~]
		
			<div id='complete'>
			
				<h1>Thanks for Your Interest</h1>
				
				<p>We're not quite ready to hand out invites yet, but when we are we'll send one to your email address.</p>
				<p>Thanks for waiting. It'll totally be worth it.</p>
				<p>&nbsp;</p>
				<p>If you've got a question that just can't wait, then you can email us at: <a href='mailto:info@footprintapp.com'>info@footprintapp.com</a></p>
			
			</div>
		
		[~ else ~]
		
		<h3 id='titleInfo'>
			Footprint is a business collaboration tool built for web designers.
		</h3>
		<h4>Already have an invite? Go straight to the <a style='color:#FF8C06;' href='http://footprintapp.com/signup/'>sign-up</a> page</h4>
		
		
			<img src='/media/images/screenshots/footprintDashboard.gif' alt='Footprint Dashboard Screenshot' style='float:right;' />
		
		
	<div id='form_box'>
		<form method='post' action='/?thank_you'>
			<table>
				<tr>
					<td>&nbsp;</td>
					<td style='text-align:left;'><h3>Register Your Interest</h3></td>
				</tr>
				<tr>
					<td class='label'>Firstname:</td>
					<td class='input'>
						<input name='firstname' id='firstname' maxlength='50' class='focused' value='[~$firstname~]' />
						<div class='warning'>[~ validate id='firstnameWarning' message="Please enter your firstname" ~]</div>
					</td>
				</tr>
				<tr>
					<td class='label'>Lastname:</td>
					<td class='input'>
						<input name='lastname' id='lastname' maxlength='50' class='blurred' value='[~$lastname~]' />
						<div class='warning'>[~ validate id='lastnameWarning' message="Please enter your lastname" ~]</div>
					</td>
				</tr>
				<tr>
					<td class='label'>Email:</td>
					<td class='input'>
						<input name='email' id='email' maxlength='50' class='blurred' value='[~$email~]' />
						<div class='warning'>[~ validate id='emailWarning' message="Please provide a valid email address" ~]</div>
					</td>
				</tr>
				<tr>
					<td class='submit' colspan='2'>
					<img src='/teaser/loader.gif' alt='Please wait...' id='loader' />
					<input type='image' src='/teaser/button.png' alt='Submit' id='submit' />
					</td>
				</tr>
			</table>
		</form>
	</div>
		[~ /if ~]
		
		<div id='footer'>&copy;2008-2009 Built by <a href='http://webstrong.ie'>Webstrong Ltd</a></div>
		
	</div>
</div>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-264071-3");
pageTracker._initData();
pageTracker._trackPageview();
</script>

</body>
</html>
