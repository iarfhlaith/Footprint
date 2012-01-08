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
	<title>Update Document - [~$user.organisation~] - Footprint</title>
	
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
		$('#documentUpdate').submit(function ()
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

[~include file='inc.nav.tpl'~]

<div id='content'>

	<h1 id='headerDocument'>Update Document</h1>
	
	[~ validate id='file'     message=$text.file 	 append='error' ~]
	[~ validate id='fileSize' message=$text.fileSize append='error' ~]
	[~ validate id='access'   message=$text.access 	 append='error' ~]
	[~ validate id='version'  message=$text.version	 append='error' ~]
	
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
			<p>The account limit for document stoage has been reached. Please contact the account owner and ask them
			   to increase their storage capacity on the system.</p>
		</div>
		
	[~elseif $docName.docID~]
	
	<form name='documentUpdate' id='documentUpdate' action='documentUpdate.php' method='post' enctype='multipart/form-data'>
	<input type="hidden" name='MAX_FILE_SIZE' value="15728640" /> <!-- 15MB -->
	<input type="hidden" name='id' value='[~$docName.docID~]' />
	<input type="hidden" name='version' value='[~$docName.version~]' />
	<table class='formTable'>
	<tr>
	 <td><label>Selected Document</label></td>
	 <td><span class='docType [~$docName.docType~]'>[~$docName.docTitle~]</span></td>
	</tr>
	<tr>
	 <td><label for='file'>Updated File</label></td>
	 <td colspan='2'><input type='file' size='41' name='file'></td>
	</tr>
	<tr>
	 <td><label for='comment'>Comment</label></td>
	 <td colspan='2'><input name='comment' value='[~$comment~]' /> <span class='subtle'>(optional)</span></td>
	</tr>
	[~if $user.perms.manage_doc_access~]
	<tr>
	 <td><label for='access'>Client Access</label></td>
	 <td>
	 	<div class='multiCheck_2'>
		 <label><input type='radio' name='access' class='radio' value='0' [~if $docName.access == '0'~]checked='checked'[~/if~] /> None</label>
		 <label><input type='radio' name='access' class='radio' value='1' [~if $docName.access == '1'~]checked='checked'[~/if~] /> Read Only</label>
		 <label><input type='radio' name='access' class='radio' value='2' [~if $docName.access == '2'~]checked='checked'[~/if~] /> Full Access</label>
		</div>
	 </td><td></td>
	</tr>
	[~else~]
		<input type='hidden' name='access' value='2' />
	[~/if~]
	</table>
	
	<div class='submit'>
		<input type='submit' id='submit' name='submit' value='Commit These Changes' />
		<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
		or <a href='/app/documents.php'>cancel</a>
	</div>
	
	<div class='smallPrint'>
		Fields marked with a <strong>*</strong> are required.
	</div>
	
	</form>
	
	[~else~]
	
	<div class='notice bad'>
		<h2>Not Found.</h2>
		<p>Sorry, the information you're looking for couldn't be found in your account.</p>
		<ul>
			<li><a href='/app'>Go back to your dashboard</a></li>
		</ul>
	</div>
	
	<br /><br /><br /><br /><br />
	<br /><br /><br /><br /><br />
	
	[~/if~]

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
