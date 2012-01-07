<?php

class teaser
{
	public function save($vars)
	{
		// Timestamp
		$timestamp = time();
		
		$dbh   = dbConnection::get()->handle();
		
		// Add Client Record
		$sql = "INSERT INTO pro_interested
				 ( firstname
				 , lastname
				 , email
				 , datetime
				 , ip
				 )
				 
				VALUES
				 ('{$vars['firstname']}'
				 ,'{$vars['lastname']}'
				 ,'{$vars['email']}'
				 ,'{$timestamp}'
				 ,'{$_SERVER['REMOTE_ADDR']}'
				 )";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Send Email Confirmation to the Person
		//
		// To Do...
		//
		
		return(true);
	}
}

?>