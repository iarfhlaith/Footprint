<?php
require_once('Crypt/HMAC.php');
require_once 'HTTP/Request.php';
require_once('../class.s3.inc.php');

$bucket = 'footprint';

$s3    = new s3();
$list  = $s3->getObjects($bucket, 'screenshots');

preg_match_all("/\<Key\>(.*?)\<\/Key\>/", $list, $found);
?>

<html>
<body>

<h1><?=$bucket?></h1>

<ul>
<?php

foreach($found[1] as $key)
{
	$image = $s3->getObject($key, $bucket);
	
	echo '<li>'.$key.'</li>';
	echo '<li><img src="s3image.php?key='.$key.'"></li>';
}

?>
</ul>

</body>
</html>