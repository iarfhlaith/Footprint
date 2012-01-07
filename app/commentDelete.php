<?php

require_once ('lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Authenticate User
$fp->authenticate();

// Check ID was submitted in GET
if(!empty($_GET))
{
	if(isset($_GET['id']) && is_numeric($_GET['id']))
	{
		// Create Comment Object
		$fp->comment = new comment;
		
		// Check User has permission to delete the comment		
		if($fp->comment->isAuthor($_GET['id'], $_SESSION['user']['userID']))
		{
			// Delete the comment
			$fp->comment->delete($_GET['id']);
		}
	}
}
?>