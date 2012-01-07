<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Projects - [~$user.organisation~] - Footprint</title>
	
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
	
		$('#client').change(function()
		{
			$('#filter').submit();
			$('#filterLoad').html("<img src='/app/media/images/loaders/loading.gif' alt='Loading...' />");
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
	
	[~if $user.perms.create_projects~]
	<div class='appButton'>
		<span title='Create New Project'>
		 <a href='/app/projectNew.php'>
		 <img src='/app/media/images/buttons/projectNew.gif' alt='Create New Project' />
		 </a>
		</span>
	</div>
	[~/if~]
	
	[~if $projects~]
		[~if $user.perms.all_objects || $user.perms.assigned_objects ~]
		<div class='dataFilter'>
			<form id='filter'>
			<label for='id'>Display for:</label>
			<select name='id' id='client'>
			<option>All Clients with Projects</option>
			<option value=''>-------------------------</option>
			[~ html_options options=$clients|truncate:28 selected=$client ~]
			</select>
			<span id='filterLoad'>
				<img src='/app/media/images/loaders/clearDot.gif' width='16' height='16' />
			</span>
			</form>
		</div>
		[~/if~]
	[~/if~]
	
	<h1 id='headerProject'>Projects</h1>

	[~if $projects~]
	
		[~if $message~][~include file='inc.msg.tpl'~][~/if~]
	
		[~if $user.perms.delete_projects~]
		<div class='dataButtons'>
			<ul>
			 <li><a href='#' id='delete'>Delete</a></li>
			</ul>
			<div class='clear'></div>
		</div>
		
		<form id='projects' action='projects.php' method='post'>
		[~/if~]
		
		<table class='dataListing'>
		<thead>
		 <tr>
		  <td width='2%'>&nbsp;</td>
		  <td width='29%'>Project</td>
		  <td width='19%'>Managed by</td>
		  <td width='29%'>
			[~if $user.perms.all_objects || $user.perms.assigned_objects~]
				Client
			[~else~]
				Description
			[~/if~]
		  </td>
		  <td width='15%'>Created On</td>
		  <td width='6%'>&nbsp;</td>
		 </tr>
		</thead>
		<tbody>
		
		 [~ foreach name=projectList item=p from=$projects ~]
		 <tr class='[~ cycle values="odd,even" name="rowBackground" ~]'>
		  <td>[~if $user.perms.delete_projects~]<input type='checkbox' name='project[[~$p.projID~]]' value='' />[~else~]&nbsp;[~/if~]</td>
		  <td><a href='/app/projectView.php?id=[~ $p.projID ~]'>[~ $p.name|truncate:30 ~]</a></td>
		  <td>[~ $p.firstname ~] [~ $p.lastname ~]</td>
		  <td>
			[~if $user.perms.all_objects || $user.perms.assigned_objects~]
				<a href='/app/clientView.php?id=[~ $p.userID ~]'>[~ $p.clientOrganisation|default:$p.userFullname ~]</a>
			[~else~]
				[~ $p.description|truncate:30 ~]
			[~/if~]
		  </td>
		  <td>[~ $p.dateCreated|date_format ~]</td>
		  <td class='last'>
			[~if $user.perms.all_objects || $user.perms.assigned_objects ~]
				<a href='/app/projectEdit.php?id=[~ $p.projID ~]'>Edit</a> &raquo;</td>
			[~else~]
				&nbsp;
			[~/if~]
		 </tr>
		 [~ /foreach ~]
		
		</tbody>
		</table>
		[~ if $user.perms.delete_projects ~]
			</form>
		[~/if~]
		
		<div class='pagination'>
			[~include file='inc.pag.tpl'~]
		</div>
	
	[~elseif $user.groupName == 'Staff'~]
	
		<div class='notice bad'>
			<h2>No Assigned Projects</h2>
			<p>
				There are no projects in the system assigned to you at the moment. When a project is eventually
				assigned to you, it will be listed here.
			</p>
		</div>
	
	[~elseif $user.groupName == 'Client'~]
	
		<div class='notice good'>
		<h2>No Projects yet</h2>
		<p>
			When projects are added to your account you'll be notified by email and RSS and the details of
			those projects will be available here.
		</p>
		<p>
			Projects are used to group relevant tasks together. You can use projects to communicate and collaborate
			with each other. 
		</p>
		</div>
	
	[~else~]
	
		<div class='notice prompt'>
			<h2>Add your first project</h2>
			<p>
				Projects are the core of your Footprint system. Create a project for one of your clients
				and use it to manage every aspect of that piece of work.
			</p>
			<p class='smallPrint'>
				This prompt will disappear when you add your first project.
			</p>
		</div>
		
		<div>
			<img src='/app/media/images/firstView/projects.png' alt='' />
		</div>
	
	[~/if~]

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
