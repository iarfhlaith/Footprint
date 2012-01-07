<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Account Info - [~$user.organisation~] - Footprint</title>
	
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

	<h1 id='headerAccount'>[~$user.organisation~]</h1>
	
	<div id='clearBox'>
	
		<h2>Account Information</h2>

		<table class='infoTable'>
		<tr>
		<td>Selected package:</td>
		<td>[~$stats.packageTitle~] <span class='normalText'>(<a href='/app/upgrade.php'>upgrade your system</a>)</span></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td>
			[~if $payments~]
			<span class='normalText'><a href='/app/update.php'>Update your credit card information</a> for this account</span>
			[~else~]&nbsp;[~/if~]
		</td>
		</tr>
		
		<tr>
		<td><span class='barLabel'>Projects:</span></td>
		<td>
			<table class='bar'>
				<tr>
				<td width='[~$stats.usageProjects|commify:0~]%'><img src='/app/media/images/data/bar[~$stats.colourProjects~].gif' alt='' width='100%' height='16' /></td>
				<td><img src='/app/media/images/data/bar.gif' alt='' width='100%' height='16' /></td>
				</tr>
			</table> 
		</td>
		<td><span class='barMetric'>[~$stats.totProjects~]/[~$stats.accProjects~]</span></td>
		</tr>
		<tr>
		<td><span class='barLabel'>Disk space:</span></td>
		<td>
			<table class='bar'>
				<tr>
				<td width='[~$stats.usageDiskSpace|commify:0~]%'><img src='/app/media/images/data/bar[~$stats.colourDiskSpace~].gif' alt='' width='100%' height='16' /></td>
				<td><img src='/app/media/images/data/bar.gif' alt='' width='100%' height='16' /></td>
				</tr>
			</table> 
		</td>
		<td><span class='barMetric'>
				[~$stats.totDiskSpace|filesize_format~]/[~$stats.accDiskSpace|filesize_format~]
			</span></td>
		</tr>
		<tr>
		<td><span class='barLabel'>Staff:</span></td>
		<td>
			<table class='bar'>
				<tr>
				<td width='[~$stats.usageStaff|commify:0~]%'><img src='/app/media/images/data/bar[~$stats.colourStaff~].gif' alt='' width='100%' height='16' /></td>
				<td><img src='/app/media/images/data/bar.gif' alt='' width='100%' height='16' /></td>
				</tr>
			</table> 
		</td>
		<td><span class='barMetric'>[~$stats.totStaff~]/[~$stats.accStaff~]</span></td>
		</tr>
		</table>
		
		<h2>Account Stats</h2>
		
		<table class='infoTable summary'>
		<tr>
		<td>No. of clients: <span class='normalText'>[~$stats.totClients~]</span></td>
		<td>No. of tasks: <span class='normalText'>[~$stats.totTasks~]</span></td>
		</tr>
		<tr>
		<td>No. of screenshots: <span class='normalText'>[~$stats.totScreenshots~]</span></td>
		<td>Logins: <span class='normalText'>[~$stats.totLogins~]</span></td>
		</tr>
		<tr>
		<td>Account created: <span class='normalText'>[~$stats.accountCreated|date_format:#dateFormat1#~]</span></td>
		<td>Last login: <span class='normalText'>[~$stats.lastLogin|time_since~]</span></td>
		</tr>
		</table>
	
	</div>
	
	<div id='infoPanel'>
		
		[~if $payments~]
			<h2>Payments Received</h2>
			<table>
			[~ foreach name=payments item=p from=$payments ~]
			<tr>
			  <td class='tdLeft'>[~$p.dateReceived|date_format:#dateFormat1#~]</td>
			  <td class='tdRight'>&euro;[~$p.amount|commify:2~]</td>
			</tr>
			[~/foreach~]
			</table>
		[~/if~]
		
		[~if $upgrades~]
			<h2>Account Upgrades</h2>
			<table>
			[~ foreach name=upgrades item=u from=$upgrades~]
			 <tr>
			  <td class='tdLeft line'>
				[~$u.dateUpgraded|date_format:#dateFormat1#~]<br />&euro;[~$u.newCharge~] per month
			  </td>
			 </tr>
			 [~/foreach~]
			</table>
		[~/if~]
		
		[~if !$payments && !$upgrades ~]
		
			<div class='upgrade'>
				
				<span title='Upgrade Now'>
				 <a href='/app/upgrade.php'>
					<img src='/app/media/images/buttons/upgradeNow.gif' alt='Upgrade Now' />
				 </a>
				</span>
				
				<p>
					<strong>
					Upgrading lets you add lots more projects, use a much larger disk space
					and increases how many staff members you can add.
					</strong>
				</p>
				
				<p>
					You only need to pay for what you want and you can tailor make your own
					package so you don't end up buying features you don't need.
				</p>
				
				<p>
					All pay accounts come with a 30 day money back guarantee, absolutely no strings
					attached. So if you think Footprint's not for you, we can cancel your account and
					you won't be billed.
				</p>

			</div>
		
		[~/if~]
		
	</div>
	
	<div class='clear'></div>
	
	<p>Go here to <a href='/app/accCancel.php'>cancel your account</a>.</p>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
