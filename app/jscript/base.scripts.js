
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

/**
 * Load an image into the DOM on the fly
 *
 * @param	string	url	- The URL of the new image
 * @return	false
 *
 */
function loadImage(url)
{
    var img    = document.createElement('img');
    img.onload = function(){}
    img.src    = url;
    return(false);
}

/**
 * Update the form visuals to processing mode.
 *
 * This includes:
 *
 * - Hiding any notices that may have been previously displayed.
 * - Greying out any form inputs
 * - Displaying a loader graphic beside the submit button
 * - Updating the submit button text to say 'Please Wait' (or something similar).
 *
 * @return	void
 *
 */
function runFormVisuals()
{
	// Remove Any Notices
	$("#jNotice").empty().hide();
	
	// Remove Any Messages
	$("#message").empty().hide();
	
	// Grey Out All Form Inputs
	$("input, textarea, select").attr('disabled', 'disabled');
	
	// Display Loading Graphic
	$('#loader').show().css('display','inline');
	
	// Update Submit Button Text and Disable
	$("#submit, #innerSubmit").val(strPleaseWait);	
}

/**
 * Update the form visuals to processing mode. This is the exact same as
 * runFormVisuals() except it doesn't disable the input fields, which causes
 * problems with synchronuous form submissions. So, use this one instead.
 *
 * This includes:
 *
 * - Hiding any notices that may have been previously displayed.
 * - Displaying a loader graphic beside the submit button
 * - Updating the submit button text to say 'Please Wait' (or something similar).
 *
 * @return	void
 *
 */
function runFormVisualsSync()
{
	// Remove Any Notices
	$("#jNotice").empty().hide();
	
	// Remove Any Messages
	$("#message").empty().hide();
	
	// Display Loading Graphic
	$('#loader').show().css('display', 'inline');
	
	// Update Submit Button Text and Disable
	$("#submit").val(strPleaseWait);
}

/**
 * Reset the form visuals into normal mode.
 *
 * This includes:
 *
 * - Enabling the form input boxes
 * - Hiding the loader graphic
 * - Resetting the submit button text
 *
 * @param	string	label - The new text for the submit button
 * @return	void
 *
 */
function resetFormVisuals(label)
{
	// Enable the Form
	$("input, textarea, select").attr('disabled', '');
	
	// Hide Loading Graphic(s)
	$("#loader").hide();
	$('#filterLoad').html("<img src='/app/media/images/loaders/clearDot.gif' width='16' height='16' />");
	
	// Update Submit Button Text and Disable
	$("#submit").val(label);
	$("#innerSubmit").val(label);
	
	// Go to the Top of the Screen
	window.location = '#top';
}

/**
 * Reset the form visuals into normal mode.
 *
 * This includes:
 *
 * - Enabling the form input boxes
 * - Hiding the loader graphic
 * - Resetting the submit button text
 *
 * @param	string	label - The new text for the submit button
 * @return	void
 *
 */
function showFormErrors(errorData)
{
	var errors = '';
				
	// Display Any Error Message(s)
	for (var i=0; i < errorData.length; i++)
	{	
		errors = errors+'<li>'+errorData[i]['message']+'</li>';
	}
	
	$('#jNotice').empty().append('<ul>'+errors+'</ul>');	
}

/**
 * Asynchronously log the user into Footprint
 *
 * If the login in successful, the user is redirected to their Footprint Dashboard.
 * If their credentials are incorrect, then a list of the errors are displayed at the top
 * of the page.
 * If there is a communications error such as a timeout or an invalid response then a nice
 * error message will be displayed to that effect.
 *
 * @param	array	formVars - A serialised string of the submitted form fields
 * @return	void
 *
 */
function login(formVars)
{	
	// Do the AJAX to submit the form.
	$.ajax
	({
		type:	  'POST',
		url:	  '/login/index.php',
		data:	  formVars+'&ajax=true',
		dataType: 'json',
		
		success: function(data)
		{	
			if(data['response']['result'] == '0')
			{
				var loader = '/app/media/images/loaders/progress.gif';
				
				loadImage(loader);
				
				$('#loginForm').empty().append("<div class='completed'><h1>"+data['response']['message']+"</h1><img src='"+loader+"' /><br /><br /><a href='/login'>"+strCancel+"</a></div>");
				
				// Redirect to Dashboard
				location.href = "http://"+$.url.attr('host')+"/app/";
			}
			else
			{
				$('#jNotice').show().addClass(data['response']['style']);
				
				showFormErrors(data['response']['errors']);
				resetFormVisuals(strLogin);
			}
		},
	
		error:function(data)
		{
			$('#jNotice').show().addClass('warning').append(strCommError);
			resetFormVisuals(strLogin);
		}
	});
}

/**
 * Asynchronously email the user a link to let them reset their password.
 *
 * If the email is sent successfully, a nice message is displayed to that effect.
 * If the email provided is either empty or not a valid email address then a message will be displayed.
 * If the email provided is not in the system a message will be displayed to that effect.
 *
 * @param	array	formVars - A serialised string of the submitted form fields
 * @return	void
 *
 */
function remind(formVars)
{	
	// Do the AJAX to submit the form.
	$.ajax
	({
		type:	  'POST',
		url:	  '/reminder/index.php',
		data:	  formVars+'&ajax=true',
		dataType: 'json',
		
		success: function(data)
		{
			// Display Response Message
			$('#jNotice').show().addClass(data['response']['style']).append("<ul><li>"+data['response']['message']+"</li></ul>");
			
			if(data['response']['result'] == '0')
			{					
				$('form').hide();
			}
			else
			{
				showFormErrors(data['response']['errors']);
				resetFormVisuals(strReset);
			}
		},
	
		error:function(data)
		{
			$('#jNotice').show().addClass('warning').append(strCommError);
			resetFormVisuals(strReset);
		}
	});
}

/**
 * Asynchronously submit form to Footprint script
 *
 * Success: 	Display message and then redirect user, plus the fading highlighter trick
 * Incomplete:	Form errors will be highlighted
 * Not Allowed: Display error message
 * Max Limit:	Display prompt to upgrade
 * Comm Error:	Display comm error message
 *
 * The action parameter is also used as a marker to control process flow.
 * - 'taskView' (new comment) will hide form on success & display comment, then phase out success message.
 *
 * @param   string  action	   - The name of the script to submit the form to.
 * @param	array	formVars   - A serialised string of the submitted form fields
 * @return	void
 *
 */
function fpSubmit(action ,formVars, redirectParams)
{	
	// Do the AJAX to submit the form.
	$.ajax
	({
		type:	  'POST',
		url:	  '/app/'+action+'.php',
		data:	  formVars+'&ajax=true',
		dataType: 'json',
		
		success: function(data)
		{		
			// Check First if Script Should do a Redirect
			if(data['response']['redirect'])
			{
				if (redirectParams === undefined)
				{	
					window.location = data['response']['redirect'];
				}
				else
				{
					window.location = data['response']['redirect']+'?'+redirectParams;
				}
				return;
			}
			
			// Display Response Message
			$('#jNotice').show().addClass(data['response']['style']).append("<ul><li>"+data['response']['message']+"</li></ul>");
			
			if(data['response']['result'] == '0' && data['response']['redirect'])
			{					
				$('form').hide();
			}
			else
			{
				if(data['response']['errors'])
				{
					showFormErrors(data['response']['errors']);
				}
				
				resetFormVisuals(strLang[action]['submit']);
			}
		},
	
		error:function(data)
		{
			$('#jNotice').show().addClass('warning').append(strCommError);
			resetFormVisuals(strLang[action]['submit']);
		}
	});
}

/**
 * Asynchronously retrieve data as JSON 
 *
 * Success: 	Returns Data as a JSON encoded array
 * Incomplete:	Form errors will be highlighted
 * Not Allowed: Display error message
 * Comm Error:	Display comm error message
 *
 * @param   string  action	 - The name of the script to submit the form to.
 * @param	array	formVars - A serialised string of the submitted form fields
 * @param   string  type     - The type of load required ('select' or 'table')
 * @param   string  dest     - The selector of the destination object (example: 'select#taskSelect')
 * @return	void
 *
 */
function ajaxLoad(action , formVars, type, dest)
{	
	// Do the AJAX to submit the form.
	$.ajax
	({
		type:	  'GET',
		url:	  '/app/'+action+'.php',
		data:	  formVars+'&ajax=true',
		dataType: 'json',
		
		success: function(data)
		{		
			if(type == 'select')
			{	
				var options = "<option value='' id='newTaskDefault'>Please Select...</option>";
			
				// Populate Select Box
				for (var i = 0; i < data['response'].length; i++)
				{
        			options += "<option value='" + data['response'][i].taskID + "'>" + data['response'][i].title + "</option>";
      			}
			
				// Hide Loader
				$('#filterLoad').html("<img src='/app/media/images/loaders/clearDot.gif' width='16' height='16' />");
				
				// Display Select Box
				$('#taskRow').show();
				$(dest).html(options).focus();
				$('#newTaskDefault').attr('selected', 'selected');
			}
		},
	
		error:function(data)
		{
			$('#jNotice').show().addClass('warning').append(strCommError);
			resetFormVisuals();
			
			// Hide Loader
			$('#filterLoad').html("<img src='/app/media/images/loaders/clearDot.gif' width='16' height='16' />");	
		}
	});
}

/**
 * On Change, copy the contents of the first parameter into
 * the contents of the second parameter.
 * 
 * Very useful for when username is likely to match the email address
 * of a user.
 *
 * @param   string  sourceID - The ID of the source inbut box
 * @param	string	destID   - The ID of the destination input box
 * @return	void
 *
 */
function matchFields(sourceID, destID)
{
	$('#'+sourceID).change(function()
	{
		$('#'+destID).val($('#'+sourceID).val());
	});
}
