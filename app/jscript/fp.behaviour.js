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