<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Screenshots - [~$user.organisation~] - Footprint</title>
	
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
		handleDeletions();
		
		$('#task').change(function()
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
	
	<div class='appButton'>
		<span title='Create New ScreenShot'>
		 <a href='/app/screenshotNew.php'>
		 <img src='/app/media/images/buttons/screenshotNew.gif' alt='Create New ScreenShot' />
		 </a>
		</span>
	</div>
	
	[~if $screenshots~]
	<div class='dataFilter'>
		<form id='filter'>
		<label for='id'>Display for:</label>
		<select name='id' id='task'>
		<option>All Tasks</option>
		[~ html_options options=$tasks|truncate:28 selected=$task ~]
		</select>
		<span id='filterLoad'>
			<img src='/app/media/images/loaders/clearDot.gif' width='16' height='16' />
		</span>
		</form>
	</div>
	[~/if~]

	<h1 id='headerScreenshot'>Screenshots</h1>
	
	[~if $message~][~include file='inc.msg.tpl'~][~/if~]
	
	[~if $screenshots~]
	
		<div class='dataButtons'>
			<ul>
			 <li><a href='#' id='delete'>Delete</a></li>
			</ul>
			<div class='clear'></div>
		</div>
		<div class='clear'></div>
		
		<form id='screenshots' action='screenshots.php' method='post'>
		
		<table class='imageListing'>
		<tbody>
		<!-- Begin Loop -->
		[~ foreach name=imgList item=i from=$screenshots ~]
		
		 <tr>
		 	<td class='check'>
			[~if $user.perms.all_objects || $user.perms.assigned_objects || $i.clientAccess > 1 ~]
				<input type='checkbox' name='screenshots[[~$i.screenshotID~]]' class='docCheck' value='' />
			[~else~]
				<span title='locked'><img src='/app/media/images/icons/lockSmall.gif' alt ='locked' /></span>
			[~/if~]
			</td>
		    <td class='stuff'>
		  
			<div class='screenshotImageSmall'>
				<a href='/app/screenshotView.php?id=[~$i.screenshotID~]'>
					<img src='http://screenshots.footprinthq.com/[~$i.key~]?[~$i.auth~]' alt='' />
				</a>
			</div>
			
			<div class='screenshotTimestamp'>
				Created on: [~$i.dateCreated|date_format~]
			</div>
			
			<h3><a href='/app/screenshotView.php?id=[~$i.screenshotID~]'>[~$i.imgTitle~]</a></h3>
			
			[~if $i.imgDesc~]<p>[~$i.imgDesc|truncate:130~]</p>[~/if~]
	
			<div class='screenshotButtons'>
				<a href='/app/screenshotView.php?id=[~$i.screenshotID~]'><img src='/app/media/images/buttons/viewSmall.gif' alt='View' /></a>
				[~if $user.perms.all_objects || $user.perms.assigned_objects || $i.clientAccess > 1 ~]
				<a href='/app/screenshotUpdate.php?id=[~$i.screenshotID~]'><img src='/app/media/images/buttons/editSmall.gif' alt='Edit' /></a>
				[~/if~]
				<a href='/app/screenshotView.php?id=[~$i.screenshotID~]&xy=commentNewButton2'><img src='/app/media/images/buttons/newCommentSmall.gif' alt='New Comment' /></a>
			</div>
			
			<div class='clear'></div>
			
			<div class='screenshotToolbar'>
				<div class='screenshotParents'>
					<img align='absmiddle' src='/app/media/images/icons/clientsTiny.gif' /> 
					<a href='/app/clientView.php?id=[~$i.clientID~]'>[~$i.clientOrg~]</a>
					&nbsp;&nbsp;&nbsp;
					<img align='absmiddle' src='/app/media/images/icons/projectsTiny.gif' />
					<a href='/app/projectView.php?id=[~$i.projID~]'>[~$i.project~]</a>
					&nbsp;&nbsp;&nbsp;
					<img align='absmiddle' src='/app/media/images/icons/tasksTiny.gif' />
					<a href='/app/taskView.php?id=[~$i.taskID~]'>[~$i.title~]</a>
				</div>
				<img align='absmiddle' src='/app/media/images/icons/commentsTiny.gif' />
				[~if $i.comments == 0 ~]
					No Comments
				[~elseif $i.comments == 1~]
					[~$i.comments~] Comment
				[~else~]
					[~$i.comments~] Comments
				[~/if~]
			</div>
			
		  </td>
		 </tr>
		 
		 [~/foreach~]
		 <!-- End Loop -->
	
		</tbody>
		</table>
		
		</form>
		
		<div class='pagination'>
			[~include file='inc.pag.tpl'~]
		</div>
	
	[~else~]
	
		<div class='notice prompt'>
			<h2>Add your first screenshot</h2>
			<p>
				Add images, icons, design previews, webpage screenshots and any other relevant
				imagery that you want to work on with others within your account.
			</p>
			<p class='smallPrint'>
				This prompt will disappear when you add your first screenshot.
			</p>
		</div>
		
		<div>
			<img src='/app/media/images/firstView/screenshots.png' alt='' />
		</div>
	
	[~/if~]

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
