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


// Get the posted data
$address = $_POST['address'] ?? '';
$house_number = $_POST['house_number'] ?? '';
$barangay_name = $_POST['barangay_name'] ?? '';
$municipality = $_POST['municipality'] ?? '';

// Update the user's address in the database
$query = "UPDATE users SET address = ?, house_number = ?, barangay_name = ?, municipality = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $address, $house_number, $barangay_name, $municipality, $user_id); // Use $user_id instead of $user_data['id']
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Address updated successfully!";
} else {
    echo "Error updating address: " . mysqli_error($conn);
}

// Redirect back to account page or wherever needed
header("Location: Account.php");
exit();

?>
