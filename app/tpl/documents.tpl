<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Documents - [~$user.organisation~] - Footprint</title>
	
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" value="no-cache, no store, must-revalidate">
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/app/css/screen.css" />
	
	<script type="text/javascript" src="/app/jscript/plugins/jQuery.js"></script>
	<script type="text/javascript" src="/app/jscript/fp.behaviour.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{
		rowHighlight();
		handleMessages();
		handleDeletions();
		handleDocRenames();
	
		$('#task').change(function()
		{
			$('#filter').submit();
			$('#filterLoad').html("<img src='/app/media/images/loaders/loading.gif' alt='Loading...' />");
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

	<div class='appButton'>
		<span title='Create New Document'>
		 <a href='/app/documentNew.php'>
		 <img src='/app/media/images/buttons/documentNew.gif' alt='Create New Document' />
		 </a>
		</span>
	</div>
	
	[~if $documents~]
	<div class='dataFilter'>
		<form id='filter'>
		<label for='id'>Display for:</label>
		<select name='id' id='task'>
		<option>All Tasks</option>
		[~ html_options options=$tasks|truncate:28 selected=$task ~]
		</select>
		<span id='filterLoad'>
			<img src='/app/media/images/loaders/clearDot.gif' width='16' height='16' />
		</span>
		</form>
	</div>
	[~/if~]

	<h1 id='headerDocument'>Documents</h1>
	
	[~if $message~][~include file='inc.msg.tpl'~][~/if~]
	
	[~if $documents~]
	<div class='dataButtons'>
		<ul>
	 	 <li><a href='#' id='delete'>Delete</a></li>
		 <li><a href='#' id='rename'>Rename</a></li>
		</ul>
		<div class='clear'></div>
	</div>
	
	<form id='documents' action='documents.php' method='post'>

	<table class='dataListing'>
	<thead>
	 <tr>
	  <td width='02%'>&nbsp;</td>
	  <td width='27%'>Document</td>
	  <td width='11%'>Size</td>
	  <td width='08%'>Version</td>
	  <td width='17%'>Last Updated</td>
	  <td width='26%'>Task</td>
	  <td width='09%'>&nbsp;</td>
	 </tr>
	</thead>
	<tbody>

	 [~ foreach name=docList item=d from=$documents ~]
	 <tr class='[~ cycle values="odd,even" name="rowBackground" ~]'>
	  <td>  
		[~if $user.perms.all_objects || $user.perms.assigned_objects || $d.clientAccess > 1 ~]
			<input type='checkbox' name='documents[[~$d.docID~]]' class='docCheck' value='' />
		[~else~]
			<span title='locked'><img src='/app/media/images/icons/lockSmall.gif' alt ='locked' /></span>
		[~/if~]
	  </td>
	  <td><a href='/app/documentView.php?id=[~$d.versionID~]' class='docType [~$d.docType|default:unknown~]'>[~$d.docTitle|truncate:25~]</a></td>
	  <td>[~$d.size|filesize_format~]</td>
	  <td><a href='/app/documentVersions.php?id=[~$d.docID~]'>[~$d.version|commify:1~]</a></td>
	  <td>[~$d.lastAccessed|time_since~]</td>
	  <td><a href='/app/taskView.php?id=[~$d.taskID~]'>[~$d.title|truncate:26~]</a></td>
	  <td class='last'>
	  	[~if $user.perms.all_objects || $user.perms.assigned_objects || $d.clientAccess > 1 ~]
	  		<a href='/app/documentUpdate.php?id=[~$d.docID~]'>Update</a> &raquo;
		[~else~]Read Only[~/if~]
	  </td>
	 </tr>
	 [~/foreach~]
	 
	</tbody>
	</table>
	
	</form>
	
	<div class='pagination'>
		[~include file='inc.pag.tpl'~]
	</div>
	
	[~else~]
	
		<div class='notice prompt'>
			<h2>Add your first document</h2>
			<p>
				You can store any document type you like. It's great for sharing files with others.
				It also includes version control so you never have to lose any important data again.
			</p>
			<p class='smallPrint'>
				This prompt will disappear when you add your first document.
			</p>
		</div>
			
		<div>
			<img src='/app/media/images/firstView/documents.png' alt='' />
		</div>
	
	[~/if~]

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
