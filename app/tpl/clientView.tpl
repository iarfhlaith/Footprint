<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>View Client - Webstrong Internet Solutions - Footprint</title>
	
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

	<h1 id='headerClient'>[~ $client.clientOrganisation ~]</h1>
	
	<div id='clientPanel'>
	
		<h2 id='actionHeader'>Actions</h2>
		<div id='actions'>		
			<ul>
				[~if $user.perms.create_projects~]
				<li><a href='/app/projectNew.php?cid=[~$client.userID~]'>New Project</a></li>
				[~/if~]
				
				<li><a href='/app/taskNew.php?cid=[~$client.userID~]'>New Task</a></li>
				<li><a href='/app/screenshotNew.php?cid=[~$client.userID~]'>New Screenshot</a></li>
				<li><a href='/app/documentNew.php?cid=[~$client.userID~]'>New Document</a></li>
			</ul>
		</div>
		
		<h2 id='linkHeader'>Quick Links</h2>
		<div id='quickLinks'>
			<ul>
				<li>
					<img align='absmiddle' src='/app/media/images/icons/projectsSmall.gif' />
					<a href='/app/projects.php?id=[~$client.userID~]'>Projects</a></li>
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
	
	</div>
	
	<div id='clientInfo'>
		
		<h2>Client Info</h2>
		
		<table>
		<tr>
		 <td>Contact: <strong>[~ $client.firstname ~] [~ $client.lastname ~]</strong></td>
		 <td>No. of Logins: [~ $client.totLogins ~]</td>
		</tr>
		<tr>
		 <td>Username: [~ $client.username ~]</td>
		 <td>Last Login: [~if $client.lastLogin == 0 ~]Never[~else~][~ $client.lastLogin|time_since ~][~/if~]</td>
		</tr>
		<tr>
		 <td>Password: ********</td>
		 <td>Created On: [~ $client.createdOn|date_format ~]</td>
		</tr>
		<tr>
		 <td>Email: <a href='mailto:[~ $client.email ~]'>[~ $client.email ~]</a></td>
		 <td>&nbsp;</td>
		</tr>
		</table>
		
		[~if $user.perms.manage_clients~]
		 <a href='/app/clientEdit.php?id=[~$client.userID~]'>
		  <img src='/app/media/images/buttons/editSmall.gif' alt='Edit' />
		 </a>
		[~/if~]
			
	</div>
	
	<div class='clear'></div>
	
	<p>&laquo; <a href='/app/clients.php' id='back'>back</a></p>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
