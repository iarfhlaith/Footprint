<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Tasks - [~$user.organisation~] - Footprint</title>
	
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
	
		$('#project').change(function()
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
	
	[~if $user.perms.create_tasks~]
	<div class='appButton'>
		<span title='Create New Task'>
		 <a href='/app/taskNew.php'>
		 <img src='/app/media/images/buttons/taskNew.gif' alt='Create New Task' />
		 </a>
		</span>
	</div>
	[~/if~]
	
	[~if $tasks~]
	<div class='dataFilter'>
		<form id='filter'>
		<label for='id'>Display for:</label>
		<select name='id' id='project'>
		<option>All Projects</option>
		[~ html_options options=$projects|truncate:28 selected=$project ~]
		</select>
		<span id='filterLoad'>
			<img src='/app/media/images/loaders/clearDot.gif' width='16' height='16' />
		</span>
		</form>
	</div>
	[~/if~]
	
	<h1 id='headerTask'>Tasks</h1>
	[~if $tasks~]
	
		[~if $message~][~include file='inc.msg.tpl'~][~/if~]
	
		[~if $user.perms.manage_tasks~]
		<div class='dataButtons'>
			<ul>
			 <li><a href='#' id='delete'>Delete</a></li>
			</ul>
			<div class='clear'></div>
		</div>
		
		<form id='tasks' action='tasks.php' method='post'>
		[~/if~]
		
		<table class='dataListing'>
		<thead>
		 <tr>
		  <td width='3%'>&nbsp;</td>
		  <td width='29%'>Task</td>
		  <td width='20%'>Project</td>
		  <td width='27%'>
			[~if $user.perms.all_objects || $user.perms.assigned_objects~]
				Client
			[~else~]
				Description
			[~/if~]
		  </td>
		  <td width='14%'>Created On</td>
		  <td width='7%'>&nbsp;</td>
		 </tr>
		</thead>
		<tbody>
		 [~ foreach name=taskList item=t from=$tasks ~]
		 <tr class='[~ cycle values="odd,even" name="rowBackground" ~]'>
		  <td>
			[~if $user.perms.manage_tasks~]
			<input type='checkbox' name='task[[~$t.taskID~]]' value='' />
			[~else~]
			&nbsp;
			[~/if~]
		  </td>
		  <td><a href='/app/taskView.php?id=[~$t.taskID~]'>[~$t.title|truncate:30~]</a></td>
		  <td><a href='/app/projectView.php?id=[~$t.projID~]'>[~$t.name|truncate:18~]</a></td>
		  <td>
			[~if $user.perms.all_objects || $user.perms.assigned_objects~]
				<a href='/app/clientView.php?id=[~ $t.userID ~]'>[~ $t.clientOrganisation|truncate:30 ~]</a>
			[~else~]
				[~ $t.description|truncate:30 ~]
			[~/if~]
		  </td>
		  <td>[~$t.createdOn|date_format~]</td>
		  <td class='last'>
			[~if $user.perms.manage_tasks~]
				<a href='/app/taskEdit.php?id=[~$t.taskID~]'>Edit</a> &raquo;
			[~else~]
				<span style='white-space:nowrap;'>[~$t.status~]</span>
			[~/if~]
		  </td>
		 </tr>
		 [~ /foreach ~]
		</tbody>
		</table>
		
		[~if $user.perms.manage_tasks~]</form>[~/if~]
		
		<div class='pagination'>
			[~include file='inc.pag.tpl'~]
		</div>
	
	[~elseif $user.groupName == 'Client'~]
	
		<div class='notice good'>
		<h2>No Tasks yet</h2>
		<p>
			When tasks are added to your projects you'll be notified by email and RSS and the details of
			those tasks will be available here.
		</p>
		<p>
			Tasks are used to describe small pieces of work that make up a project. Once created, you can add comments,
			documents, and images to it.
		</p>
		</div>
	
	[~else~]
	
		<div class='notice prompt'>
			<h2>Add your first task</h2>
			<p>
				A task can be used to define a small piece of work within an existing project.
				It's a simple way to make projects more manageable.
			</p>
			<p class='smallPrint'>
				This prompt will disappear when you add your first task.
			</p>
		</div>
		
		<div>
			<img src='/app/media/images/firstView/tasks.png' alt='' />
		</div>
	
	[~/if~]

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
