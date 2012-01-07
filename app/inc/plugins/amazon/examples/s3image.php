<?php
require_once('Crypt/HMAC.php');
require_once 'HTTP/Request.php';
require_once('../class.s3.inc.php');

$bucket = 'footprint';

$s3     = new s3();

$key    = $_GET['key']; 

$info   = $s3->getObjectInfo($key, $bucket);

// Output the MIME header
header("Content-Type: {$info['content-type']}");

print($s3->getObject($key, $bucket));

?>