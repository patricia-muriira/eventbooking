<?php
// Start session
session_start();

// Clear all session data
$_SESSION = array();

// Destroy session
session_destroy();

// Redirect to login page
header("Location: ../index.php");
exit;
?>