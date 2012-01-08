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
	<title>New Task - [~$user.organisation~] - Footprint</title>
	
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
		
		$('#taskNew').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('taskNew', formVars);
			
			return(false);
			
    	});
  	});
	
	</script>
	
	<style type="text/css">
		[~include file='inc.css.tpl'~]
	</style>
	
</head>

<body>
<a name='top'></a>
[~include file='inc.nav.tpl'~]

<div id='content'>

	<h1 id='headerTask'>New Task</h1>
	
	[~if $projects~]
	
		<div id='jNotice'></div>
			
		[~ validate id='task'  		message=$text.task     append='error' ~]
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
		
		<form name='taskNew' id='taskNew' action='/app/taskNew.php' method='post'>
		<table class='formTable'>
		<tr>
		 <td><label for='task'>Task</label></td>
		 <td><input name='task' value='[~$task~]' id='task' /> <span class='required'>*</span></td>
		 <td><div class='formTip'>Enter a short title/name for your task</div></td>
		</tr>
		<tr>
		 <td colspan='2'>
			<label for='description' class='textarea'>Description <span class='subtle'>(optional)</span></label>
			<textarea name='description'>[~$description~]</textarea>
		 </td>
		 <td><div class='formTip'>Use this to give as much information as possible. Remember that comments made at any time once the task has been created.</div></td>
		</tr>
		<tr>
		 <td><label for='project'>Project</label></td>
		 <td><select name='project'>
		 		<option value=''>Please Select...</option>
				[~ html_options options=$projects|truncate:28 selected=$project ~]
			</select> <span class='required'>*</span></td>
		 <td><div class='formTip'>Attach the task to an existing project</div></td>
		</tr>
		
		[~if $managers[1]~]
		<tr>
		 <td><label for='manager'>Assigned To</label></td>
		 <td colspan='2'>
		 	<select name='manager'>
				[~ html_options options=$managers|truncate:28 selected=$manager ~]
			</select></td>
		</tr>
		[~/if~]
		
		<tr>
		 <td><label for='status'>Status</label></td>
		 <td colspan='2'>
			<select name='status'>
			  <option [~if $status == 'N/A'~]		  selected='selected'[~/if~]>N/A</option>
			  <option [~if $status == 'Draft'~]		  selected='selected'[~/if~] class='draft'>Draft</option>
			  <option [~if $status == 'In Progress'~] selected='selected'[~/if~] class='inProgress'>In Progress</option>
			  <option [~if $status == 'On Hold'~]	  selected='selected'[~/if~] class='onHold'>On Hold</option>
			  <option [~if $status == 'Abanoned'~]    selected='selected'[~/if~] class='abandoned'>Abandoned</option>
			  <option [~if $status == 'Completed'~]   selected='selected'[~/if~] class='completed'>Completed</option>
			</select> <span class='subtle'>(optional)</span></td>
		</tr>
		</table>
		
		<div class='submit'>
			<input type='submit' id='submit' name='submit' value='Save Task' />
			<img src='/app/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
			or <a href='/app/tasks.php'>cancel</a>
		</div>
		
		<div class='smallPrint'>
			Fields marked with a <strong>*</strong> are required.
		</div>
		
		</form>
	
	[~elseif $user.groupName == 'Staff'~]
	
		<div class='notice bad'>
			<h2>Cannot create a task yet.</h2>
			<p>
				There must be a project assigned to you before you can start creating tasks. When a project is assigned
				to you, revisit this section and you can start adding as many tasks as you need.
			</p>
		</div>
	
	[~else~]
	
		<div class='notice pointer'>
			<h2>Steady on, you need to add your first project before you can create a task</h2>
			<p>
				You should create your first project before creating a task. Each task needs to be attached to a project
				when it's created.
			</p>
			
			<div class='noticeButton'>
				<a href='/app/projectNew.php'>
				<img src='/app/media/images/buttons/projectNew.gif' alt='Create New Project' />
				</a>
			</div>

		</div>
		
		<div class='formPreview'>
			<img src='/app/media/images/firstView/taskNew.gif' alt='Preview of the New Task form' id='firstViewPreview' />
		</div>
	
	[~/if~]

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
