<?php
session_start();
include 'IPTconnect.php'; // Connect DB
include 'IPTfunction.php'; // Optional if you need functions

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if user exists
    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Start Session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fname'] = $user['fname'];

        echo "success";
    } else {
        // User not found ➔ Auto-register Google user
        $fname = "GoogleUser"; // Optional: Get real name from Firebase if you want
        $password = password_hash('default_google_password', PASSWORD_DEFAULT); // Dummy password

        $insert = "INSERT INTO users (fname, email, password) VALUES ('$fname', '$email', '$password')";
        if (mysqli_query($conn, $insert)) {
            $new_id = mysqli_insert_id($conn);
            $_SESSION['user_id'] = $new_id;
            $_SESSION['fname'] = $fname;
            echo "success";
        } else {
            echo "Failed to register user.";
        }
    }
} else {
    echo "Invalid request.";
}
?>
