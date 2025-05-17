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
      .cartTab.active {
          display: block; /* Show cart when active */
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

          </div>
          <div class="btn">
              <button class="close">Close</button>
              <a href="checkoutpage.php"><button class="CheckOut">Checkout</button></a>
          </div>
      </div>

<script>
    // Function to toggle the cart visibility
    function toggleCart() {
        const cartTab = document.querySelector('.cartTab');
        cartTab.classList.toggle('active'); // Toggle the visibility of the cart
        loadCartFromStorage(); // Load cart items when opening the cart
    }

    // Event listener for the Cart button
    document.getElementById('cart-tab-btn').addEventListener('click', function() {
    console.log("Cart button clicked!"); // Add this line
    toggleCart();
});


    // Function to load cart items from local storage
    function loadCartFromStorage() {
        let listCart = JSON.parse(localStorage.getItem("myCart")) || [];
        const cartContainer = document.querySelector(".listCart");
        cartContainer.innerHTML = ""; // Clear previous content

        if (listCart.length === 0) {
            cartContainer.innerHTML = "<p>Your cart is empty.</p>";
            return;
        }

        listCart.forEach((item, index) => {
            cartContainer.innerHTML += `
                <div class="item">
                    <div class="image"><img src="${item.image}" alt="${item.name}"></div>
                    <div class="name">${item.name}</div>
                    <div class="totalPrice">₱ ${(item.price * item.quantity).toFixed(2)}</div>
                    <div class="quantity">
                        <span onclick="updateQuantity(${index}, -1)">-</span>
                        <span>${item.quantity}</span>
                        <span onclick="updateQuantity(${index}, 1)">+</span>
                    </div>
                </div>`;
        });
    }

    // Function to update the quantity of items in the cart
    function updateQuantity(index, change) {
        let listCart = JSON.parse(localStorage.getItem("myCart")) || [];
        listCart[index].quantity += change;

        // Remove item if quantity is 0 or less
        if (listCart[index].quantity <= 0) {
            listCart.splice(index, 1);
        }
        localStorage.setItem("myCart", JSON.stringify(listCart));
        loadCartFromStorage(); // Refresh the cart display
    }

    // Load cart items when the page is loaded
    document.addEventListener("DOMContentLoaded", loadCartFromStorage);
</script>

    
  </body>
  </html>
