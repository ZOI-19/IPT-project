<?php
session_start();

// Include your database connection (edit the filename if different)
include("IPTconnect.php");

// Check if user is logged in
function check_login($conn) {
    if (isset($_SESSION['user_id'])) {
        $id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
        $query = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }

    // If not logged in, redirect to login
    header("Location: loginform.php");
    exit();
}

// Optional: uncomment this if you want to restrict this page to logged-in users
// $user_data = check_login($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f4f4f4;
        }
        .header img {
            height: 100px;
            width: 100%;
            display: block;
        }
        .Icon1 {
            position: absolute;  
            top: 10px;           
            left: 10px;          
            height: 50px;
            width: 50px;
            border-radius: 50%;
            z-index: 10;        
        }
        .SI {
            position: absolute;  
            top: 10px;           
            right: 10px;         
            height: 50px;
            width: 50px;
            cursor: pointer;
            z-index: 10;
            background-color: transparent; 
            padding: 10px; 
            width: 100px; 
        }

        .SI::after,
        .SI::before {
          content: '';
          position: absolute;
          width: 100%;
          height: 2px;
          background: linear-gradient(to right, #ff0000, #00ffff);
          bottom: -5px;
          left: 0;
          transform: scaleX(0);
          transform-origin: right;
          transition: transform 0.4s ease-out;
          border: none;
        }

        .SI::before {
          top: -5px;
          transform-origin: left;
        }

        .SI:hover::after,
        .SI:hover::before {
          transform: scaleX(1);
        }
        .container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100vh;
            padding: 50px;
            background-image: url('img/FP9.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: left;
            gap: 30px;
        }

        nav {
            position: absolute;
            top: 0;
            right: 20px;
            padding: 10px 20px;
            border-radius: 10px;
        }

        nav ul {
            list-style: none;
            display: flex;
            align-items: center;  
            justify-content: center; 
            gap: 20px;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            display: flex;
            align-items: center;        
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 1.1em;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        nav ul li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .left-content {
            flex: 1; 
            display: flex;
            flex-direction: column;
            justify-content: center; 
            align-items: center; 
            gap: 25px;
            background: rgba(15, 26, 3, 0.7);
            padding: 20px;
            border-radius: 25px;
            border: 2px solid black;
            text-align: center;
        }

        .text-content {
            flex: 1; 
            background: rgba(15, 26, 3, 0.7);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transform: translateY(-20px);
        }

        .gallery {
            position: relative;
            width: 300px; 
            height: 250px;
            overflow: hidden;
            border-radius: 10px;
            border: 3px solid white;
        }

        .gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute; 
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .gallery img.active {
            opacity: 1;
        }

        .description {
            max-width: 500px;
            font-size: 0.9em;
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: justify;
            line-height: 1.1;
        }

        .text-content {
            flex: 1;
            background: rgba(15, 26, 3, 0.7);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transform: translateY(-20px);
        }

        .text-content img {
            display: block;
            border: white 2px solid; 
            margin: 0 auto; 
            border-radius: 50%;
            height: 150px;
            width: 150px;
        }

        .text-content h2 {
            font-size: 2em;
            color: #fff;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            border-radius: 5px;
            margin-top: 10px;
        }
        footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            width: 100%;
            background-color: #f1f1f1;
            padding: 20px;
            text-align: center;
        }

        .btn:hover {
            background-color: #218838;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 20px;
                height: auto;
                min-height: 100vh;
            }

            .left-content,
            .text-content {
                max-width: 90%;
                width: 100%;
                margin-bottom: 20px;
                align-items: center;
            }

            .gallery {
                width: 100%;
                height: 300px;
            }

            .description {
                max-width: 100%;
                font-size: 1em;
                text-align: justify;
            }

            .text-content h2 {
                font-size: 1.8em;
            }

            .btn {
                font-size: 1em;
                padding: 8px 16px;
            }
        }

    </style>
</head>
<body>
    <section class="header">
        <img src="img/deli.jpg" alt="Header Image">
    </section>
    <div class="container">
        <img src="img/SSD.jfif" alt="Icon" class="Icon1">
        <nav>
            <ul>
                <li><a href="loginform.php">Sign In</a></li>
            </ul>
        </nav>

        <div class="left-content">
            <div class="gallery">
                <img src="img/FP1.jpg" class="active" alt="Item 1">
                <img src="img/FP2.jpg" alt="Item 2">
                <img src="img/FP3.jpg" alt="Item 3">
                <img src="img/FP4.jpg" alt="Item 4">
                <img src="img/FP5.jpg" alt="Item 5">
                <img src="img/FP6.jpg" alt="Item 6">
            </div>
            
        <p class="description">
            Welcome to <strong>Pasalubong Center</strong>, your trusted destination for high-quality delicacies that bring the warmth of home to your loved ones.
            Whether you’re a traveler looking for the perfect local treat or sharing the taste of home, we provide thoughtfully curated <em>pasalubong</em> items that celebrate our culture and heritage.
            Each product is handpicked to ensure exceptional quality. Discover the joy of thoughtful giving at <strong>Pasalubong Center</strong>—where every item is worth sharing.
        </p>


        </div>

        <div class="text-content">
            <img src="img/fp.jpg" class="icon">
            <h2>We provide the best food for you.</h2>
            <a href="loginform.php" class="btn">Get Started Now</a>
        </div>
    </div>
<footer>
    <h3>Address:</h3>
    <p>Plaza Binondo, Baliuag, Philippines, 3006</p>
    <h3>Phone:</h3>
    <p>0916-236-1123</p>
    <h3>Social Media:</h3>
    <p>Del Zeus Kai Food Products</p>
</footer>
    <script>
        let index = 0;
        const images = document.querySelectorAll('.gallery img');

        function slideShow() {
            images.forEach((img, i) => {
                img.classList.remove('active');
                if (i === index) {
                    img.classList.add('active'); 
                }
            });
            index = (index + 1) % images.length; 
        }

        setInterval(slideShow, 3000);
        slideShow(); 
    </script>
</body>
</html>
