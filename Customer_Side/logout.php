<?php
session_start();

if (isset($_SESSION)) {
    session_unset(); 
    session_destroy(); 
}

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirect to login page
header("Location: loginform.php");
exit();
?>
