<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Edit Task - [~$user.organisation~] - Footprint</title>
	
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
		$('#task').focus();
		
		$('#taskEdit').submit(function ()
		{	
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('taskEdit', formVars);
			
			return(false);
			
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

	<h1 id='headerTask'>Edit Task</h1>
	
	<div id='jNotice'></div>
			
	[~ validate id='title' 		message=$text.title    append='error' ~]
	[~ validate id='project' 	message=$text.project  append='error' ~]
		
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
	
	<form name='taskEdit' id='taskEdit' action='/app/taskEdit.php' method='post'>
	<input name='id' value='[~$task.taskID~]' type='hidden' />
	<table class='formTable'>
	<tr>
	 <td><label for='title'>Task</label></td>
	 <td colspan='2'><input name='title' value='[~$task.title~]' /> <span class='required'>*</span></td>
	</tr>
	<tr>
	 <td colspan='3'>
	 	<label for='description' class='textarea'>Description <span class='subtle'>(optional)</span></label>
		<textarea name='description'>[~$task.description~]</textarea>
	 </td>
	</tr>
	<tr>
	 <td><label for='project'>Project</label></td>
	 <td colspan='2'>
	 		<select name='project'>
		 		<option value=''>Please Select...</option>
				[~ html_options options=$projects|truncate:28 selected=$task.project ~]
			</select> <span class='required'>*</span></td>
	</tr>
	
	[~if $managers[1]~]
		<tr>
		 <td><label for='manager'>Assigned To</label></td>
		 <td colspan='2'>
		 	<select name='manager'>
				[~ html_options options=$managers|truncate:28 selected=$task.manager ~]
			</select></td>
		</tr>
	[~/if~]
	
	<tr>
	 <td><label for='status'>Status</label></td>
	 <td colspan='2'>
		<select name='status'>
		  <option [~if $task.status == 'N/A'~]		   selected='selected'[~/if~]>N/A</option>
		  <option [~if $task.status == 'Draft'~]	   selected='selected'[~/if~] class='draft'>Draft</option>
		  <option [~if $task.status == 'In Progress'~] selected='selected'[~/if~] class='inProgress'>In Progress</option>
		  <option [~if $task.status == 'On Hold'~]	   selected='selected'[~/if~] class='onHold'>On Hold</option>
		  <option [~if $task.status == 'Abandoned'~]   selected='selected'[~/if~] class='abandoned'>Abandoned</option>
		  <option [~if $task.status == 'Completed'~]   selected='selected'[~/if~] class='completed'>Completed</option>
		</select> <span class='subtle'>(optional)</span></td>
	</tr>
	</table>
	
	<div class='submit'>
		<input type='submit' id='submit' name='submit' value='Save Changes' />
		<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
		or <a href='/app/tasks.php'>cancel</a>
	</div>
	
	<div class='smallPrint'>
		Fields marked with a <strong>*</strong> are required.
	</div>
	
	</form>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
