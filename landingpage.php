<?php
function check_login($conn) {
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
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
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DELEzEUS KAI'S FOOD PRODUCT</title>
  <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      text-align: center;
      max-width: 100%;
      overflow-x: hidden;
    }

    h2 {
      font-size: 24px;
      text-align: center;
      padding: 10px;
      background-color: lightyellow;
      border-radius: 10px;
    }

    /* Header */
    .page {
      width: 100%;
      height: 130px;
      display: block;
      border-bottom: 1px solid;
    }

    /* Hero Section */
    .hero {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
      width: 100%;
    }

    .hero img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .hero-text {
      text-align: center;

    }

    .hero-text img {
      width: 90%;
      max-width: 300px;
      border-radius: 10px;
    }

    .hero-text button {
      margin-top: 15px;
      padding: 10px 20px;
      background-color: yellow;
      border: none;
      font-weight: bold;
      cursor: pointer;
      border-radius: 5px;
      transition: 0.5s;
    }

    .hero-text button:hover{
      box-shadow: 5px 10px orange;
      color: orange;
      font-weight: bold;
    }

    /* ✅ Fully Responsive Gallery */
    .gallery {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
      max-width: 100%;
      padding: 10px;
      margin-top: 20px;
    }

    .gallery img {
      width: 100%;
      height: 140px;
      object-fit: cover;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Call-To-Action */
    .cta {
      display: flex;
      justify-content: start;
      margin-top: 20px;
      padding: 10px;
      margin-bottom: 10px;
    }

    .cta button {
      padding: 10px 20px;
      background-color: yellow;
      border: none;
      font-weight: bold;
      cursor: pointer;
      border-radius: 5px;
      transition: 0.5s;
    }


    /* Footer */
    footer {
      margin-top: 20px;
      width: 100%;
      background-color: #f1f1f1;
      padding: 15px;
      text-align: center;
    }

    /*  Mobile Responsive Adjustments */
    @media (min-width: 700px) {
      .hero {
        flex-direction: row;
        justify-content: space-around;
        width: 80%;
        text-align: left;
      }

      .hero img {
        width: 180px;
        height: 120px;
      }

      .Food-Image{
        height: 200px;
        width: 120px;
      }

      .hero-text h2 {
        font-size: 28px;
      }

      .gallery {
        grid-template-columns: repeat(3, 1fr);
      }

      .gallery img {
        height: 180px;
      }


      .cta button:hover{
      box-shadow: 5px 10px orange;
      color: orange;
      font-weight: bold;
      }

      footer {
        border-top: 2px solid;
        margin-top: 20px;
        display: flex;
        justify-content: space-around;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <img src="img/deli.jpg" class="page" alt="Header Image">

  <!-- Hero Section -->
  <section class="hero">
    <img src="img/SSD.jfif" alt="Icon">
    <div class="hero-text">
      <img src="img/fp.jpg" alt="Food-Image">
      <h2 class="">We provide the best food for you</h2>
      <a href="signupform.php"><button class="GS">Get Started</button></a>
    </div>
  </section>

  <!-- Gallery Section -->
  <div class="gallery">
    <img src="img/FP1.jpg" alt="Item 1">
    <img src="img/FP2.jpg" alt="Item 2">
    <img src="img/FP3.jpg" alt="Item 3">
    <img src="img/FP4.jpg" alt="Item 4">
    <img src="img/FP5.jpg" alt="Item 5">
    <img src="img/FP6.jpg" alt="Item 6">
  </div>

  <!-- Call-To-Action -->
  <section class="cta">
    <a href="signupform.php"><button>Buy Now</button></a>
  </section>

  <!-- Footer -->
  <footer>
    <h3>Address:</h3>
    <p>Plaza Binondo, Baliuag, Philippines, 3006</p>
    <h3>Phone:</h3>
    <p>0916-236-1123</p>
    <h3>Social Media:</h3>
    <p>Del Zeus Kai Food Products</p>
  </footer>

</body>
</html>
