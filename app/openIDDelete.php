<?php

require_once ('lib/initialise.php');

// Start Footprint
$fp     = new footprint;
$openID = new openid;

// Authenticate User
$fp->authenticate();

// Check ID was submitted in GET
if(!empty($_GET))
{
	if(isset($_GET['id']))
	{
		// Instantiate Class
		$openID->setOpenID($_GET['id']);
		$openID->setAccID($_SESSION['user']['accID']);
		$openID->setUserID($_SESSION['user']['userID']);
		
		// Check User has permission to delete the comment		
		if($openID->isOwner($_GET['id']))
		{
			$openID->detachOpenID();
		}
	}
}
?>