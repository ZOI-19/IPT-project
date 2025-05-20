<?php
session_start();
$_SESSION = array();
session_destroy();

// Set a logout message
session_start();
$_SESSION['message'] = "You have been logged out successfully.";

// Redirect to the login page
header("Location: AdminLogin.php");
exit();
?>
