<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Staff - [~$user.organisation~] - Footprint</title>
	
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

	<div class='appButton'>
		<span title='Add New Staff'>
		 <a href='/app/staffNew.php'>
		 <img src='/app/media/images/buttons/staffNew.gif' alt='Add New Staff' />
		 </a>
		</span>
	</div>

	<h1 id='headerStaff'>Your Staff</h1>
	
	[~if $message~][~include file='inc.msg.tpl'~][~/if~]
	
	[~if $staff~]
	
		<div class='dataButtons'>
			<ul>
			 <li><a href='#' id='delete'>Delete</a></li>
			</ul>
			<div class='clear'></div>
		</div>
		
		<form id='staff' action='staff.php' method='post'>
		<table class='dataListing'>
		<thead>
		 <tr>
		  <td width='2%'>&nbsp;</td>
		  <td width='30%'>Name</td>
		  <td width='40%'>Email Address</td>
		  <td width='20%'>Last Login</td>
		  <td width='8%'>&nbsp;</td>
		 </tr>
		</thead>
		<tbody>
		[~ foreach name=staffList item=s from=$staff ~]
		 <tr class='[~ cycle values="odd,even" name="rowBackground" ~]'>
		  <td><input type='checkbox' name='staff[[~$s.userID~]]' value='' /></td>
		  <td><a href='/app/staffView.php?id=[~ $s.userID ~]'>[~ $s.firstname ~] [~ $s.lastname ~]</a></td>
		  <td><a href='mailto:[~ $s.email ~]'>[~ $s.email ~]</a></td>
		  <td>[~if $s.lastLogin == 0 ~]Never[~else~][~ $s.lastLogin|time_since ~][~/if~]</td>
		  <td class='last'><a href='/app/staffEdit.php?id=[~ $s.userID ~]'>Edit</a> &raquo;</td>
		 </tr>
		 [~ /foreach ~]
		</tbody>
		</table>
		</form>
		
		<div class='pagination'>
			[~include file='inc.pag.tpl'~]
		</div>
	
	[~else~]
	
		<div class='notice prompt'>
			<h2>Add your first staff member</h2>
			<p>
				Adding your staff to Footprint gives you complete control
				over what client projects they can view and manage.
			</p>
			<p class='smallPrint'>
				This prompt will disappear when you add your first staff member.
			</p>
		</div>
			
		<div>
			<img src='/app/media/images/firstView/staff.png' alt='' />
		</div>
	
	[~/if~]

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
