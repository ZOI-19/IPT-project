<?php
session_start();
include("IPTconnect.php");

// Fetch user data from session or request
$user_id = $_SESSION['user_id'];
$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';

// Update query
$query = "UPDATE users SET fname = '$first_name', lname = '$last_name', email = '$email'";
if ($password) {
    $query .= ", password = '$password'"; // Only update password if provided
}
$query .= " WHERE id = '$user_id'";

// Execute the update
if (mysqli_query($conn, $query)) {
    echo "Settings updated successfully!";
} else {
    echo "Error updating settings: " . mysqli_error($conn);
}
?>
