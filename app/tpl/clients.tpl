<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Clients - [~$user.organisation~] - Footprint</title>
	
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" value="no-cache, no store, must-revalidate">
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/app/css/screen.css" />
	
	<script type="text/javascript" src="/app/jscript/plugins/jQuery.js"></script>
	<script type="text/javascript" src="/app/jscript/fp.behaviour.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{
		rowHighlight();
		handleMessages();
		handleDeletions();
  	});
	
	</script>
	
	<style type="text/css">
		[~include file='inc.css.tpl'~]
	</style>
	
</head>

<body>

[~include file='inc.nav.tpl'~]

<div id='content'>

	[~ if $user.perms.manage_clients ~]
	<div class='appButton'>
		<span title='Create New Client'>
		 <a href='/app/clientNew.php'>
		 <img src='/app/media/images/buttons/clientNew.gif' alt='Create New Client' />
		 </a>
		</span>
	</div>
	[~/if~]

	<h1 id='headerClient'>Clients</h1>
	
	[~if $clients~]
	
		[~if $message~][~include file='inc.msg.tpl'~][~/if~]
	
		[~if $user.perms.manage_clients~]
		<div class='dataButtons'>
			<ul>
			 <li><a href='#' id='delete'>Delete</a></li>
			</ul>
			<div class='clear'></div>
		</div>
		
		<form id='clients' action='clients.php' method='post'>
		[~/if~]
		
		<table class='dataListing'>
		<thead>
		 <tr>
		  <td width='2%'>&nbsp;</td>
		  <td width='30%'>Client</td>
		  <td width='19%'>Contact</td>
		  <td width='29%'>Email Address</td>
		  <td width='14%'>Last Login</td>
		  <td width='6%'>&nbsp;</td>
		 </tr>
		</thead>
		<tbody>
		
		 [~ foreach name=clientList item=c from=$clients ~]
		 <tr class='[~ cycle values="odd,even" name="rowBackground" ~]'>
		  <td>[~if $user.perms.manage_clients~]<input type='checkbox' name='client[[~$c.userID~]]' value='' />[~else~]&nbsp;[~/if~]</td>
		  <td><a href='/app/clientView.php?id=[~ $c.userID ~]'>[~if $c.clientOrganisation != ''~][~ $c.clientOrganisation|truncate:35 ~][~else~][~ $c.lastname ~], [~ $c.firstname ~][~/if~]</a></td>
		  <td>[~ $c.lastname ~], [~ $c.firstname ~]</td>
		  <td><a href='mailto:[~ $c.email ~]'>[~ $c.email|truncate:30 ~]</a></td>
		  <td>[~if $c.lastLogin == 0 ~]Never[~else~][~ $c.lastLogin|time_since ~][~/if~]</td>
		  <td class='last'>[~if $user.perms.manage_clients~]<a href='/app/clientEdit.php?id=[~ $c.userID ~]'>Edit</a> &raquo;[~else~]&nbsp;[~/if~]</td>
		 </tr>
		 [~ /foreach ~]
		
		</tbody>
		</table>
		[~ if $user.perms.manage_clients ~]
			</form>
		[~/if~]
		
		<div class='pagination'>
			[~include file='inc.pag.tpl'~]
		</div>
	
	[~elseif $user.groupName == 'Staff'~]
	
		<div class='notice bad'>
			<h2>No Assigned Clients</h2>
			<p>
				There are no clients in the system assigned to you at the moment. When a client is eventually
				assigned to you, it will be listed here.
			</p>
		</div>
	
	[~else~]
	
		<div class='notice prompt'>
			<h2>Add your first client</h2>
			<p>
				Each client you create can access their own projects and communicate
				with you centrally, helping you to work more efficiently.
			</p>
			<p class='smallPrint'>
				This prompt will disappear when you add your first client.
			</p>
		</div>
		
		<div>
			<img src='/app/media/images/firstView/clients.png' alt='' />
		</div>
	
	[~/if~]

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
