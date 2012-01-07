<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>View Staff - [~$user.organisation~] - Footprint</title>
	
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
		$('#back').click(function()
		{
			history.go(-1);
			return(false);
		});
  	});
	
	</script>
	
	<style type="text/css">
		[~include file='inc.css.tpl'~]
	</style>
	
</head>

<body>

[~include file='inc.nav.tpl'~]

<div id='content'>

	<h1 id='headerStaff'>[~ $staff.firstname ~] [~ $staff.lastname ~]</h1>
	
	<div id='clearBox'>
	<table class='infoTable summary'>
		<tr>
		 <td>Username: <span class='normalText'>[~ $staff.username ~]</span></td>
		 <td>Logins: <span class='normalText'>[~ $staff.totLogins ~]</span></td>
		</tr>
		<tr>
		 <td>Email: <span class='normalText'><a href='mailto:[~ $staff.email ~]'>[~ $staff.email ~]</a></span></td>
		 <td>Last login: <span class='normalText'>[~if $staff.lastLogin == 0 ~]Never[~else~][~ $staff.lastLogin|time_since ~][~/if~]</span></td>
		</tr>
		<tr>
		 <td>Account created: <span class='normalText'>[~ $staff.createdOn|date_format ~]</span></td>
		 <td>&nbsp;</td>
		</tr>
		<tr><td colspan='2'>&nbsp;</td></tr>
		<tr>
		 <td colspan='2'>
		[~ if $projects ~]
		
		 Assigned Projects
		 <div class='multiCheck'>
		 	[~ foreach name=projList item=p from=$projects ~]
		  		<label>
					<a href='/app/projectView.php?id=[~ $p.projID ~]' class='docType projects'>[~ $p.name|truncate:15 ~]</a>
				</label>
			[~ /foreach ~]
		 </div>
		 
		[~ else~]
		
		 <span class='normalText'>
		 	There are no projects assigned to this staff member.
		 </span>
		
		[~ /if ~]
		<div class='clear'></div>
		</td>
		</tr>
	</table>
	
	<a href='/app/staffEdit.php?id=[~ $staff.userID ~]'>
		 <img src='/app/media/images/buttons/editSmall.gif' alt='Edit' />
	</a>
	
	</div>
	
	<div id='infoPanel'>
	
	<h2>Quick Links</h2>
	
		<ul>
		<li>
			<img align='absmiddle' src='/app/media/images/icons/clientsSmall.gif' />
			<a href='/app/clients.php'>Clients</a></li>
		<li>
			<img align='absmiddle' src='/app/media/images/icons/projectsSmall.gif' />
			<a href='/app/projects.php'>Projects</a></li>
		<li>
			<img align='absmiddle' src='/app/media/images/icons/tasksSmall.gif' />
			<a href='/app/tasks.php'>Tasks</a></li>
		<li>
			<img align='absmiddle' src='/app/media/images/icons/screenshotSmall.gif' />
			<a href='/app/screenshots.php'>Screenshots</a></li>
		<li>
			<img align='absmiddle' src='/app/media/images/icons/documentsSmall.gif' />
			<a href='/app/documents.php'>Documents</a></li>
		</ul>
	
	</div>
	
	<div class='clear'></div>
	
	<p>&laquo; <a href='/app/staff.php' id='back'>back</a></p>
	
	<br /><br /><br /><br /><br />

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
