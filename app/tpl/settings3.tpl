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
	<title>Settings - [~$user.organisation~] - Footprint</title>
	
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

  	});
	
	</script>
	
	
	<style type="text/css">
		[~include file='inc.css.tpl'~]
	</style>
	
</head>

<body>

[~include file='inc.nav.tpl'~]

<div id='content'>

	<h1 id='headerSettings'>Settings</h1>
	
	[~include file='inc.tab.tpl'~]
	
	<div class='settingOptions'>
	
		<h2>Import Clients</h2>
		
		<p>Please select where you would like to import your clients from:</p>
		
		<div class='tip'>
			<h3>Tips for a Successful Import</h3>
			
			<p>
				The best format to use when importing existing clients into
				Footprint is:
			</p>
			
			<ul>
				<li>Organisation Name </li>
				<li>Person's Name</li>
				<li>Person's Email</li>
				<li>Password (optional)</li>
				<li>Send Invite (optional - yes/no)</li>
			</ul>
		</div>
		
		<p>
			<a href='/app/clientImport.php?source=csv' class='docType txt'>Comma Separated File (CSV)</a>
			[~*
			<br /><br />
			<a href='/app/clientImport.php?source=fbs' class='docType freshbooks'>FreshBooks</a>
			<br /><br />
			<a href='/app/clientImport.php?source=bcp' class='docType basecamp'>Basecamp</a>
			<br /><br />
			<a href='/app/clientImport.php?source=xls' class='docType xls'>Microsoft Excel</a>
			*~]
		</p>
		
		<div class='clear'></div>
		[~*
		<h2>Export Information</h2>
		
		<p>Select which type of data you want to export:</p>
		
		<p>
		<a href='#' class='docType clients'>Export Clients</a>
		</p>
		<p>
		<span class='subtle'>
			Export all client information. This can be easily formatted in a spreadsheet program such as Microsoft Excel.
		</span>
		</p>
		
		<p>
		<a href='#' class='docType projects'>Projects</a>
		</p>
		<p>
		<span class='subtle'>
			All projects will be included here. This can be used to import into another project collaboration tool if required.
		</span>
		</p>
		
		<p>
		<a href='#' class='docType tasks'>Tasks</a>
		</p>
		<p>
		<span class='subtle'>
			Every task will be exported here. This includes tasks assigned to different projects and clients.
		</span>
		</p>
		<p>
		<a href='#' class='docType comments'>Comments</a>
		</p>
		<p>
		<span class='subtle'>
			Exported comments can be used in a number of different ways. They're all included with this export tool.
		</span>
		</p>
		
		<div class='tipFull'>	
			<h4>Notes</h4>
			<ul>
				<li>The first line of each exported csv holds the title information.</li>
				<li>If any field contains a comma, the fields on that line will not align correctly with the column headings.</li>
			</ul>
		</div>
		*~]
	
	</div>
	
</div>

[~include file='inc.end.tpl'~]

</body>
</html>
