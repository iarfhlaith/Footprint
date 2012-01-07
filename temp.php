<?php

function extractNames($fullName, $whichName)
{
	$gap = stripos($fullName, ' ');
	
	if($whichName == 'firstname')
	{
		if(!is_numeric($gap)) return($fullName);
		
		return(substr($fullName, 0, $gap));
	}
	elseif($whichName == 'lastname')
	{
		if(!is_numeric($gap)) return('');
		
		$lastLength = strlen($fullName) - $gap;
		return(substr($fullName, $gap+1, $lastLength));
	}
}

$name = "Iarfhlaith Paul Anthony Kelly";

$firstname = extractNames($name, 'firstname');
$lastname  = extractNames($name, 'lastname');

echo('<strong>Original Name: '.$name.'</strong>');
echo('<br /><br />Firstname: '.$firstname);
echo('<br /><br />Lastname:  '.$lastname);

?>