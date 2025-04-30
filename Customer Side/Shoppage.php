<?php
// Start session
session_start();


include("IPTconnect.php"); 
include("IPTfunction.php"); 

// Check if user is logged in
$user_data = check_login($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop page</title>
    <!-- Button function -->
    <script src="IPTcartjava.js"> </script>

    <!-- style of the website -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Big+Shoulders:opsz,wght@10..72,100..900&family=Ponomar&display=swap');
html, body {
    background-color: white;
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.page {
    width: 100%;
    height: 130px;
    display: block;
}

.Navbar {    
    padding: 10px;
    border-block: 2px solid black;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}

.header2 {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.icon {
    height: 50px;
    width: 50px;
    border-radius: 50%;
    cursor: pointer;
}

.Searchbar {
    flex: 1;
    display: flex;
    justify-content: center;
    max-width: 400px;
}

.Searchbar input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.Menu, .Order {
    padding: 10px;
    border-radius: 10px;
    cursor: pointer;
    background-color: lightyellow;
    transition: 0.3s;
    font-weight: bold;
    text-align: center;
    width: 100px;
}

.Menu:hover, .Order:hover {
    background-color: yellow;
    color: orange;
}

.User-icon1{
    display: none;

}
.User-icon {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.product-section {
    margin: 10px;
    padding: 20px;
}

header{
    display: flex;
    justify-content: right;
    padding: 40px;
}

header .Cart{
    display: flex;
    position: relative;
}

header .Cart span{
    display: flex;
    width: 30px;
    height: 30px;
    background-color: yellow;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    right: -20px;
}

.Carttab{
    width: 400px;
    background-color: lightyellow;
    color: black;
    position: fixed;
    inset: 0 0 0 auto;
    display: grid;
    grid-template-rows: 70px 1fr 70px;
    transition: .5s;
}
.Carttab {
    transform: translateX(100%); /* Hide it initially */
}

body.showcart .Carttab {
    transform: translateX(0); /* Show when active */
}

.Carttab h1{
    padding: 20px;
    margin: 0;
    font-weight: bold;
}

.Carttab .btn{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
}

.Carttab .btn button{
    background-color: yellow;
    border: none;
    font-family: poppins;
    font-weight: 500;
    cursor: pointer;
}

.Carttab .btn .close{
    background-color: white;
}

.Carttab .Listcart .cart-item img{
    width: 100%;
}
.Carttab .Listcart .cart-item{
    display: grid;
    grid-template-columns: 70px 150fr 90px 1fr;
    align-items: center;
    text-align: center;
    gap: 10px;
}

.Listcart .quantity span{
    display: inline-grid;
    justify-content: center;
    align-items: center;
    width: 25px;
    height: 25px;
    background-color: white;
    color: black;
    border-radius: 50%;
    cursor: pointer;
}
.Carttab .quantity {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.Listcart .quantity span:nth-child(2){
    background-color: transparent;
    color: black;
}
.Listcart .quantity span:nth-child(even){
    background-color: white;
}

.Listcart{
    overflow: auto;
}

.Listcart::-webkit-scrollbar{
    width: 0;
    display: none;
}
.svg{
    width: 30px;
    height: 30px;
}

.product-container {
    background-color: lightyellow;
    display: flex;
    overflow-x: auto;
    white-space: nowrap;
    scroll-behavior: smooth;
    padding: 10px;
}

.product-container::-webkit-scrollbar {
    display: none;
}

.product-card {
    flex: 0 0 auto;
    width: 200px;
    height: 280px;
    margin: 5px;
    padding: 10px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.product-card img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
}

.add-to-cart {
    margin-top: 5px;
    padding: 6px;
    width: 100%;
    background-color: yellow;
    border: none;
    cursor: pointer;
    font-weight: bold;
    border-radius: 5px;
    transition: 0.5s;
}

.add-to-cart:hover{
    font-weight: bold;
    box-shadow: 5px 10px;
    color: orange;
}

footer {
    margin-top: 10px;
    border-top: 2px solid;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 10px;
    background-color: #f1f1f1;
    text-align: center;
}

footer div {
    flex: 1;
    margin: 5px;
}

@media (max-width: 400px) {
    .Navbar {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
    .header2 {
        gap: 10px;
        justify-content: center;
    }
    .Searchbar input{
        width: 90%;
    }
    .Searchbar {    
        left: 15px; /* Adjust as needed */
        width: 200px; /* Adjust for mobile */
    }

    .MnO{
        bottom: 10px;
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    
    .Wc {
        flex: 1;
        text-align: left;
    }
    .User-icon1{
        display: flex;
    }
    .User-icon {
        display: none;
    }

    .product-card {
        width: 130px;
    }

    .Carttab {
        width: 280px; /* Increase width */
    }

    .Carttab .Listcart .cart-item {
        grid-template-columns: 50px auto 50px 1fr; /* Adjust column widths */
        gap: 5px;
    }

    .Carttab .quantity {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px; /* Reduce gap for better spacing */
    }

    .Listcart .quantity span {
        width: 20px; /* Reduce button size */
        height: 20px;
        font-size: 14px; /* Ensure visibility */
    }
    footer {
        flex-direction: column;
        align-items: center;
    }
}

    </style>
</head>
<body>
    
    <section class="header1">
        <img src="img/deli.jpg" class="page" alt="Header Image">
    </section>

    <nav class="Navbar">
            <h3 class="Wc">Welcome! 😋</h3>
        <a href="logout.php"><div class="User-icon1">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M17 10v1.126c.367.095.714.24 1.032.428l.796-.797 1.415 1.415-.797.796c.188.318.333.665.428 1.032H21v2h-1.126c-.095.367-.24.714-.428 1.032l.797.796-1.415 1.415-.796-.797a3.979 3.979 0 0 1-1.032.428V20h-2v-1.126a3.977 3.977 0 0 1-1.032-.428l-.796.797-1.415-1.415.797-.796A3.975 3.975 0 0 1 12.126 16H11v-2h1.126c.095-.367.24-.714.428-1.032l-.797-.796 1.415-1.415.796.797A3.977 3.977 0 0 1 15 11.126V10h2Zm.406 3.578.016.016c.354.358.574.85.578 1.392v.028a2 2 0 0 1-3.409 1.406l-.01-.012a2 2 0 0 1 2.826-2.83ZM5 8a4 4 0 1 1 7.938.703 7.029 7.029 0 0 0-3.235 3.235A4 4 0 0 1 5 8Zm4.29 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h6.101A6.979 6.979 0 0 1 9 15c0-.695.101-1.366.29-2Z" clip-rule="evenodd"/>
            </svg>
        </div></a>

        <div class="header2">
            <a href="landingpage.php">
                <img src="img/SSD.jfif" class="icon">
            </a>
            <a href="landingpage.php">
                <img src="img/SSD1.png" class="icon">
            </a>
            <div class="Searchbar">
                <input type="text" id="search-item" placeholder="Search products" onkeyup="search()">

            </div>
            <div class="MnO">
                <button class="Menu"><li>Menu</li></button>
                <button class="Order"><li>Order</li></button>
            </div>
        </div>
        <a href="logout.php"><div class="User-icon">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M17 10v1.126c.367.095.714.24 1.032.428l.796-.797 1.415 1.415-.797.796c.188.318.333.665.428 1.032H21v2h-1.126c-.095.367-.24.714-.428 1.032l.797.796-1.415 1.415-.796-.797a3.979 3.979 0 0 1-1.032.428V20h-2v-1.126a3.977 3.977 0 0 1-1.032-.428l-.796.797-1.415-1.415.797-.796A3.975 3.975 0 0 1 12.126 16H11v-2h1.126c.095-.367.24-.714.428-1.032l-.797-.796 1.415-1.415.796.797A3.977 3.977 0 0 1 15 11.126V10h2Zm.406 3.578.016.016c.354.358.574.85.578 1.392v.028a2 2 0 0 1-3.409 1.406l-.01-.012a2 2 0 0 1 2.826-2.83ZM5 8a4 4 0 1 1 7.938.703 7.029 7.029 0 0 0-3.235 3.235A4 4 0 0 1 5 8Zm4.29 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h6.101A6.979 6.979 0 0 1 9 15c0-.695.101-1.366.29-2Z" clip-rule="evenodd"/>
            </svg>
        </div></a>
    </nav>
        <header>
            <div class="Cart" onclick="click">
            <svg  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/></svg>
            <span>0</span>

            </div>
        </header>
    <div class="Carttab">
        <h1>Shopping cart</h1>
        <div class="Listcart">
            <div class="cart-item">
                <div class="image">
                    <img src="img/SALTY.jpg" alt="Sweets 1">
                </div>
                <div class="name">NAME</div>
                <div class="totalPrice">P100</div>
                <div class="quantity">
                    <span class="minus">-</span>
                    <span>1</span>
                    <span class="plus">+</span>
                </div>
            </div>
        </div>
        <div class="btn">
            <button class="close">CLOSE</button>
            <button class="checkout">CHECK OUT</button>
        </div>
    </div>

        </div>
    <div class="product-section">
        <h2>Best Seller</h2>
        <div class="product-container" id="product-container">
            <div class="product-card" >
                <img src="img\BEANS.jpg" alt="Product 1">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\BEANS.jpg" alt="Product 1">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\BEANS.jpg" alt="Product 3">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\BEANS.jpg" alt="Product 4">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\BEANS.jpg" alt="Product 5">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\BEANS.jpg" alt="Product 6">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\BEANS.jpg" alt="Product 7">
                <h2>Beans</h2>
                <p >P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\BEANS.jpg" alt="Product 8">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\BEANS.jpg" alt="Product 9">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>

            <!-- Add more products here -->
        </div>
        <button class="scroll-btn scroll-left" onclick="scrollLeft()">◀</button>
        <button class="scroll-btn scroll-right" onclick="scrollRight()">▶</button>
        </div>
    </div>

    <div class="product-section">
        <h2>Sweets</h2>
        <div class="product-container">
            <div class="product-card">
                <img src="img\SALTY.jpg" alt="Sweets 1">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg" alt="Sweets 2">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg" alt="Sweets 3">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg" alt="Sweets 4">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg" alt="Sweets 5">
                <h2>sweet</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg" alt="Sweets 6">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg" alt="Sweets 7">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg" alt="Sweets 8">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg" alt="Sweets 9">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>

            <!-- Add more products here -->
        </div>
        <button class="scroll-btn scroll-left" onclick="scrollLeft()">◀</button>
        <button class="scroll-btn scroll-right" onclick="scrollRight()">▶</button>
    </div>

    <div class="product-section">
        <h2>Salty</h2>
        <div class="product-container">
            <div class="product-card">
                <img src="img\SALTY.jpg"alt="Salty 1">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg"alt="Salty 2">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg"alt="Salty 3">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg"alt="Salty 4">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg"alt="Salty 5">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg"alt="Salty 6">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg"alt="Salty 7">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg"alt="Salty 8">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="img\SALTY.jpg"alt="Salty 9">
                <h2>Beans</h2>
                <p>P100</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>

            <!-- Add more products here -->
        </div>
        <button class="scroll-btn scroll-left" onclick="scrollLeft()">◀</button>
        <button class="scroll-btn scroll-right" onclick="scrollRight()">▶</button>
    </div>

  <!-- Footer -->
  <footer>
    <h4>About us</h4>
    <small>Welcome to [Your Pasalubong Center’s Name], your one-stop shop for the best Filipino snacks and delicacies! We take pride in bringing you the rich flavors of the Philippines, offering a wide variety of locally made treats that capture the essence of our culture and traditions.</small>
    <div>   
      <h3>Address:</h3>
      <small>Plaza Binondo, Baliuag, Philippines, 3006</small>
    </div>
    <div>
      <h3>Phone:</h3>
      <small>0915 236 15283</small>
    </div>
    <div>
      <h3>Social Media:</h3>
      <small>Delizeus Kai Food Products </small>
    </div>
  </footer>
</body>
</html>