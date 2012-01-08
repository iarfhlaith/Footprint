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
	<title>New Project - [~$user.organisation~] - Footprint</title>
	
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
		
		$('#projectNew').submit(function (){
			
			var formVars = $('form').serialize();
			
			runFormVisuals();
			
			fpSubmit('projectNew', formVars);
			
			return(false);
			
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

	<h1 id='headerProject'>New Project</h1>
	
	[~if $clients~]
	
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
		
		<form name='projectNew' id='projectNew' action='/app/projectNew.php' method='post'>
		<table class='formTable'>
		<tr>
		 <td><label for='name'>Project Name</label></td>
		 <td><input name='name' value='[~$name~]' id='name' /> <span class='required'>*</span></td>
		 <td><div class='formTip'>Choose a meaningful name like "New Website Designs"</div></td>
		</tr>
		<tr>
		 <td colspan='2'>
			<label for='description' class='textarea'>Description <span class='subtle'>(optional)</span></label>
			<textarea name='description'>[~$description~]</textarea>
		 </td>
		 <td><div class='formTip'>Remember, you can add tasks to this project once it's been created.</div></td>
		</tr>
		<tr>
		 <td><label for='client'>Client</label></td>
		 <td colspan='2'>
		 	<select name='client'>
				<option value=''>Please Select...</option>
				[~ html_options options=$clients|truncate:28 selected=$client ~]
			</select> <span class='required'>*</span></td>
		</tr>
		<tr>
		 <td><label for='visible'>Visible to Client</label></td>
		 <td>
		 	<input type='checkbox' class='checkbox' name='visible' value='1' checked='checked' />
			<span class='subtleBox'>If checked, the client will be able to view this project and all its contents.</span>
		 </td>
		</tr>
		<tr>
		 <td><label for='manager'>Project Manager</label></td>
		 <td colspan='2'>
		 	<select name='manager'>
				[~ html_options options=$managers selected=$manager ~]
			</select></td>
		</tr>
		</table>

		<div class='submit'>
			<input type='submit' id='submit' name='submit' value='Save Project' />
			<img src='/media/images/loaders/loading.gif' alt='Loading...' class='loader' id='loader' />
			or <a href='/app/projects.php'>cancel</a>
		</div>
		
		<div class='smallPrint'>
			Fields marked with a <strong>*</strong> are required.
		</div>
		
		</form>
	
	[~else~]
	
		<div class='notice pointer'>
			<h2>Steady on, you need to add your first client before creating a project</h2>
			<p>
				You should add your first client before creating a project. Each project needs to be assigned to a client
				when it's created.
			</p>
			
			<div class='noticeButton'>
				<a href='/app/clientNew.php'>
				<img src='/app/media/images/buttons/clientNew.gif' alt='Create New Client' />
				</a>
			</div>

		</div>
		
		<div class='formPreview'>
			<img src='/app/media/images/firstView/projectNew.gif' alt='Preview of the New Project form' id='firstViewPreview' />
		</div>
	
	[~/if~]
	
</div>

[~include file='inc.end.tpl'~]

</body>
</html>
