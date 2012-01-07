<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>View Task - [~$user.organisation~] - Footprint</title>
	
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" value="no-cache, no store, must-revalidate">
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/app/css/screen.css" />
	
	<script type="text/javascript" src="/app/jscript/plugins/jQuery.js"></script>
	<script type="text/javascript" src="/app/jscript/fp.behaviour.js"></script>
	<script type="text/javascript" src="/app/jscript/lang.js"></script>
	<script type="text/javascript" src="/app/jscript/base.scripts.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{
		handleMessages();
		handleCommentDeletion();

		$('#commentNewForm').hide();
		$('#commentNewButton').click(function()
		{
			$('#commentNewButton').hide();
			$('#commentNewForm').show();
			$('#comment').focus();
			
			return(false);
		});
		
		$('#commentNew').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('taskView', formVars);
			
			return(false);
    	});
		
		$('#cancel').click(function()
		{
			$('#comment').val('');
			$('#commentNewForm').hide();
			$('#commentNewButton').show();
			return(false);
		});
		
  	});
	
	</script>
	
	<style type="text/css">
		[~include file='inc.css.tpl'~]
		
		[~if !$imgs && !$docs~]
			#comment {width:740px;}
			#taskComments {width:100%;float:none;}
		[~/if~]
		
	</style>
	
</head>

<body>

[~include file='inc.nav.tpl'~]

<div id='content'>

	<div id='taskSummary'>
		<ul>
		 <li>Task No. 	 <strong>#[~$task.taskID~]</strong></li>
		 <li>Project: 	 <strong>[~$task.name~]</strong></li>
		 <li>Client: 	 <strong>[~$task.clientOrganisation~]</strong></li>
		 <li>Created By: <strong>[~$task.firstname~] [~$task.lastname~]</strong></li>
		 <li>Created On: <strong>[~$task.createdOn|date_format~]</strong></li>
		</ul>
		
		<div id='taskStatus'>
			Status:	 <span class='[~$task.status|lower~]'>[~$task.status~]</span>
		</div>

		[~if $user.perms.manage_tasks~]
		<p>
			<a href='/app/taskEdit.php?id=[~$task.taskID~]'>
				<img src='/app/media/images/buttons/editSmall.gif' alt='edit' />
			</a>
		</p>
		[~/if~]
		
	</div>
	
	<h1 id='headerTask'>[~$task.title~]</h1>
	<p id='taskIntro'>[~$task.description|nl2br~]</p>
	
	<div class='clear'></div>
	
	<div id='taskComments'>
		
		[~if $message~][~include file='inc.msg.tpl'~][~/if~]
		
		<div class='commentNew'>
		
			<div class='button'>
			<a href='#' id='commentNewButton' name='commentNewButton'>
				<img src='/app/media/images/buttons/newCommentSmall.gif' alt='New Comment' />
			</a>
			</div>
			
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
			
			<form name='commentNew' id='commentNew' action='/app/taskView.php' method='post'>
			<input type='hidden' name='id' value='[~$task.taskID~]'>
			<div class='formTable' id='commentNewForm'>
				<label for='comment' class='textarea'>New Comment</label>
				<textarea name='comment' id='comment'>[~$comment~]</textarea>
				<div class='commentAddNotification'>
					<input type='checkbox' name='notify' checked='checked' class='checkbox' value='1'/> Notify the Team
				</div>
			 	<div class='commentSubmit'>
					<input type='submit' id='submit' name='submit' value='Save Comment' />
					<img src='/app/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
					or <a href='#' id='cancel'>Cancel</a>
				</div>
			</div>
			</form>

		</div>
		
		[~if $task.comments~]
			<h3 id='commentHeader'>Comments</h3>
		    [~ foreach name=commentList item=c from=$task.comments ~]
				<div id='comment[~$c.id~]'>
					<div class='commentTitle'>
						<div>Posted [~$c.dateCreated|time_since~]</div>
						<h4>[~$c.firstname~] [~$c.lastname~]</h4>
					</div>
					<div class='commentText'>
						<p>[~$c.comment|nl2br~]</p>
						<div class='commentToolbar' id='commentToolbar[~$c.id~]'>
						 [~if $user.userID == $c.author~]
							 <a href='/app/commentEdit.php?id=[~$c.id~]&source=/app/taskView.php&sourceid=[~$task.taskID~]'>edit</a>
							 <a href='#' id='[~$c.id~]' class='delete'>delete</a>
						[~/if~]
						</div>
					</div>
				</div>
			[~/foreach~]
		[~/if~]
		
	</div>
	
	[~if $imgs || $docs~]
	
	<div id='taskObjects'>
	
		[~if $imgs~]
			<h3 id='screenshotHeader'>Screenshots</h3>
			[~ foreach name=imgList item=i from=$imgs ~]
			<div class='screenshotPreview'>
				<div>
					<a href='/app/screenshotView.php?id=[~$i.screenshotID~]'>
					<img src='http://screenshots.footprinthq.com/[~$i.key~]?[~$i.auth~]' alt='' />
					</a>
					<div class='clear'></div>
				</div>
				<ul>
					<li><strong>[~$i.imgTitle~]</strong></li>
					<li>
						[~if $i.comments == 0 ~]
							No Comments
						[~elseif $i.comments == 1~]
							[~$i.comments~] Comment
						[~else~]
							[~$i.comments~] Comments
						[~/if~]
					</li>
					<li>
						<a href='/app/screenshotView.php?id=[~$i.screenshotID~]'>view</a> |
						<a href='/app/screenshotUpdate.php?id=[~$i.screenshotID~]'>edit</a> |
						<a href='#'>delete</a>
					</li>
				</ul>
				<br /><div class='clear'></div><br />
			</div>
			<div class='clear'></div>
			[~/foreach~]
		[~/if~]
		
		<div class='clear'></div>
		
		[~if $docs~]
			<h3 id='documentHeader'>Documents</h3>
			[~ foreach name=docList item=d from=$docs ~]
			<div class='document'>
				<div class='documentLink'>
			  		<a href='/app/documentView.php?id=[~$d.versionID~]' class='docType [~$d.docType|default:unknown~]'>[~$d.docTitle|truncate:25~]</a>
				</div>
				<div class='documentMeta'>
					[~$d.size|filesize_format~] - Added [~$d.lastAccessed|date_format~]
				</div>
			</div>
			[~ /foreach ~]
		[~/if~]
		
	</div>
	
	[~/if~]
	
	<div class='clear'></div>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
