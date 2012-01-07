<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Upgrade Your System - [~$user.organisation~] - Footprint</title>
	
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

	<h1 id='headerUpgrade'>Upgrade System</h1>
	
	<div id='clearBox'>
	
		<h2>Your Package Details</h2>
		
		<div class='packageData'>
		[~$user.accProjects~] Projects
		<br />
		[~$user.accStaff~] Staff
		<br />
		<span class='lesser'>
		[~$user.accDiskSpace|filesize_format~] Disk Space
		</span>
		</div>

		<h2>Select any Extras You May Need</h2>
		
		<table class='formTable mini'>
		  <tr>
		   <td><label for='additionalProjects'>Extra Projects</label></td>
		   <td>
		   	<select name='additionalProjects'>
			 <option></option>
			 <option>+25 Projects   &euro;10/month</option>
			 <option>+50 Projects   &euro;15/month</option>
			 <option>+100 Projects  &euro;50/month</option>
			 <option>Unlimited Projects &euro;90/month</option>
			</select>
		   </td>
		   <td rowspan='3'>
		   	<div class='formSummary'>
				<strong>Your Selections</strong>
				<ul>
				 <li>Extra Projects: 0</li>
				 <li>Extra Staff: 0</li>
				 <li>Extra Storage: 0</li>
				 <li>+ Base Package</li>
				</ul>
				<strong>Monthly Total: &euro;48</strong>
			</div>
		   </td>
		  </tr>
		  <tr>
		   <td><label for='additionalProjects'>Extra Staff</label></td>
		   <td>
		   	<input name='additionalStaff' class='veryMinor' />
			<span class='normalText'>&euro;5/month each</span>
		   </td>
		  </tr>
		  <tr>
		   <td><label for='additionalProjects'>Extra Disk Space</label></td>
		   <td>
		   	<select>
			 <option></option>
			 <option>+20MB  &euro;5/month</option>
			 <option>+40MB  &euro;10/month</option>
			 <option>+80MB  &euro;20/month</option>
			 <option>+120MB &euro;30/month</option>
			 <option>+240MB &euro;40/month</option>
			</select>
		   </td>
		  </tr>
		</table>

		<table class='formTable mini'>
		<tr>
		 <td colspan='2'><h2>Enter Your Billing Address and Email</h2></td>
		</tr>
		<tr>
		 <td><label for='country'>Country</label></td>
		 <td>[~include file='inc.cnt.tpl'~]</td>
		</tr>
		<tr>
		 <td><label for='address'>Street Address</label></td>
		 <td><input name='address' id='address' value='[~$address|default:$billInfo.addStreet~]' /></td>
		</tr>
		<tr>
		 <td><label for='city'>City</label></td>
		 <td><input name='city' id='city' value='[~$city|default:$billInfo.addCity~]' class='minor' /></td>
		</tr>
		<tr>
		 <td><label for='state'>Province/State</label></td>
		 <td><input name='state' id='state' value='[~$state|default:$billInfo.addState~]' class='minor' /></td>
		</tr>
		<tr>
		 <td><label for='zip'>Postal/Zip Code</label></td>
		 <td><input name='zip' id='zip' value='[~$zip|default:$billInfo.addZipCode~]' class='veryMinor' /></td>
		</tr>
		<tr>
		 <td><label for='email'>Email Address</label></td>
		 <td><input name='email' id='email' value='[~$email|default:$billInfo.email~]' /></td>
		</tr>
		<tr><td colspan='3'><h2>Your Credit Card Information</h2></td></tr>
		<tr>
		 <td><label for='type'>Type of Credit Card</label></td>
		 <td><select name='type' id='type'>[~ html_options values=$cardOpts output=$cardOpts selected=$billInfo.ccType ~]</select></td>
		</tr>
		<tr>
		 <td><label for='name'>Name on Credit Card</label></td>
		 <td><input name='name' id='name' value='[~$name|default:$billInfo.ccName~]' /></td>
		</tr>
		<tr>
		 <td><label for='cardNumber'>Credit Card No.</label></td>
		 <td><input name='cardNumber' id='cardNumber' value='[~$cardNumber|default:$billInfo.ccMask~]' /></td>
		</tr>
		<tr>
		 <td><label for='cardNumber'>Expiry Date</label></td>
		 <td>[~html_select_date time=$billInfo.ccExp display_days='0' month_format='%b' end_year='+3' all_extra='class="date"'~]</td>
		</tr>
		</table>
		
		<div class='submit'><input type='submit' id='submit' name='submit' value='Pay Now' /></div>

	</div>
	
	<div id='infoPanel'>
		
		<h2>Your Base Package</h2>
	
		<table>
		<tr>
		<td class='tdLeft line'>Projects</td>
		<td class='tdRight'>[~$user.accProjects~]</td>
		</tr>
		<tr>
		<td class='tdLeft'>Staff</td>
		<td class='tdRight'>[~$user.accStaff~]</td>
		</tr>
		<tr>
		<td class='tdLeft'>Disk Space</td>
		<td class='tdRight'>[~$user.accDiskSpace|filesize_format~]</td>
		</tr>
		</table>
		
		<h2 class='upgradeSummary'>New Package</h2>
	
		<table>
		<tr>
		<td class='tdLeft'>Monthly Payment</td>
		<td class='tdRight'>&euro;45</td>
		</tr>
		<tr>
		<td class='tdLeft'>Due Jan. 21</td>
		<td class='tdRight'>&nbsp;</td>
		</tr>
		<tr>
		<td class='tdLeft highlight' colspan='2'>To be charged now: &euro;10</td>
		</tr>
		</table>

	</div>
	
	<div class='clear'></div>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
