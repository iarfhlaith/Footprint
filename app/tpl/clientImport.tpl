<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Import Clients - [~$user.organisation~] - Footprint</title>
	
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
		$('#type').focus();
		
		$('#clientImport').submit(function ()
		{	
			runFormVisualsSync();
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

	<h1 id='headerClient'>Import Clients</h1>
	
	[~ validate id='type'  		message=$text.type       append='error' ~]
	[~ validate id='file'  		message=$text.file       append='error' ~]
	[~ validate id='fileSize'   message=$text.fileSize   append='error' ~]
	[~ validate id='fileFormat' message=$text.fileFormat append='error' ~]
	
	[~if $error~]
		<div class='warning'>
		  <ul>
			[~foreach from=$error item="val"~]<li>[~$val~]</li>[~/foreach~]
		  </ul>
		</div>
	[~/if~]
	
	<form name='clientImport' id='clientImport' action='/app/clientImport.php' method='post' enctype='multipart/form-data'>
	<input type="hidden" name='MAX_FILE_SIZE' value="15728640" /> <!-- 15MB -->
	<table class='formTable'>
	<tr>
	 <td><label for='type'>Import From</label></td>
	 <td>
	 	<select name='type' id='type'>
		 <option value='csv'>CSV File</option>
		 <option value='xls'>Microsoft Excel</option>
		 <option value='bcp'>BaseCamp</option>
		 <option value='fbs'>FreshBooks</option>
		</select> <span class='required'>*</span></td>
	 <td rowspan='2'><div class='formTip'>

		<strong>Required Format:</strong>
		<ul>
			<li>Organisation Name</li>
			<li>Person's Name</li>
			<li>Person's Email</li>
			<li>Password (optional)</li>
			<li>Send Invite (optional - yes/no)</li>
		</ul>

	 </div></td>
	</tr>
	<tr>
	 <td><label for='file'>Choose File</label></td>
	 <td><input type='file' size='41' name='file' id='file'> <span class='required'>*</span></td>
	</tr>
	</table>
	
	<div class='submit'>
		<input type='submit' id='submit' name='submit' value='Import Clients' />
		<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
		or <a href='/app/clients.php'>cancel</a>
	</div>
	
	<div class='smallPrint'>
		Fields marked with a <strong>*</strong> are required.
	</div>
	
	</form>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
