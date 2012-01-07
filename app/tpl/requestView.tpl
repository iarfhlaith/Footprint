<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>View Request - [~$user.organisation~] - Footprint</title>
	
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" value="no-cache, no store, must-revalidate">
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/app/css/screen.css" />
	
	<script type="text/javascript" src="/app/jscript/plugins/jQuery.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{
		$('#rejectRequest').click(function()
		{
			$('#action').val('reject');
			$('#requests').submit();
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
	
	<h1 id='headerRequest'>[~$request.title~]</h1>
	
	[~if $user.perms.manage_requests~]
		<form id='requests' action='requests.php' method='post'>
		<input type='hidden' name='action' id='action' value='convert'>
		<input type='hidden' name='request' id='request' value='[~$request.taskID~]'>
	[~/if~]
		
	<div id='requestPanel'>
	
		<ul>
		 <li>Request No. <strong>#[~$request.taskID~]</strong></li>
		 <li>Project: 	 <strong>[~$request.name~]</strong></li>
		 <li>Client: 	 <strong>[~$request.clientOrganisation~]</strong></li>
		 <li>Created By: <strong>[~$request.firstname~] [~$request.lastname~]</strong></li>
		 <li>Created On: <strong>[~$request.createdOn|date_format~]</strong></li>
		</ul>
		
		[~if $user.perms.manage_requests~]
		<div class='quickNote'>
		 <label for='reply' class='textarea'>Reply Note</label> (optional)
		 <textarea name='reply' rows='7' id='reply'>[~$request.replyNote~]</textarea>
		</div>
		[~/if~]
		
	</div>
	
	<div id='requestInfo'>
		
		<div id='requestText'>
			
			[~if $request.replyNote != '' && $user.perms.make_requests~]
				<h2>Reply Note</h2>
				<p id='replyNote'>"[~$request.replyNote~]"</p>
			[~/if~]
			
			<h2>New Request Information</h2>
			<p>[~$request.description|nl2br~]</p>
			
			[~if $user.perms.make_requests~]
			<p>
			<a href='/app/requestEdit.php?id=[~ $request.taskID ~]'>
				<img src='/app/media/images/buttons/editSmall.gif' alt='Edit' />
			</a>
			</p>
			[~/if~]
			
		</div>
		
		[~if $user.perms.manage_requests~]
		<div class='submit'>
			<br />
			<input type='submit' id='submit' name='submit' value='Accept Request &amp; Convert to Task' />
			<br /><br />
			
			<input type='submit' id='rejectRequest' value='Reject Request' />
			
			<!-- <a href='' id='brejectRequest'>Reject Request</a> -->
		</div>
		[~/if~]
		
	</div>
	
	[~if $user.perms.manage_requests~]</form>[~/if~]
	
	<div class='clear'></div>
	
</div>

[~include file='inc.end.tpl'~]

</body>
</html>
