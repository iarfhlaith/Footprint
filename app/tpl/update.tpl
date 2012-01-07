<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Update Account Information - [~$user.organisation~] - Footprint</title>
	
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" value="no-cache, no store, must-revalidate">
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/app/css/screen.css" />
	
	<script type="text/javascript" src="/app/jscript/plugins/jQuery.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{

  	});
	
	</script>
	
	<style type="text/css">
		[~include file='inc.css.tpl'~]
	</style>
	
</head>

<body>

[~include file='inc.nav.tpl'~]

<div id='content'>

	<h1 id='headerAccount'>Update Account Information</h1>
	
	<table class='formTable mini'>
	<tr><td colspan='3'><h2>Your Billing Address and Email</h2></td></tr>
	<tr>
	 <td><label for='country'>Country</label></td>
	 <td colspan='2'>[~include file='inc.cnt.tpl'~] <span class='required'>*</span></td>
	</tr>
	<tr>
	 <td><label for='address'>Street Address</label></td>
	 <td><input name='address' id='address' value='' /> <span class='required'>*</span></td>
	 <td rowspan='5'><div class='formTip'><strong>Note</strong><br />A monthly email receipt will be sent out to the email address here.</div></td>
	</tr>
	<tr>
	 <td><label for='city'>City</label></td>
	 <td colspan='2'><input name='city' id='city' value='' class='minor' /> <span class='required'>*</span></td>
	</tr>
	<tr>
	 <td><label for='state'>Province/State</label></td>
	 <td colspan='2'><input name='state' id='state' value='' class='minor' /></td>
	</tr>
	<tr>
	 <td><label for='zip'>Postal/Zip Code</label></td>
	 <td colspan='2'><input name='zip' id='zip' value='' class='minor' /></td>
	</tr>
	<tr>
	 <td><label for='email'>Email Address</label></td>
	 <td colspan='2'><input name='email' id='email' value='' /> <span class='required'>*</span></td>
	</tr>
	<tr><td colspan='3'><h2>Your Credit Card Information</h2></td></tr>
	<tr>
	 <td><label for='type'>Type of Credit Card</label></td>
	 <td colspan='2'><select name='type' id='type'><option>Mastercard</option><option>Visa</option><option>Laser</option></select> <span class='required'>*</span></td>
	</tr>
	<tr>
	 <td><label for='name'>Name on Credit Card</label></td>
	 <td><input name='name' id='name' value='' /> <span class='required'>*</span></td>
	 <td rowspan='3'><div class='formTip'><strong>Note</strong><br />The charge will appear on your credit card statement as 'WEBSTRONG'.</div></td>
	</tr>
	<tr>
	 <td><label for='cardNumber'>Credit Card No.</label></td>
	 <td colspan='2'><input name='cardNumber' id='cardNumber' value='' /> <span class='required'>*</span></td>
	</tr>
	<tr>
	 <td><label for='cardNumber'>Expiry Date</label></td>
	 <td colspan='2'>[~html_select_date display_days='0' month_format='%b' end_year='+3' all_extra='class="date"'~] <span class='required'>*</span></td>
	</tr>
	</table>
	
	<div class='submit'><input type='submit' id='submit' name='submit' value='Save Changes' /></div>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
