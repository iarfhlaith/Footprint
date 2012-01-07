<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>New Request - [~$user.organisation~] - Footprint</title>
	
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
		
		$('#requestNew').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('requestNew', formVars);
			
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

	<h1 id='headerRequest'>New Request</h1>
	
	[~if $projects~]
	
		<div id='jNotice'></div>
			
		[~ validate id='request' message=$text.request append='error' ~]
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
		
		<form name='requestNew' id='requestNew' action='/app/requestNew.php' method='post'>
		<table class='formTable'>
		<tr>
		 <td><label for='request'>Request</label></td>
		 <td><input name='request' value='[~$request~]' id='request' /> <span class='required'>*</span></td>
		 <td><div class='formTip'>Put a title on your request. This is what will be seen in the list of requests.</div></td>
		</tr>
		<tr>
		 <td colspan='3'>
			<label for='description' class='textarea'>Description <span class='subtle'>(optional)</span></label>
			<textarea name='description'>[~$description~]</textarea>
		 </td>
		</tr>
		<tr>
		 <td><label for='project'>Project</label></td>
		 <td>
		 <select name='project'>
			<option value=''>Please Select...</option>
			[~ html_options options=$projects|truncate:28 selected=$project ~]
		 </select> <span class='required'>*</span></td>
		 <td><div class='formTip'>Please assign the request to a project.</div></td>
		</tr>
		</table>
		
		<div class='submit'>
			<input type='submit' id='submit' name='submit' value='Submit Request' />
			<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
			or <a href='/app/requests.php'>cancel</a>
		</div>
		
		<div class='smallPrint'>
			Fields marked with a <strong>*</strong> are required.
		</div>
		
		</form>
	
	[~else~]
	
		<div class='notice pointer'>
			<h2>Oh dear, there are no projects on your account yet.</h2>
			<p>
				There must be at least one project in your account before you can start adding requests.
				These are a great way to make suggestions and to get new pieces of work started. Once your first project
				has been added, revisit this section to make a request.
			</p>
		</div>
		
		<div class='formPreview'>
			<img src='/app/media/images/firstView/requestNew.gif' alt='Preview of the New Request form' id='firstViewPreview' />
		</div>
	
	[~/if~]

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
