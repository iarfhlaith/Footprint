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
	<title>Project Timeline - [~$user.organisation~] - Footprint</title>
	
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

	<h1 id='headerProject'>PhoneBook Project - Timeline</h1>
		
	<div id='projectPanel'>
	
		<ul>
		 <li><img align='absmiddle' src='/app/media/images/icons/clientsSmall.gif' /> <strong>iText Mobile Solutions</strong></li>
		 <li>Assigned To: <strong>Iarfhlaith Kelly</strong></li>
		 <li>Created On: <strong>09/12/07</strong></li>
		</ul>
		
		<br />
		
		<ul>
		 <li><img align='absmiddle' src='/app/media/images/icons/tasksSmall.gif' /> Tasks: <a href='/tasks.php'>24</a></li>
		 <li><img align='absmiddle' src='/app/media/images/icons/screenshotSmall.gif' /> Screenshots: <a href='/screenshots.php'>5</a></li>
		 <li><img align='absmiddle' src='/app/media/images/icons/commentsSmall.gif' /> Total Comments: 34</li>
		 <li><img align='absmiddle' src='/app/media/images/icons/documentsSmall.gif' /> Documents: <a href='/documents.php'>3</a> (Size: 2.3Mb)</li>
		</ul>
		
		<br />
		
		<ul>
		 <li><img align='absmiddle' src='/app/media/images/icons/projectsSmall.gif' /> <strong><a href='/app/projectView.php'>View Project Summary</a></strong></li>
		</ul>
		
	</div>
	
	<div id='projectInfo'>
	
		<div id='projectTimeline'>
		
			...
		
		</div>
	
	</div>
	
	<div class='clear'></div>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
