<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>Sign-Up</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/signUp.css" />
	<!--[if IE 7]><link rel="stylesheet" type="text/css" href="/css/explorer.css" /><![endif]-->
</head>
<body>
		
<div id='top'>
	<div id='header'>
		<img src='/media/images/promoSite/footprint.png'/>
	</div>
</div>

<div id='middle'>
	
	<!-- Logging in section to be hiddin.....
		<h1>Your Account is Being Created</h1>
			<img src='/media/images/promoSite/loader.png' id='loader' alt='You are being logged in' title='You are being logged in' />
		<h1 id='padOut'>We're Logging You In</h1>-->
	
	<h1>Setup Your Free Account</h1>
	
	<div id='coupon'>
		<form method='post' action=''>
			<h2>Invite Code</h2>
			<input type='text' name='code' id='code' />
		</form>
	</div>
	
	<img src='/media/images/promoSite/anyQuestions.gif' id='anyQuestions' alt='Please Email us if you have any questions' title='Please Email us if you have any questions' />
	
	<div id='details'>
	<form method='post' action=''>
		<div>Name:<input type='text' name='name' id='name' class='enterDetails' />
			<span class='error'>Please fill in your name</span>
		</div>
		<div>Email Address:<input type='text' name='email' id='email' class='enterDetails' />
			<span class='error'>Please fill in a valid email address</span>
		</div>
		<div>Username:<input type='text' name='username' id='username' class='enterDetails' />
			<span class='error'>Enter a valid username with no spaces, A-Z,0-9 or _</span>
		</div>
		<div>Password:<input type='text' name='password' id='password' class='enterDetails' />
			<span class='error'>Enter a valid password, minimum of 5 characters</span>
		</div>
		<div>Company:<input type='text' name='company' id='company' class='enterDetails' />
			<span class='error'>Enter your company name</span>
		</div>
		<div>Country:<select name='country' class='dropdown'>
			<option value="AF">Afghanistan </option>
            <option value="AL">Albania </option>
            <option value="DZ">Algeria </option>
            <option value="AS">American Samoa </option>
				</select>
			<span class='error'>Enter your country</span>
		</div>
		<div>Timezone:<select name='timezone' class='dropdown'>
					  <option value="-12.0">(GMT -12:00) Eniwetok, Kwajalein</option>
				      <option value="12.0">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
				</select>
			<span class='error'>Pick your timezone</span>
		</div>
				
		<div>Site Address:<input type='text' name='siteAddress' id='siteAddress' /><em id='footprintapp'>.footprintapp.com</em>
			<span class='error'>Enter site address</span>
		</div>
				
		<input src='/media/images/promoSite/createAccountButton.png' type='image' name='createAccount' id='createAccount' />
	</form>
	</div>
	
</div>

<div id='end'>
	<div id='footer'>
		<a href='http://webstrong.ie'><img src='/media/images/promoSite/webstrong.png' id='webstrong' alt='Built by Webstrong Ltd' title='Built by Webstrong Ltd' /></a>
			<p>Footprint is a product of Webstrong Ltd. Registered in Ireland. No. 463310.</p>
	</div>		
</div>

		
</body>
</html>
