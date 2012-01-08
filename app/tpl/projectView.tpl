[~*
/**
 * Footprint
 *
 * A project management tool for web designers.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst. It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package Footprint
 * @author Iarfhlaith Kelly
 * @copyright Copyright (c) 2007 - 2012, Iarfhlaith Kelly. (http://iarfhlaith.com/)
 * @license http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link http://footprintapp.com
 * @since Version 1.0
 * @filesource
 */
*~]
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>View Project - [~$user.organisation~] - Footprint</title>
	
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
	
	<h1 id='headerProject'>[~ $project.name ~]</h1>
		
	<div id='projectPanel'>
	
		<ul>
		 [~if $user.perms.all_objects || $user.perms.assigned_objects~]
		 	<li><img align='absmiddle' src='/app/media/images/icons/clientsSmall.gif' /> <strong> [~ $project.clientOrganisation ~] </strong></li>
		 [~/if~]
			
		 <li>Assigned To: <strong>[~ $project.firstname ~] [~ $project.lastname ~]</strong></li>
		 <li>Created On: <strong>[~ $project.dateCreated|date_format ~]</strong></li>
		</ul>
		
		<br />
		
		<ul>
		 <li><img align='absmiddle' src='/app/media/images/icons/requestsSmall.gif' /> <a href='/app/requests.php?id=[~$project.client~]'>[~$project.totRequests~] Requests</a></li>
		 <li><img align='absmiddle' src='/app/media/images/icons/tasksSmall.gif' /> <a href='/app/tasks.php?id=[~$project.projID~]'>[~$project.totTasks~] Tasks</a></li>
		 <li><img align='absmiddle' src='/app/media/images/icons/screenshotSmall.gif' /> [~$project.totScreenshots~] Screenshots</li>
		 <li><img align='absmiddle' src='/app/media/images/icons/commentsSmall.gif' /> [~$project.totComments~] Comments</li>
		 <li><img align='absmiddle' src='/app/media/images/icons/documentsSmall.gif' /> [~$project.totDocuments~] Documents  [~if $project.totDocSize > 0~]([~$project.totDocSize|filesize_format~])[~/if~]</li>
		</ul>
		
		<br />
		
		<ul>
		 <li><img align='absmiddle' src='/app/media/images/icons/projectsSmall.gif' /> <strong><a href='/app/projectTimeline.php?pid=[~$project.projID~]'>View Project Timeline</a></strong></li>
		</ul>
		
	</div>
	
	<div id='projectInfo'>
	
		<div id='projectText'>
			<h2>Project Brief</h2>
			<p>[~$project.description|nl2br ~]</p>
			
			[~if $user.perms.all_objects || $user.perms.assigned_objects~]
			<p>
			 <a href='/app/projectEdit.php?id=[~ $project.projID ~]'>
			 	<img src='/app/media/images/buttons/editSmall.gif' alt='Edit' />
			 </a>
			</p>
			[~/if~]
		</div>
		
		<table class='projectObjects'>
		<tr>
		<td id='task'>
			<h3><a href='/app/tasks.php?id=[~$project.projID~]'>Tasks</a></h3>
			<p>
			[~if $user.perms.all_objects || $user.perms.assigned_objects~]
				Use tasks to divide the jobs of your projects into smaller more managable chunks.
			[~else~]
				Every project is broken down into smaller more manageble tasks. Take a look.
			[~/if~]
			</p>
		</td>
		<td id='request'>
			<h3><a href='/app/requests.php?id=[~$project.client~]'>Client Requests</a></h3>
			<p>
			[~if $user.perms.all_objects || $user.perms.assigned_objects~]
				When your clients shift the goal posts, here's where you'll hear about it.
			[~else~]
				Useful if you need your designer to do some extra work or to change something.
			[~/if~]
			</p>
		</td>
		</tr>
		<tr>
		<td id='document'>
			<h3><a href='/app/documents.php?id=[~$project.projID~]'>Documents</a></h3>
			<p>
			[~if $user.perms.all_objects || $user.perms.assigned_objects~]
				Store your stuff online so you can share relevant documents with your clients.
			[~else~]
				Share your documents with the designer. Active version control comes as standard.
			[~/if~]
			</p>
		</td>
		<td id='screenshot'>
			<h3><a href='/app/screenshots.php?id=[~$project.projID~]'>Screenshots</a></h3>
			<p>
			[~if $user.perms.all_objects || $user.perms.assigned_objects~]
				If you need to show your client a design or a logo, this is the place to do it.
			[~else~]
				Great for sharing designs and ideas for logos, graphics, and other image types.
			[~/if~]
			</p>
		</td>
		</tr>
		</table>
	
	</div>
	
	<div class='clear'></div>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
