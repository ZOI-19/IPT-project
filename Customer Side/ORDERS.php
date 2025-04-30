<?php
// Start session
session_start();


include("IPTconnect.php"); 
include("IPTfunction.php"); 

// Check if user is logged in
$user_data = check_login($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Document</title>
  <style>
    .page {
      width: 100%;
      height: 130px;
      display: block;
    }

    .navBar ul {
      display: flex;
      list-style: none;
      gap: 50px;
      padding: 0;
      margin: 0;
      align-items: center;
      border-bottom: 2px solid;
      justify-content: center;
    }

    .navBar ul li {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
    }

    .navBar ul li img {
      display: flex;
      height: 50px;
      width: 50px;
      border-radius: 50%;
      position: relative;
      justify-self: flex-start;
      float: inline-start;
    }

    .Categories {
      width: 100%;
      display: flex;
      justify-content: center;
      margin-top: 10px;
    }

    .Categories ul {
      display: flex;
      list-style: none;
      gap: 40px;
      align-items: center;
      justify-content: center;
      margin: 0;
      border-bottom: 2px solid #ccc;
    }

    .Categories ul li {
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      position: relative;
    }

    .Categories ul li::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: -5px;
      width: 0;
      height: 3px;
      background-color: yellow;
      transition: width 0.3s ease-in-out;
    }

    .Categories ul li:hover::after {
      width: 100%;
    }

    .Searchbar {
      display: flex;
      width: 50%;
    }

    .Searchbar input {
      width: 500px;
      height: 30px;
      border-radius: 10px;
    }

    .container {
      width: 900px;
      max-width: 90vw;
      margin: auto;
      text-align: center;
      padding-top: 10px;
      transition: transform 0.5s;
    }

    .cartTab {
      display: none; /* Hides cart by default */
    }

    .cartTab .listCart {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .cartTab .listCart .item {
      display: flex;
      gap: 10px;
      text-align: center;
      align-items: center;
      justify-content: space-between;
      padding: 10px;
      border-bottom: 2px solid #ddd;
    }

    .cartTab .listCart .item .image,
    .cartTab .listCart .item .name,
    .cartTab .listCart .item .totalPrice,
    .cartTab .listCart .item .quantity {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .cartTab .listCart .item .image img {
      width: 70px;
      height: 70px;
      object-fit: cover;
      filter: drop-shadow(0 5px 5px #132013);
    }

    .cartTab .listCart .item .quantity {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
    }

    .cartTab .listCart .item .quantity span {
      display: inline-block;
      width: 25px;
      height: 25px;
      background-color: #eee;
      color: #555;
      border-radius: 50%;
      cursor: pointer;
    }

    .cartTab .listCart .item .quantity span::nth-child(2) {
      background-color: transparent;
      color: #eee;
    }

    .btn {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
    }

    .btn button {
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn button:hover {
      background-color: #0056b3;
    }
@media screen and (max-width: 650px) {
    .page{
        margin-bottom: 10px;
    }
    .navBar ul {
        justify-content: center;
        gap: 20px;
        border-bottom: 1px solid;
        align-items: center ;
    }

    .navBar ul li {
        font-size: 16px;
    }

    .Categories ul {
        justify-content: center;
        gap: 30px;
        padding: 0 10px;
        align-items: center;
    }

    .Categories ul li {
        font-size: 16px;
    }

    .Searchbar input {
        width: 100%;
    }

    .container {
        width: 100%;
        padding: 10px;
    }

    .cartTab .listCart .item {
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .cartTab .listCart .item .image img {
        width: 50px;
        height: auto;
    }

    .cartTab .listCart .item .image,
    .cartTab .listCart .item .name,
    .cartTab .listCart .item .totalPrice,
    .cartTab .listCart .item .quantity {
        justify-content: flex-start;
    }

    .btn {
        justify-content: center;
        align-items: center;
    }

    .btn button {
        width: 100%;
    }
    }

  </style>
</head>
<body>
  <section class="header1">
    <img src="img/deli.jpg" class="page" alt="Header Image"/>
  </section>
  <nav class="navBar">
    <ul class="navbtn">
      <li>
        <a href="landingpage3.php">
          <img src="img/SSD.jfif" alt="Logo"/>
        </a>
      </li>
      <li>
        <a href="Shoppage2.php">Home</a>
      </li>
      <li>
        <a href="#">Orders</a>
      </li>
      <li>
        <a href="#">
          <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
               xmlns="http://www.w3.org/2000/svg" width="24" height="24"
               fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2"
                  d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0
                  4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951
                  3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
          </svg>
        </a>
      </li>
    </ul>
  </nav>
  

  <div class="container">
    <nav class="Categories">
      <ul>
        <li id="cart-tab-btn">Cart</li>
        <li id="Pendin-btn">Pending</li>
        <li id="to-ship-btn">to ship</li>
        <li id="shipped-btn">Shipped</li>
        <li id="to-review btn">To review</li>
      </ul>
    </nav>

    <div class="cartTab">
      <h1>Shopping Cart</h1>
      <div class="listCart">
        <div class="item">
          <div class="image">
            <img class="picture" src="img/BEANS.jpg" alt="" />
          </div>
          <div class="name">NAME</div>
          <div class="totalPrice">$200</div>
          <div class="quantity">
            <span class="minus">-</span>
            <span>1</span>
            <span class="plus">+</span>
          </div>
        </div>
      </div>
      <div class="btn">
        <button class="close">Close</button>
        <button class="CheckOut">Checkout</button>
      </div>
    </div>
  </div>

  <script>
    // Show cartTab on clicking Cart
    document.getElementById("cart-tab-btn").addEventListener("click", function () {
      const cartTab = document.querySelector(".cartTab");
      cartTab.style.display = "block";
    });

    // Optional: Close button to hide it
    document.querySelector(".close")?.addEventListener("click", function () {
      document.querySelector(".cartTab").style.display = "none";
    });
  </script>
  <script src="IPTcartjava2.js"></script>
  <script>
document.addEventListener("DOMContentLoaded", function () {
    const cartContainer = document.querySelector(".listCart");
    if (!cartContainer) return;

    const cartData = localStorage.getItem("cart");

    if (!cartData) {
        cartContainer.innerHTML = "<p>Your cart is empty.</p>";
        return;
    }

    fetch("products.json")
        .then(response => response.json())
        .then(products => {
            const cart = JSON.parse(cartData);
            cartContainer.innerHTML = "";

            cart.forEach(item => {
                const product = products.find(p => p.id == item.product_id);
                if (product) {
                    cartContainer.innerHTML += `
                        <div class="item" data-id="${item.product_id}">
                            <div class="image"><img src="${product.image}" alt="${product.name}"></div>
                            <div class="name">${product.name}</div>
                            <div class="totalPrice">$${product.price * item.quantity}</div>
                            <div class="quantity">
                                <span>${item.quantity}</span>
                            </div>
                        </div>
                    `;
                }
            });
        })
        .catch(error => {
            console.error("Failed to load products:", error);
            cartContainer.innerHTML = "<p>Error loading products.</p>";
        });
});
</script>

</body>
</html>
