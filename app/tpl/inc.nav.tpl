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
[~config_load file=config.cfg~]

[~if $IN_BETA~]
<div id='feedbackLine'>
	Footprint is now an <strong>open source project</strong> <a target='_blank' href='https://github.com/iarfhlaith/Footprint'>hosted on Github</a>. 
	Like what we're doing? Send us <a href='/app/feedback.php'>feedback</a> or
	<a target='_blank' href='https://github.com/iarfhlaith/Footprint'>get involved</a>.
</div>
[~/if~]

<div id='nav'>
	
	<div class='container'>
	
		<ol>
		 <li><a href='/app/settings1.php'>Settings</a></li>
		 <li><a href='/forums' target='_blank'>Forums</a></li>
		 <li><a href='/help' target='_blank'>Help</a></li>
		 <li><a href='/app/logout.php'>Logout</a></li>
		</ol>
		
		<div id='subNav'>
		
			<div id='sysLogo'>
			  [~ if $user.perms.manage_colours_logos ~]<a href='/app/settingsLogo.php'>[~/if~]
				<img src='/app/inc/viewLogo.php' alt='[~ $user.organisation ~]' width='170' height='60' />
			  [~ if $user.perms.manage_colours_logos ~]</a>[~/if~]
			</div>
			
			<ul>
			 <li>[~ if $belowHome ~]<strong>[~/if~]<a href='/app/'>Home</a>[~ if $belowHome ~]</strong>[~/if~]</li>
			 
			 [~ if $user.perms.staff ~]
			   <li>[~if $belowStaff~]<strong>[~/if~]<a href='/app/staff.php'>Staff</a>[~if $belowStaff~]</strong>[~/if~]</li>
			 [~/if~]
			 
			 [~ if $user.perms.all_objects || $user.perms.assigned_objects ~]
			   <li>[~if $belowClients~]<strong>[~/if~]<a href='/app/clients.php'>Clients</a>[~if $belowClients~]</strong>[~/if~]</li>
			 [~/if~]
			 
			 <li>[~if $belowProjects~]<strong>[~/if~]<a href='/app/projects.php'>Projects</a>[~if $belowProjects~]</strong>[~/if~]</li>			 
			 <li>[~if $belowTasks~]<strong>[~/if~]<a href='/app/tasks.php'>Tasks</a>[~if $belowTasks~]</strong>[~/if~]</li>
			 <li>[~if $belowScreenshots~]<strong>[~/if~]<a href='/app/screenshots.php'>Screenshots</a>[~if $belowScreenshots~]</strong>[~/if~]</li>
			 <li>[~if $belowDocuments~]<strong>[~/if~]<a href='/app/documents.php'>Documents</a>[~if $belowDocuments~]</strong>[~/if~]</li>
			</ul>
		
		</div>
		
		<div class='clear'></div>
	
	</div>

</div>

<div id='nav2'>

	<div class='container'>
	
	<ul>
	
	 [~if $belowHome~]
	 
		 [~if $user.perms.manage_account~]
			<li>[~if $page.dashboard~]<strong>[~/if~]<a href='/app/'>Dashboard</a>[~if $page.dashboard~]</strong>[~/if~]</li>
			<li>[~if $page.accInfo~]<strong>[~/if~]<a href='/app/accInfo.php'>Account Info</a>[~if $page.accInfo~]</strong>[~/if~]</li>
			
			[~*
			<li>[~if $page.upgrade~]<strong>[~/if~]<a href='/app/upgrade.php'>Upgrade Your System</a>[~if $page.upgrade~]</strong>[~/if~]</li>
			*~]
			
			[~if $user.perms.activity_feed~]
				<li>[~if $page.rssIntro ~]<strong>[~/if~]<a href='/app/rssIntro.php'>Subscribe</a>[~if $page.rssIntro~]</strong>[~/if~]</li>
			[~/if~]
			
		 [~else~]
		 	<li><a href='#'>&nbsp;</a></li>
		 [~/if~]
		
	 [~elseif $belowStaff~]
	 
	 	 [~ if $user.perms.staff ~]
	 		<li>[~if $page.staff~]<strong>[~/if~]<a href='/app/staff.php'>Staff</a>[~if $page.staff~]</strong>[~/if~]</li>
	 		<li>[~if $page.staffNew~]<strong>[~/if~]<a href='/app/staffNew.php'>Add New Staff</a>[~if $page.staffNew~]</strong>[~/if~]</li>
		 [~else~]
		 	<li><a href='#'>&nbsp;</a></li>
		 [~/if~]
		 
	 [~elseif $belowClients~]	 
	 
		 [~if $user.perms.manage_clients~]
			<li>[~if $page.clients~]<strong>[~/if~]<a href='/app/clients.php'>Clients</a>[~if $page.clients~]</strong>[~/if~]</li>
			<li>[~if $page.clientNew~]<strong>[~/if~]<a href='/app/clientNew.php'>New Client</a>[~if $page.clientNew~]</strong>[~/if~]</li>
			<li>[~if $page.clientImport~]<strong>[~/if~]<a href='/app/clientImport.php'>Import Clients</a>[~if $page.clientImport~]</strong>[~/if~]</li>
		 [~else~]
		 	<li><a href='#'>&nbsp;</a></li>		
		 [~/if~]
	 	 
	 [~elseif $belowProjects~]
	 
	 	<li>[~if $page.projects~]<strong>[~/if~]<a href='/app/projects.php'>Projects</a>[~if $page.projects~]</strong>[~/if~]</li>
	 
	 	 [~if $user.perms.create_projects~]	 		
	 		<li>[~if $page.projectNew~]<strong>[~/if~]<a href='/app/projectNew.php'>New Project</a>[~if $page.projectNew~]</strong>[~/if~]</li>
		 [~else~]
		 	<li><a href='#'>&nbsp;</a></li>		
		 [~/if~]
	 
	 [~elseif $belowTasks~]
	 
	 	<li>[~if $page.tasks~]<strong>[~/if~]<a href='/app/tasks.php'>Tasks</a>[~if $page.tasks~]</strong>[~/if~]</li>
		
		[~if $user.perms.create_tasks~]
	 		<li>[~if $page.taskNew~]<strong>[~/if~]<a href='/app/taskNew.php'>New Task</a>[~if $page.taskNew~]</strong>[~/if~]</li>
		[~/if~]
		
	 	<li>[~if $page.requests~]<strong>[~/if~]<a href='/app/requests.php'>Requests</a>[~if $page.requests~]</strong>[~/if~]</li>
	 	
		[~if $user.perms.make_requests~]
	 		<li>[~if $page.requestNew~]<strong>[~/if~]<a href='/app/requestNew.php'>New Request</a>[~if $page.requestNew~]</strong>[~/if~]</li>
		[~/if~]
	 
	 [~elseif $belowScreenshots~]
	 <li>[~if $page.screenshots~]<strong>[~/if~]<a href='/app/screenshots.php'>Screenshots</a>[~if $page.screenshots~]</strong>[~/if~]</li>
	 <li>[~if $page.screenshotNew~]<strong>[~/if~]<a href='/app/screenshotNew.php'>New Screenshot</a>[~if $page.screenshotNew~]</strong>[~/if~]</li>
	 
	 [~elseif $belowDocuments~]
	 <li>[~if $page.documents~]<strong>[~/if~]<a href='/app/documents.php'>Documents</a>[~if $page.documents~]</strong>[~/if~]</li>
	 <li>[~if $page.documentNew~]<strong>[~/if~]<a href='/app/documentNew.php'>New Document</a>[~if $page.documentNew~]</strong>[~/if~]</li>
	 
	 [~/if~]
	</ul>
	
	<div class='clear'></div>
	
	</div>

</div>