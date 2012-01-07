<?php

require_once ('lib/initialise.php');

// Start Footprint
$fp = new footprint;

// Authenticate User
$fp->authenticate();

// Destroy the session.
session_destroy();

// return to main page
header("Location: ../");
exit;

?>