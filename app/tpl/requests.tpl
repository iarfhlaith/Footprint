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
	<title>Requests - [~$user.organisation~] - Footprint</title>
	
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
		handleConversions();
		handleRejections();
		
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
	
	[~if $user.perms.make_requests~]
	<div class='appButton'>
		<span title='Create New Request'>
		 <a href='/app/requestNew.php'>
		 <img src='/app/media/images/buttons/requestNew.gif' alt='Create New Request' />
		 </a>
		</span>
	</div>
	[~/if~]

	[~if $clients~]
	<div class='dataFilter'>
		<form id='filter'>
		<label for='id'>Display for:</label>
		<select name='id' id='client'>
		<option>All Clients</option>
		[~ html_options options=$clients|truncate:28 selected=$client ~]
		</select>
		<span id='filterLoad'>
			<img src='/app/media/images/loaders/clearDot.gif' width='16' height='16' />
		</span>
		</form>
	</div>
	[~/if~]
	
	<div class='appButton'>
		 <img src='/app/media/images/nav/strip.gif' height='33' width='137' alt='' />
	</div>
	
	<h1 id='headerRequest'>Requests</h1>
	
	[~if $requests~]
	
		[~if $message~][~include file='inc.msg.tpl'~][~/if~]
	
		[~if $user.perms.manage_requests~]
		<div class='dataButtons'>
			<ul>
			 <li><a href='#' id='delete'>Delete</a></li>
			 <li><a href='#' id='reject'>Reject</a></li>
			 <li><a href='#' id='convert'>Convert to Task</a></li>
			</ul>
			<div class='clear'></div>
		</div>
		
		<form id='requests' action='requests.php' method='post'>
		<input type='hidden' name='action' id='action' value=''>
		[~/if~]

		<table class='dataListing'>
		<thead>
		 <tr>
		  <td width='3%'>&nbsp;</td>
		  <td width='32%'>Request</td>
		  <td width='28%'>
			[~*if $user.perms.all_objects || $user.perms.assigned_objects~]
				Client
			[~else*~]
				Description
			[~*/if*~]
		  </td>
		  <td width='19%'>Project</td>
		  <td width='12%'>Date</td>
		  <td width='6%'>&nbsp;</td>
		 </tr>
		</thead>
		<tbody>
		 [~ foreach name=requestList item=r from=$requests ~]
		 <tr class='[~ cycle values="odd,even" name="rowBackground" ~]'>
		  <td>
			[~if $user.perms.manage_requests~]
				<input type='checkbox' name='request[[~$r.requestID~]]' value='' class='reqCheck' />
			[~else~]
				[~if $r.status == 'Rejected'~]<img src='/app/media/images/icons/redSmall.gif' alt='Rejected' />
				[~else~]<img src='/app/media/images/icons/greenSmall.gif' alt='New' />[~/if~]
			[~/if~]	
		  </td>
		  <td><a href='/app/requestView.php?id=[~$r.requestID~]'>[~$r.title|truncate:30~]</a></td>
		  <td>
			[~*if $user.perms.all_objects || $user.perms.assigned_objects~]
				<a href='/app/clientView.php?id=[~ $r.userID ~]'>[~ $r.clientOrganisation ~]</a>
			[~else*~]
				[~ $r.description|truncate:30 ~]
			[~*/if*~]
		  </td>
		  <td><a href='/app/projectView.php?id=[~$r.projID~]'>[~$r.name|truncate:20~]</a></td>
		  <td>[~$r.createdOn|date_format~]</td>
		  <td class='last'>
			[~if $user.perms.make_requests~]
				<a href='/app/requestEdit.php?id=[~$r.requestID~]'>edit</a> &raquo;
			[~else~]
				[~if $r.status == 'Replied'~]<img src='/app/media/images/icons/yellowSmall.gif' alt='Replied' />
				[~elseif $r.status == 'Rejected'~]<img src='/app/media/images/icons/redSmall.gif' alt='Rejected' />
				[~else~]<img src='/app/media/images/icons/greenSmall.gif' alt='New' />[~/if~]
			[~/if~]
		  </td>
		 </tr>
		 [~ /foreach ~]
		</tbody>
		</table>

		[~if $user.perms.manage_tasks~]</form>[~/if~]
		
		<div class='legend'>
		<table>
			<tr><td><img src='/app/media/images/icons/greenSmall.gif' 	align='absmiddle' /></td>	<td>New</td>
			    <td><img src='/app/media/images/icons/redSmall.gif' 	align='absmiddle' /></td>	<td>Rejected</td></tr>
		</table>
		</div>
			
		<div class='pagination'>
			[~include file='inc.pag.tpl'~]
		</div>
		
	[~elseif $user.groupName == 'Client'~]
	
		<div class='notice prompt'>
			<h2>Add your first request</h2>
			<p>
				If you want to make a request for a new piece of work, this is the place to do it. Your new request will
				be reviewed, and when accepted, it will be listed as a task under the the assigned project.
			</p>
			<p class='smallPrint'>
				This prompt will disappear when you add your first request.
			</p>
		</div>
		
		<div>
			<img src='/app/media/images/firstView/requests.png' alt='' />
		</div>
	
	[~else~]
	
		<div class='notice good'>
		<h2>No Client Requests at the moment</h2>
		<p>
			When the client makes a request you'll be notified by email and RSS and the details of
			the request will be available here.
		</p>
		[~if $user.perms.manage_requests~]
		<p>
			Reviewing a request is easy, simply have a read of it and either upgrade it to a task or decline it,
			and optionally give a reason to the client as to why. It's really
			useful for keeping track of change requests for all your different projects.
		</p>
		[~/if~]
		<ul>
			<li><a href='/app/tasks.php'>View all Tasks</a></li>
		</ul>
		</div>
	
	[~/if~]

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
