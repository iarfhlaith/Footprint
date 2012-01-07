<?php
/**
 *
 * Generate Invitation Codes 100 at a time.
 * 
 *
 **/

/*
require_once ('../app/lib/initialise.php');

// Force Error Level
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'on');

$dbh   = dbConnection::get()->handle();

for($i=0; $i<100; $i++)
{
	$code = generateInviteCode();
	
	echo ('<br>'.$code);
	
	$sql = "INSERT INTO pro_invitations (code) VALUES ('{$code}')";
	
	$affected =& $dbh->exec($sql);
	if (PEAR::isError($affected)) return(false);
}

function generateInviteCode($length=6)
{
	$pass = '';
	$salt = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
	
	$saltLength = strlen($salt);
	
	mt_srand((double)microtime()*1000000);
	
	for($i = 0; $i < $length; $i++)
	{
		$pass .= $salt[mt_rand(0,$saltLength-1)];
	}
	
	return($pass);
}
*/
?>