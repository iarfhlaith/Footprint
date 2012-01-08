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
	<title>New Document - [~$user.organisation~] - Footprint</title>
	
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" value="no-cache, no store, must-revalidate">
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/app/css/screen.css" />
	
	<script type="text/javascript" src="/app/jscript/plugins/jQuery.js"></script>
	<script type="text/javascript" src="/app/jscript/lang.js"></script>
	<script type="text/javascript" src="/app/jscript/base.scripts.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{
		$('#name').focus();
		$('#taskRow, #newTaskRow').hide();

		$('#documentNew').submit(function ()
		{	
			runFormVisualsSync();
    	});
		
		// Load and Show All Tasks for the Project
		$('#projectSelect').change(function()
		{
			$('#filterLoad').html("<img src='/app/media/images/loaders/loading.gif' alt='Loading...' />");
			
			// Use Ajax to Populate the Select Box with Tasks
			ajaxLoad('tasks', 'id='+$('#projectSelect').val(), 'select', '#taskSelect');
		});
		
		// Allow Inline Support for a New Task
		$('#newTask').click(function()
		{
			$('#taskRow').hide();
			$('#newTaskRow').show();
			$('#newTaskDefault').attr('selected', 'selected');
			$('#newTaskInput').focus();
		});
		
		// Cancel Inline Support for a New Task
		$('#newTaskCancel').click(function()
		{
			$('#taskRow').show();
			$('#newTaskRow').hide();
			$('#newTaskDefault').attr('selected', 'selected');
			$('#taskSelect').focus();
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

	<h1 id='headerDocument'>New Document</h1>
	
	[~ validate id='name'  	  message=$text.name     append='error' ~]
	[~ validate id='project'  message=$text.project  append='error' ~]
	[~ validate id='task' 	  message=$text.task   	 append='error' ~]
	[~ validate id='file'     message=$text.file 	 append='error' ~]
	[~ validate id='fileSize' message=$text.fileSize append='error' ~]
	[~ validate id='access'   message=$text.access 	 append='error' ~]
	
	[~if $error~]
		<div class='warning'>
		  <ul>
			[~foreach from=$error item="val"~]<li>[~$val~]</li>[~/foreach~]
		  </ul>
		</div>
	[~/if~]

	[~if $limitExceeded && $user.perms.all_objects~]
		<div class='notice pointer'>
			<h2>Time for an Upgrade</h2>
			<p>Wow, you've been busy! You've used up all your allocated storage space on your account. You'll need to
			   upgrade your account before you can add any more documents or screenshots.</p>
			<ul><li><a href='/app/upgrade.php'>Upgrade your Account</a></li></ul>
		</div>

	[~elseif $limitExceeded~]
		<div class='notice pointer'>
			<h2>No More Space Available</h2>
			<p>The account limit for document storage has been reached. Please contact the account owner and ask them
			   to increase their storage capacity on the system.</p>
		</div>
		
	[~elseif $projects~]
	<form name='documentNew' id='documentNew' action='documentNew.php' method='post' enctype='multipart/form-data'>
	<input type="hidden" name="MAX_FILE_SIZE" value="15728640" /> <!-- 15MB -->
	<table class='formTable'>
	<tr>
	 <td><label for='name'>Document Name</label></td>
	 <td colspan='2'><input name='name' id='name' value='[~$name~]' /> <span class='required'>*</span></td>
	</tr>
	<tr>
	 <td><label for='file'>Choose File</label></td>
	 <td><input type='file' size='41' name='file'></td>
	 <td><div class='formTip'>Browse your own local computer's files and select the document you wish to upload.</div></td>
	</tr>
	[~if $user.perms.manage_doc_access~]
	<tr>
	 <td><label for='access'>Client Access</label></td>
	 <td>
	 	<div class='multiCheck_2'>
		 <label><input type="radio" name="access" class='radio' value="0" /> None</label>
		 <label><input type="radio" name="access" class='radio' value="1" checked='checked' /> Read Only</label>
		 <label><input type="radio" name="access" class='radio' value="2" /> Full Access</label>
		</div>
	 </td><td></td>
	</tr>
	[~else~]
		<input type='hidden' name='access' value='2' />
	[~/if~]
	<tr>
	 <td><label for='project'>Project</label></td>
	 <td>
	 	<select name='project' id='projectSelect'>
			<option value=''>Please Select...</option>
			[~ html_options options=$projects selected=$project ~]
	 	</select>
		<span class='required'>*</span>
		<span id='filterLoad'>
			<img src='/app/media/images/loaders/clearDot.gif' width='16' height='16' />
		</span></td>
	 <td><div class='formTip'>Select the relevant project.</div></td>
	</tr>
	<tr id='taskRow'>
	 <td><label for='task'>Task</label></td>
	 <td>
	 	<select name='task' id='taskSelect'>
	 		<option value='' id='newTaskDefault'>Please Select...</option>
		</select> <span class='required'>*</span>
		[~if $user.perms.create_tasks~]
			<br />
			<span class='smallText'><a id='newTask' class='aLink'>New Task</a></span>
		[~/if~]
		</td>
	 <td><div class='formTip'>Select the relevent task within the project.</div></td>
	</tr>
	[~if $user.perms.create_tasks~]
	<tr id='newTaskRow'>
	 <td><label for='task'>New Task</label></td>
	 <td>
	 	<input name='newTaskName' id='newTaskInput' value='' />
		<span class='required'>*</span>
	 	<br />
		<span class='smallText'><a id='newTaskCancel' class='aLink'>Cancel</a></span></td>
	 <td><div class='formTip'>Enter a short title/name for your new task.</div></td>
	</tr>
	[~/if~]
	</table>
	
	<div class='submit'>
		<input type='submit' id='submit' name='submit' value='Save Document' />
		<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
		or <a href='/app/documents.php'>cancel</a>
	</div>
	
	<div class='smallPrint'>
		Fields marked with a <strong>*</strong> are required.
	</div>
	
	</form>
	
	[~else~]
	
		<div class='notice pointer'>
			<h2>Wait, a project and a task must exist before you can add a document.</h2>
			<p>
				Documents need to be stored somewhere so they can be kept track of. So, a project and a task
				must be created first before you can add your first document.
			</p>
			
			[~if $user.perms.create_projects~]
			<div class='noticeButton'>
				<a href='/app/projectNew.php'>
				<img src='/app/media/images/buttons/projectNew.gif' alt='Create New Project' />
				</a>
			</div>
			[~/if~]

		</div>
		
		<div class='formPreview'>
			<img src='/app/media/images/firstView/documentNew.gif' alt='Preview of the New Document form' id='firstViewPreview' />
		</div>
	
	[~/if~]


</div>

[~include file='inc.end.tpl'~]

</body>
</html>
