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
	<title>Document Versions - [~$user.organisation~] - Footprint</title>
	
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
  	});
	
	</script>
	
	<style type="text/css">
		[~include file='inc.css.tpl'~]
	</style>
	
</head>

<body>

[~include file='inc.nav.tpl'~]

<div id='content'>

	[~if $user.perms.all_objects || $user.perms.assigned_objects || $document.clientAccess > 1 ~]
	<div class='appButton'>
		<span title='Update Document'>
		 <a href='/app/documentUpdate.php?id=[~$document.docID~]'>
		 <img src='/app/media/images/buttons/updateNow.gif' alt='Update Document' />
		 </a>
		</span>
	</div>
	[~/if~]

	<h1 id='headerDocument'>[~$document.title~] ([~$document.docType|default:'???'~])</h1>
	
	<table class='dataListing'>
	<thead>
	 <tr>
	  <td width='18%'>Revision Date</td>
	  <td width='38%'>Comment</td>
	  <td width='07%'>Version</td>
	  <td width='10%'>Size</td>
	  <td width='15%'>Published By</td>	  
	  <td width='12%'>&nbsp;</td>
	 </tr>
	</thead>
	<tbody>
	
	 [~ foreach name=verList item=v from=$document.versions ~]
	 <tr class='[~ cycle values="odd,even" name="rowBackground" ~]'>
	  <td>[~$v.revisionDate|date_format~]</td>
	  <td>[~$v.comment|truncate:40~]</td>
	  <td>[~$v.version|commify:1~]</td>
	  <td>[~$v.size|filesize_format~]</td>
	  <td>[~$v.firstname~] [~$v.lastname~]</td>
	  <td class='last'><a href='/app/documentView.php?id=[~$v.versionID~]'>Download</a> &raquo;</td>
	 </tr>
	 [~/foreach~]

	</tbody>
	</table>
	
	<p>&laquo; <a href='/app/documents.php'>back</a></p>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
