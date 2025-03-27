<?php
include 'IPTconnect.php'; // Connect to DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Check if email already exists
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check_email);
    
    if (mysqli_num_rows($result) > 0) {
        echo "Email already registered. <a href='signupform.php'>Try again</a>";
        exit;
    }

    // Insert user data
    $query = "INSERT INTO users (fname, lname, email, password) VALUES ('$fname', '$lname', '$email', '$password')";
    if (mysqli_query($conn, $query)) {
        // Redirect to login page after successful signup
        header("Location: loginform.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
