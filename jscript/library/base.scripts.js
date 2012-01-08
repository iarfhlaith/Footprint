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
	
	// Grey Out All Form Inputs
	$("input").attr('disabled', 'disabled');
	
	// Display Loading Graphic
	$('#loader').show().css('display','inline');
	
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
	$("input").attr('disabled', '');
	
	// Hide Loading Graphic
	$("#loader").hide();
	
	// Update Submit Button Text and Disable
	$("#submit").val(label);
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
				var loader = '/media/images/loaders/progress.gif';
				
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
 * Asynchronously reset the users password
 *
 * If the password is reset successfully, a nice message is displayed to that effect.
 * If the password is either empty or not a valid password then a message will be displayed.
 * If the passwords don't match then a message be displayed to that effect.
 *
 * @param	array	formVars - A serialised string of the submitted form fields
 * @return	void
 *
 */
function resetPassword(formVars)
{	
	// Do the AJAX to submit the form.
	$.ajax
	({
		type:	  'POST',
		url:	  '/reset/index.php',
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
				resetFormVisuals(strSavePass);
			}
			return(false);
		},
	
		error:function(data)
		{
			$('#jNotice').show().addClass('warning').append(strCommError);
			resetFormVisuals(strSavePass);
		}
	});
}

/**
 * Asynchronously login the user to Footprint via OpenID
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
function openid(formVars)
{	
	// Do the AJAX to submit the form.
	$.ajax
	({
		type:	  'POST',
		url:	  '/openid/index.php',
		data:	  formVars+'&ajax=true',
		dataType: 'json',
		
		success: function(data)
		{
			// Display Response Message
			$('#jNotice').show().addClass(data['response']['style']).append("<ul><li>"+data['response']['message']+"</li></ul>");
			
			if(data['response']['result'] == '0')
			{					
				var loader = '/media/app/images/loaders/progress.gif';
				
				loadImage(loader);
				
				$('#loginForm').empty().append("<div class='completed'><h1>"+data['response']['message']+"</h1><img src='"+loader+"' /><br /><br /><a href='/login'>"+strCancel+"</a></div>");
				
				// Redirect to Dashboard
				location.href = data['response']['redirect'];
			}
			else
			{
				resetFormVisuals(strLogin);
				showFormErrors(data['response']['errors']);
			}
		},
	
		error:function(data)
		{
			$('#jNotice').show().addClass('warning').append(strCommError);
			resetFormVisuals(strLogin);
		}
	});
}
