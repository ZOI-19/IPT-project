<?php
include 'IPTconnect.php';   

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

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
        echo "Signup successful! <a href='loginform.php'>Login here</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup Page</title>

<!-- Signup Style -->
<style>

body {
    background-image: url('img/bakcgroud.jpg');
    background-position: center;
    background-size: contain;
    background-repeat: repeat;
    background-attachment: fixed;
    backdrop-filter: blur(10px);
    width: 100%;
    height: 100vh; 
    display: flex;
    justify-content: center;    
    align-items: center;
    font-family: Arial, sans-serif;
    box-sizing: border-box;
}

.container {
    background: white;
    display: flex;   
    align-items: center;
    justify-content: space-between;
    width: 90%;
    max-width: 550px; /* Responsive width */
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    flex-direction: row;
}

.left {
    flex: 1; 
    text-align: center;
}

.loginimg {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
}

.right {
    flex: 1; 
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-left: 30px;
}

.right h2 {
    margin-bottom: 15px;
}

.input-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.login-btn {
    background: yellow;
    border: none;
    padding: 10px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    font-weight: bold;
}

.register {
    margin-top: 10px;
    font-size: 14px;
}

.register a {
    font-weight: bold;
    text-decoration: none;
    color: black;
}

/* Responsive Design */
@media (max-width: 600px) {
    .container {
        flex-direction: column;
        text-align: center;
        padding: 1.5rem;
    }

    .left, .right {
        padding-left: 0;
    }

    .loginimg {
        width: 120px;
        height: 120px;
    }

    input, .login-btn {
        font-size: 14px;
        padding: 8px;
    }

    .register {
        font-size: 12px;
    }
}
</style>
</head>
<body>

    <div class="container">
        <div class="left">
            <h3>Deli Zeus Kai Food Products</h3>
            <a href="landingpage.php"><img src="img/SSD.jfif" class="loginimg"></a>
        </div>

        <div class="right">
            <h2>Signup</h2>
            <form action="signupregisterIPT.php" method="POST">
                <div class="input-container">
                    <input type="text" name="fname" placeholder="First Name" required>
                    <input type="text" name="lname" placeholder="Last Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>

                    <button type="submit" class="login-btn">Create</button>
                </div>
            </form>
            <p class="register">Already have an account? <a href="loginform.php">Login</a></p>
        </div>
    </div>

</body>
</html>
