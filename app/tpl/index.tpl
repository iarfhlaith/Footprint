<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Dashboard - [~$user.organisation~] - Footprint</title>
	
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
		handleMessages();
		
		$('#infoBox').hide();
		
		$('#showActivity').click(function()
		{
            $('#showActivity').hide();
			$('#infoBox').show();
		});
		
		$('#hideActivity').click(function()
		{
            $('#showActivity').show();
			$('#infoBox').hide();
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
	
	<div id='dashboard'>
		
		[~if $message~][~include file='inc.msg.tpl'~][~/if~]
		
		<!-- Display Prompt Notices (Clients >> Projects >> Tasks) -->
		
		[~if $user.perms.manage_clients && $stats.totClients < 1 ~]
		
			<div class='notice dash' id='message'>
				<div class='close'>
					<a href='#'><img src='/app/media/images/icons/close.png' alt='Close' /></a>
				</div>
				<h2>Getting Started</h2>
				 <p class='intro'>
				 	First thing's first. Add your first client. After that you can create projects, tasks
					and fill up every nook and cranny of your new account with information.
				</p>
				<div class='noticeButton'>
					<a href='/app/clientNew.php'>
						<img src='/app/media/images/buttons/firstClient.gif' alt='Add Your First Client' />
					</a>
					<br /><br /><br />
						<img src='/app/media/images/buttons/stepClient.gif' />
				</div>
				
				<div class='clear'></div>
			</div>
		
		[~elseif $user.perms.create_projects && $stats.totProjects < 1~]
		
			<div class='notice dash' id='message'>
				<div class='close'>
					<a href='#'><img src='/app/media/images/icons/close.png' alt='Close' /></a>
				</div>
				<h2>What Next?</h2>
				 <p class='intro'>
				 	Now that you've added your first Client you'll probably want to start adding projects. Now is a good time!
				</p>
				<div class='noticeButton'>
					<br />
					<a href='/app/projectNew.php'>
						<img src='/app/media/images/buttons/firstProject.gif' alt='Add Your First Project' />
					</a>
					<br /><br /><br />
						<img src='/app/media/images/buttons/stepProject.gif' />
				</div>
				
				<div class='clear'></div>
			</div>
		
		[~elseif $user.perms.create_tasks && $stats.totTasks < 1~]
		
			<div class='notice dash' id='message'>
				<div class='close'>
					<a href='#'><img src='/app/media/images/icons/close.png' alt='Close' /></a>
				</div>
				<h2>Get Stuff Done</h2>
				 <p class='intro'>
				 	Stay on track with your projects to-dos and start adding tasks. They're the best way to stay on top of your work.
				</p>
				<div class='noticeButton'>
					<br />
					<a href='/app/taskNew.php'>
						<img src='/app/media/images/buttons/firstTask.gif' alt='Add Your First Task' />
					</a>
					<br /><br /><br />
						<img src='/app/media/images/buttons/stepTask.gif' />
				</div>
				
				<div class='clear'></div>
			</div>
		
		[~/if~]
		
		<!-- Display Dashboard Links -->
		
		<div id='dashTableWrap'>
			<table class='dashTable'>
				
				[~if $user.perms.manage_clients~]
				
					<tr>
						<td>
							<a href='/app/clients.php'>
							<img src='/app/media/images/icons/clientsLarge.gif' />
							</a>
						</td>
						<td>
							<h3><a href='/app/clients.php'>Build Your Client List</a></h3>
							<p>Manage your clients within Footprint. Control what they can access and keep them up to date on what's happening on their projects.</p>
						</td>
					</tr>
				
				[~/if~]
				
				[~if $user.perms.manage_projects~]
				
					<tr>
						<td>
							<a href='/app/projects.php'>
							<img src='/app/media/images/icons/projectsLarge.gif' />
							</a>
						</td>
						<td>
							<h3><a href='/app/projects.php'>Manage Your Projects</a></h3>
							<p>Stay on track with these simple project management tools to help you get things done.</p>
						</td>
					</tr>
				
				[~/if~]
				
				[~if $user.perms.manage_tasks~]
				
					<tr>
						<td>
							<a href='/app/tasks.php'>
							<img src='/app/media/images/icons/tasksLarge.gif' />
							</a>
						</td>
						<td>
							<h3><a href='/app/tasks.php'>Task Management</a></h3>
							<p>Use tasks to stay on top of day to day jobs. Each one can be attached to a project to help keep everything organised.</p>
						</td>
					</tr>
				
				[~/if~]
				
				[~if $user.perms.make_requests~]
				
					<tr>
						<td>
							<a href='/app/requests.php'>
							<img src='/app/media/images/icons/requestsLarge.gif' />
							</a>
						</td>
						<td>
							<h3><a href='/app/requests.php'>View Current Requests</a></h3>
							<p>View all current requests for your account. If a request is accepted by your designer, then it'll be upgraded to a Task.</p>
						</td>
					</tr>
				
				[~/if~]
				
			</table>
			
			<table class='dashTable mini'>		
				<tr>
					<td class='icon'><img src='/app/media/images/icons/screenshotMedium.gif'></td>
					<td class='content'>
						<h4><a href='/app/screenshots.php'>Upload a Screenshot</a></h4>
						<p>Collaborate on designs or simply store your project images. Version controlled.</p>
					</td>
					<td class='icon'><img src='/app/media/images/icons/documentsMedium.gif'></td>
					<td class='content'>
						<h4><a href='/app/documents.php'>Document Management</a></h4>
						<p>Manage all your project documents. Version controlled.</p>
					</td>
				</tr>
				
				[~if $user.perms.staff && $user.perms.manage_colours_logos ~]
				
				<tr>
					<td class='icon'><img src='/app/media/images/icons/staffMedium.gif'></td>
					<td class='content'>
						<h4><a href='/app/staff.php'>Give Your Team Access</a></h4>
						<p>Allow your Staff to access the projects their working on.</p>
					</td>
					<td class='icon'><img src='/app/media/images/icons/settingsMedium.gif'></td>
					<td class='content'>
						<h4><a href='/app/screenshots.php'>Customise Everything</a></h4>
						<p>Select your own colour scheme and upload your company logo.</p>
					</td>
				</tr>
				
				[~/if~]
				
			</table>
		</div>
		
		<!-- Display Activity Feed -->
		
		[~if $user.perms.activity_feed && $activity~]
			
			<div id='showActivity'>
				<a href='#'>
				<span title='Show Recent Account Activity'>
					<img src='/app/media/images/buttons/showActivity.gif' alt='Show Recent Account Activity' />
				</span>
				</a>
			</div>
			
			<div id='infoBox'>
				<a id='hideActivity' href='#'>
					<img src='/app/media/images/buttons/hideActivity.gif' style='float:right; padding-top:4px;' />
				</a>
				
				<h1 id='headerRSS'><a href='/app/rssIntro.php'>Recent Activity</a></h1>
				
				<ul class='activity'>
					[~ foreach name=activityList item=a from=$activity ~]
					 <li class='[~ cycle values="odd,even" name="rowBackground" ~]'>
						<span>[~ $a.eventDate|time_since ~]</span>
						[~ $a.comment|truncate_tagsafe:120 ~]
					 </li>
					[~ /foreach ~]
				</ul>
		[~/if~]
			
		</div>
		
	</div>
	
	<div id='infoPanel'>
		
		<!-- Display Side Info Panel -->
		
		<div class='note'>
			We want your feedback! Tell us what you think and we'll make it happen.
			<a href='/app/feedback.php'>Give Feedback</a>
		</div>
		
		[~if $user.perms.all_objects~]
			[~if $topClients~]
			<h2>Top Clients</h2>
			<table>
			  [~ foreach name=topClients item=tc from=$topClients ~]
				<tr>
				<td class='tdLeft'><a href='/app/clientView.php?id=[~$tc.clientID~]'>[~$tc.client|truncate:20:'...':true~]</a></td>
				<td class='tdRight'>[~$tc.tasks~] tasks</td>
				</tr>
			  [~/foreach~]
			</table>
			[~/if~]
		[~/if~]
		
		<h2>Quick Links</h2>
		
		<ul>
		[~if $user.perms.manage_clients~]
		 <li>
			<img align='absmiddle' src='/app/media/images/icons/clientsSmall.gif' width='16' />
			<a href='/app/clientNew.php'>Create a New Client</a>
		 </li>
		[~/if~]
		
		[~if $user.perms.create_projects~]
		 <li>
			<img align='absmiddle' src='/app/media/images/icons/projectsSmall.gif' width='16' />
			<a href='/app/projectNew.php'>Start a New Project</a>
		 </li>
		[~/if~]
		
		[~if $user.perms.make_requests~]
		 <li>
			<img align='absmiddle' src='/app/media/images/icons/requestsSmall.gif' width='16' />
			<a href='/app/requestNew.php'>Make a New Request</a>
		 </li>
		[~/if~]
		
		[~if $user.perms.create_tasks~]
		<li>
			<img align='absmiddle' src='/app/media/images/icons/tasksSmall.gif' width='16' />
			<a href='/app/taskNew.php'>Add a New Task</a></li>
		[~/if~]
		
		<li>
			<img align='absmiddle' src='/app/media/images/icons/screenshotSmall.gif' width='16' />
			<a href='/app/screenshotNew.php'>Upload a Screenshot</a></li>
		<li>
			<img align='absmiddle' src='/app/media/images/icons/documentsSmall.gif' width='16' />
			<a href='/app/documentNew.php'>Submit a Document</a></li>
		</ul>
	
	</div>
	
	<div class='clear'></div>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
