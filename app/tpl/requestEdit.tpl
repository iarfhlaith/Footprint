<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Edit Request - [~$user.organisation~] - Footprint</title>
	
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
		$('#request').focus();
		
		$('#requestEdit').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('requestEdit', formVars);
			
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

	<h1 id='headerRequest'>Edit Request</h1>
	
	<div id='jNotice'></div>
	
	[~ validate id='title'   message=$text.title   append='error' ~]
	[~ validate id='project' message=$text.project append='error' ~]
		
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
	
	<form name='requestEdit' id='requestEdit' action='/app/requestEdit.php' method='post'>
	<input name='id' value='[~$request.taskID~]' type='hidden' />
	<table class='formTable'>
	<tr>
	 <td><label for='title'>Request</label></td>
	 <td colspan='2'><input name='title' value='[~$request.title~]' /> <span class='required'>*</span></td>
	</tr>
	<tr>
	 <td colspan='3'>
	 	<label for='description' class='textarea'>Description <span class='subtle'>(optional)</span></label>
		<textarea name='description'>[~$request.description~]</textarea>
	 </td>
	</tr>
	<tr>
	 <td><label for='project'>Project</label></td>
	 <td colspan='2'>
	 <select name='project'>
		<option value=''>Please Select...</option>
		[~ html_options options=$projects|truncate:28 selected=$request.project ~]
	 </select> <span class='required'>*</span></td>
	</tr>
	</table>
	
	<div class='submit'>
		<input type='submit' id='submit' name='submit' value='Save Changes' />
		<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
		or <a href='/app/requests.php'>cancel</a>
	</div>
	
	<div class='smallPrint'>
		Fields marked with a <strong>*</strong> are required.
	</div>
	
	</form>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
