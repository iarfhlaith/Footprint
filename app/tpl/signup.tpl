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
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>Create An Account - Footprint</title>
	<meta name="description" content="" />
	<meta name="keywords" content="Signup, Join, Create Account" />
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/signUp.css" />
	<!--[if IE 7]><link rel="stylesheet" type="text/css" href="/css/explorer.css" /><![endif]-->
	
	<script type="text/javascript" src="/app/jscript/plugins/jQuery.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{
		$('#code').focus();
		
		$('form').submit(function()
		{
			$('#interim').show();
			$('#signup').hide();
		});
		
	});
	
	</script>
	
</head>
<body>
	
<div id='top'>
	<div id='header'>
		<a href='/'>
			<img src='/media/images/promoSite/footprint.png' alt='Footprint Homepage' title='Footprint Homepage'/>
		</a>
	</div>
</div>

<div id='middle'>
	
	<div id='interim'>
		<h1>Your Account is Being Created</h1>
			<img src='/app/media/images/loaders/loader.gif' id='loader' alt='You are being logged in' title='You are being logged in' />
		<h1 class='padOut'>We're Logging You In</h1>
	</div>
	
	<div id='signup'>
		<h1>Setup Your Free Account</h1>
		<form action='index.php' method='post'>
			
			<a href='mailto:info@footprintapp.com'>
				<img src='/media/images/promoSite/anyQuestions.gif' id='anyQuestions' alt='Please email us if you have any questions' title='Please email us if you have any questions' />
			</a>
			
			<div id='details'>
			
				<div>Name:<input name='name' value='[~$name~]' class='enterDetails' />
					[~ validate id='msgName' message='Please enter your name' ~]
				</div>
				<div>Email Address:<input name='email' value='[~$email~]' class='enterDetails' />
					[~ validate id='msgEmail' message='Please provide a valid email address' ~]
				</div>
				<div>Username:<input name='username' value='[~$username~]' class='enterDetails' />
					[~ validate id='msgUsername' message='Please choose an alphanumeric username with 5 chars or more and no spaces' ~]
				</div>
				<div>Password:<input name='password' type='password' class='enterDetails' />
					[~ validate id='msgPassword' message="Please choose a password that's 6 chars or more and contains both letters & numbers." ~]
				</div>
				<div>Company:<input name='company' value='[~$company~]' class='enterDetails' />
					[~ validate id='msgCompany' message='Please enter your company name' ~]
				</div>
				<div class='dropdown'>Country:[~include file='inc.cnt.tpl'~]
					[~ validate id='msgCountry' message='Please select your country' ~]
				</div>
				<div class='dropdown'>Timezone:[~ html_options name='timezone' options=$timezones selected=$timezone ~]
					[~ validate id='msgTimezone' message='Please select your timezone' ~]
				</div>
				<div>Site Address:<input name='prefix' value='[~$prefix~]' id='siteAddress' /><em id='footprintapp'>.footprintapp.com</em>
					[~ validate id='msgPrefix1' message='Please select a valid account name' ~]
					[~ validate id='msgPrefix2' message='That prefix has already been taken.' ~]
				</div>
						
				<input src='/media/images/promoSite/createAccountButton.png' type='image' name='createAccount' id='createAccount' />
			
			</div>
			
		</form>
	</div>
	
</div>

<div id='end'>
	<div id='footer'>
		<div>
			<a href='http://webstrong.ie'>
				<img src='/media/images/promoSite/webstrong.png' id='webstrong' alt='Built by Webstrong Ltd' title='Built by Webstrong Ltd' />
			</a>
		</div>
		<p>Footprint is a product of Webstrong Ltd. Registered in Ireland. No. 463310.</p>
	</div>		
</div>
	
</body>
</html>	
