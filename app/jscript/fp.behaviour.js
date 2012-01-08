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
 *
 * Focus on the comment box and make it visible
 *
 */
function commentFocus(focusPoint)
{
	$('#commentNewForm').toggle();
	window.location = '#'+focusPoint;
	$('#comment').focus();
}

/**
 *
 * Highlight each row of a data listing
 * as the user hover's her mouse over it.
 *
 */
function rowHighlight()
{
	// Highlight Current Row
	$('.dataListing tbody tr').hover(
	function()
	{
		$(this).addClass('current');
	}, 
	function()
	{
		$(this).removeClass('current');
	});
}

/**
 *
 * Hide the message box when a user clicks
 * on the 'close' icon.
 *
 */
function handleMessages()
{
$(".close").click(
		function()
		{
			$("div#message").hide();
		});
}

/**
 *
 * Display confirmation box when user
 * requests that information be deleted.
 *
 */
function handleDeletions()
{
$('#delete').click(
		function()
		{
			var confirmed = confirm("Are you sure you want to delete the selected item(s)? \nTHIS CANNOT BE UNDONE.");
				
			$('#action').val('delete');
				
			if (confirmed == true) 
				$('form').submit();
				
			return (false);
		});
}

/**
 *
 * Display confirmation box when user
 * submits requests to be converted to tasks.
 *
 */
function handleConversions()
{
$('#convert').click(
		function()
		{
			if ($('.reqCheck').serialize() != '')
			{
				var confirmed = confirm("Are you sure you want to convert the selected request(s) into tasks(s)?");
				
				$('#action').val('convert');
				
				if (confirmed == true) 
					$('form').submit();
				
				return (false);
			}
		});
}

/**
 *
 * Submit selected documents
 *
 */
function handleDocRenames()
{
$('#rename').click(
		function()
		{
			if ($('.docCheck').serialize() != '')
			{
				$("#documents").attr('action', 'documentRename.php');
				$("#documents").attr('method', 'get');
				$("#documents").submit();
			}
		});
}

/**
 *
 * Display confirmation box when user
 * rejects a request.
 *
 */
function handleRejections()
{
$('#reject').click(
		function()
		{
			if ($('.reqCheck').serialize() != '')
			{
				var confirmed = confirm("Are you sure you want to reject the selected request(s)?");
				
				$('#action').val('reject');
				
				if (confirmed == true) 
					$('form').submit();
				
				return (false);
			}
		});
}

/**
 *
 * Display confirmation box when user
 * requests that information be deleted.
 *
 */
function handleCommentDeletion()
{
$('.delete').click(
		function()
		{
			var confirmed= confirm("Are you sure you want to delete this comment?");
			
			if (confirmed == true)
			{
				var id      = $(this).attr('id');
				
				$('#commentToolbar'+id).toggleClass('disabledLink').text('Removing...');
				
				// Ajax call to delete page
				$.get('/app/commentDelete.php?id='+id, function(data)
				{ 
					// Hide comment
					$('#comment'+id).fadeOut('slow');
				});
			}
			
			return(false);
		});
}

/**
 *
 * Display confirmation box when user
 * requests that information be deleted.
 *
 */
function handleOpenIDDeletion()
{
$('.delete').click(
		function()
		{
			var id      = $(this).attr('id');
			var openID  = $(this).attr('rel');

			$('#'+id).toggleClass('disabledLink').text('Removing...');
			
			// Ajax call to delete page
			$.get('/app/openIDDelete.php?id='+openID, function(data)
			{ 
				// Hide OpenID
				$('#openid_'+id).fadeOut('slow');
			});
			
			return(false);
		});
}