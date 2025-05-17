<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
session_start();
include 'IPTconnect.php'; // Connect to DB

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Retrieve user from DB
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fname'] = $user['fname'];

            header("Location: Dashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password.'); window.location='loginform.php';</script>";
        }
    } else {
        echo "<script>alert('User not found. Please register first.'); window.location='signupform.php';</script>";
    }
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login Page</title>

    <script src="logingoogleadmin.js" defer type="module"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/webfont/1.6.28/webfontloader.js">
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/4.0.0/iconfont/material-icons.min.css">
    <!--  Login Style -->
    <style>

    body {
        background-image: url('image/bakcgroud.jpg');
        background-position: center;
        background-repeat: repeat;
        background-attachment: fixed;
        background-size: contain;
        backdrop-filter: blur(5px);
        width: 100%;
        height: 100vh; 
        display: flex;
        justify-content: center;       
        align-items: center;
        font-family: Arial, sans-serif;
        padding: 10px;
        box-sizing: border-box;
    }

    .container {
        background: white;
        display: flex;   
        align-items: center;
        justify-content: space-between;
        width: 90%;
        max-width: 550px; /* Adjust width */
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
        border-left: 2px solid;
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
    .google{
        padding: 5px;
        background-color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 20px;
        cursor: pointer;
    }
    .google img{
        padding: 5px;
        width: 20px;
    }
    /* Responsive Design */
    @media (max-width: 500px) {

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
                <h2>Welcome Admin!</h2>
                <h3>Deli Zeus Kai Food Products</h3>
                <img src="image/SSD.jfif" class="loginimg">
            </div>

            <div class="right">
                <h2>Login</h2>
                <form action="AdminLogin.php" method="POST">
                    <div class="input-container">
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit" class="login-btn">Login</button>
                    </div>
                </form>
                <p class="register">Don't have an account? <a href="signupform.php">Register</a></p>
                <button class="google" id="google-login-btn" >
                    <img src="image/Search.png">Login with google
                </button>

            </div>
        </div>

    </body>
    </html>
