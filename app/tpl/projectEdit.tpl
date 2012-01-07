<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Edit Project - [~$user.organisation~] - Footprint</title>
	
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
		
		$('#projectEdit').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('projectEdit', formVars);
			
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

	<h1 id='headerProject'>Edit Project</h1>
	
	<div id='jNotice'></div>
			
	[~ validate id='name'  	  message=$text.name    append='error' ~]
	[~ validate id='client'   message=$text.client  append='error' ~]
	[~ validate id='manager'  message=$text.manager append='error' ~]
	
	[~if $error~]
		<div class='warning'>
		  <ul>
			[~foreach from=$error item="val"~]<li>[~$val~]</li>[~/foreach~]
		  </ul>
		</div>
	[~/if~]
	
	<form name='projectEdit' id='projectEdit' action='/app/projectEdit.php' method='post'>
	<input name='id' value='[~$project.projID~]' type='hidden' />
	<table class='formTable'>
	<tr>
	 <td><label for='name'>Project Name</label></td>
	 <td><input name='name' value='[~$project.name~]' id='name' /> <span class='required'>*</span></td>
	</tr>
	<tr>
	 <td colspan='2'>
	 	<label for='description' class='textarea'>Description <span class='subtle'>(optional)</span></label>
		<textarea name='description'>[~$project.description~]</textarea>
	 </td>
	</tr>
	<tr>
	 <td><label for='client'>Client</label></td>
	 <td>
	 		<select name='client'>
				<option value=''>Please Select...</option>
				[~ html_options options=$clients|truncate:28 selected=$project.client ~]
			</select> <span class='required'>*</span></td>
	</tr>
	<tr>
	 <td><label for='visibility'>Visible to Client</label></td>
	 <td>
	 	<input type='checkbox' class='checkbox' name='visibility' value='1' [~if $project.visibility~]checked='checked'[~/if~] />
		<span class='subtleBox'>If checked, the client will be able to view this project and all its contents.</span>
	 </td>
	</tr>
	<tr>
	 <td><label for='manager'>Project Manager</label></td>
	 <td><select name='manager'>
				[~ html_options options=$managers selected=$project.manager ~]
		 </select></td>
	</tr>
	</table>
	
	<div class='submit'>
		<input type='submit' id='submit' name='submit' value='Save Changes' />
		<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
		or <a href='/app/projects.php'>cancel</a>
	</div>
	
	<div class='smallPrint'>
		Fields marked with a <strong>*</strong> are required.
	</div>
	
	</form>
	
</div>

[~include file='inc.end.tpl'~]

</body>
</html>
