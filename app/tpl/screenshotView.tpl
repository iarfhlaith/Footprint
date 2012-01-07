<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>View Screenshot - [~$user.organisation~] - Footprint</title>
	
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" value="no-cache, no store, must-revalidate">
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/app/css/screen.css" />
	<link rel="stylesheet" type="text/css" href="/app/css/facebox.css" />
	
	<script type="text/javascript" src="/app/jscript/plugins/jQuery.js"></script>
	<script type="text/javascript" src="/app/jscript/plugins/jQuery.query.js"></script>
	<script type="text/javascript" src="/app/jscript/plugins/jQuery.facebox.js"></script>
	<script type="text/javascript" src="/app/jscript/fp.behaviour.js"></script>
	<script type="text/javascript" src="/app/jscript/lang.js"></script>
	<script type="text/javascript" src="/app/jscript/base.scripts.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{
		var xy = $.query.get('xy');
		
		handleMessages();
		handleCommentDeletion();
		
		$('a[@rel*=facebox]').facebox();
		
		$('#commentNew').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('screenshotView', formVars);
			
			return(false);
    	});
		
		$('#commentNewButton').click(function()
		{
			$('#commentNewButton').hide();
			$('.commentNew').show();
			$('#comment').focus();
			
			return(false);
		});
		
		$('#cancel').click(function()
		{
			$('#comment').val('');
			$('.commentNew').hide();
			$('#commentNewButton').show();
			return(false);
		});
		
		if (xy)
		{
			$('#commentNewButton').hide();
			$('.commentNew').show();
			$('#comment').focus();
		}
		else 
		{
			$('.commentNew').hide();
		}
  	});
	
	</script>
	
	<style type="text/css">
		[~include file='inc.css.tpl'~]
	</style>
	
</head>

<body>

[~include file='inc.nav.tpl'~]

<div id='content'>

	[~if $user.perms.all_objects || $user.perms.assigned_objects || $screenshot.clientAccess > 1 ~]
	<div class='appButton'>
		<span title='Update Now'>
		 <a href='/app/screenshotUpdate.php?id=[~$screenshot.screenshotID~]'>
		 <img src='/app/media/images/buttons/updateNow.gif' alt='Update Now' />
		 </a>
		</span>
	</div>
	[~/if~]

	<h1 id='headerScreenshot'>New Homepage</h1>
	
	<div id='screenshotMain'>
		
		<div class='screenshotImageMedium'>
			<span title='View Original Size'>
				<a rel='facebox' href='/app/screenshotShow.php?id=[~$screenshot.versionID~]'>
					<img src='http://screenshots.footprinthq.com/[~$screenshot.key~]?[~$screenshot.auth~]' alt='' />
				</a>
			</span>
		</div>
		
		<div class='dataSummary'>
		<table width='100%'>
		<tr>
		 <td width='20'><span title='Client'><img src='/app/media/images/icons/clientsSmall.gif' alt='' /></span></td>
		 <td><a href='/app/ClientView.php?id=[~$screenshot.clientID~]'>[~$screenshot.clientOrganisation~]</a></td>
		</tr>
		<tr>
		 <td><span title='Project'><img src='/app/media/images/icons/projectsSmall.gif' alt='' /></span></td>
		 <td><a href='/app/projectView.php?id=[~$screenshot.projID~]'>[~$screenshot.project~]</a></td>
		</tr>
		<tr>
		 <td><span title='Task'><img src='/app/media/images/icons/tasksSmall.gif' alt='' /></span></td>
		 <td><a href='/app/taskView.php?id=[~$screenshot.taskID~]'>[~$screenshot.task~]</a></td>
		</tr>
		<tr>
		 <td colspan='2'>
		 	Version: [~$screenshot.version|commify:1~]
			<br /><br />
			Last Updated: [~$screenshot.dateCreated|time_since~]
			<br /><br />
			Dimensions: [~$screenshot.dimensions~] pixels
			<br /><br />
			Size of File: [~$screenshot.size|filesize_format~]
		 </td>
		</tr>
		</table>
		</div>
		
		<div class='clear'></div>
		
	</div>
	
	[~if $screenshot.description~]
		<p class='screenshotDescription'>[~$screenshot.description|nl2br~]</p>
	[~/if~]
	
	[~if $screenshot.version > 1~]
		<h3>All Versions</h3>
		<div class='screenshotVersions'>
			[~ foreach name=versions item=v from=$screenshot.versions ~]
			<div>
				<span title='Version [~$v.version|commify:1~]'>
				<a rel='facebox' href='/app/screenshotShow.php?id=[~$v.id~]'>
				  <img src='http://screenshots.footprinthq.com/[~$v.key~]?[~$v.auth~]' alt='' />
				</a>
				</span>
			</div>
			[~/foreach~]
		</div>
	[~/if~]
	
	<div class='comments'>
		
		[~if $message~][~include file='inc.msg.tpl'~][~/if~]
		
		<div class='button'>
		<br />
		<a href='#' id='commentNewButton' name='commentNewButton'>
			<img src='/app/media/images/buttons/newCommentSmall.gif' alt='New Comment' />
		</a>
		</div>
		
		<div class='commentNew'>
		
			<div id='jNotice'></div>
			[~ validate id='comment' message=$text.comment append='error' ~]
			
			[~if $error~]
				<div class='warning'>
				[~if $error.message~]
					<h3>$error.message</h3>
				[~/if~]
				  <ul>
					[~foreach from=$error item="val"~]<li>[~$val~]</li>[~/foreach~]
				  </ul>
				</div>
			[~/if~]
			
			<form name='commentNew' id='commentNew' action='/app/screenshotView.php' method='post'>
			<input type='hidden' name='id' value='[~$screenshot.screenshotID~]'>
			<div class='formTable' id='commentNewForm'>
				<label for='comment' class='textarea'>New Comment</label>
				<textarea name='comment' id='comment' style='width:740px;'>[~$comment~]</textarea>
				<div class='commentAddNotification'>
					<input type='checkbox' name='notify' checked='checked' class='checkbox'/> Notify the Team
				</div>
			 	<div class='commentSubmit'>
					<input type='submit' id='submit' name='submit' value='Save Comment' />
					<img src='/app/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
					or <a href='#' id='cancel'>Cancel</a>
				</div>
			</div>
			</form>

		</div>
		
		[~if $screenshot.comments~]
		
			<h3 id='commentHeader'>Comments</h3>
	
			[~ foreach name=commentList item=c from=$screenshot.comments ~]
			
			<div id='comment[~$c.id~]'>
				<div class='commentTitle'>
					<div>Posted [~$c.dateCreated|time_since~]</div>
					<h4>[~$c.firstname~] [~$c.lastname~]</h4>
				</div>
				
				<div class='commentText'>
					<p>[~$c.comment|nl2br~]</p>
					<div class='commentToolbar' id='commentToolbar[~$c.id~]'>
					 <a href='/app/commentEdit.php?id=[~$c.id~]&source=/app/screenshotView.php&sourceid=[~$screenshot.screenshotID~]'>edit</a>
					 <a href='#' id='[~$c.id~]' class='delete'>delete</a>
					</div>
				</div>
			</div>
			
			[~/foreach~]
		[~/if~]
		
	</div>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
