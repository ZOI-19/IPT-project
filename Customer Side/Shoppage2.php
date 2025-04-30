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
        <title></title>
    <style type="text/css">

    @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    body{

        font-family: 'Courier New', Courier, monospace;
        margin: 0;
        background-color: rgb(233, 226, 226);
    }
    .page {
        width: 100%;
        height: 130px;
        display: block;
    }
    .navBar ul {
        display: flex; /* Aligns list items in a row */
        list-style: none; /* Removes bullet points */
        gap: 50px; /* Space between items */
        padding: 0;
        margin: 0;
        align-items: center; /* Centers items vertically */
        border-bottom: 2px solid   ;
        justify-content: center;
    }

    .navBar ul li {
        display: flex; /* Enables flexbox inside <li> */
        align-items: center; /* Centers items vertically */
        gap: 10px; /* Adds space between image and text */
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
    .Searchbar2{
        display: none;
    }

    .Categories {
        width: 100%;
        display: flex;
        justify-content: center;
        margin-top: 10px; /* Adds space */
    }

    .Categories ul {
        display: flex;
        list-style: none; /* Removes bullets */
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


    /* Optional: Adds an underline effect on active category */
    .Categories ul li::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -5px;
        width: 0;
        height: 3px;
        background-color: #007BFF;
        transition: width 0.3s ease-in-out;
    }

    .Categories ul li:hover::after {
        width: 100%;
    }

    .Searchbar{
        display: flex;
        width: 50%;
    }

    .Searchbar input{
        width: 500px;
        height: 30px;
        border-radius: 10px;
    }

    .container{
        width: 900px;
        max-width: 90vw;
        margin: auto;
        text-align: center;
        padding-top: 10px;
        transition: transform .5s;
    }

    svg{
        width: 30px;

    }
    header{

        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 0;
    }
    header .icon-cart {
        position: relative; /* Ensures absolute positioning of span is relative to this */
        display: inline-block;
    }

    header .icon-cart span {
        position: absolute;
        top: -10px; /* Move it up */
        right: -10px; /* Adjust closer to the icon */
        width: 20px; /* Make it smaller */
        height: 20px;
        background-color: red;
        color: white;
        border-radius: 50%;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    .listProduct .item img{
        width: 90%;
        filter: drop-shadow(0 5px 5px #132013);

    }

    .listProduct{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .listProduct .item{
        background-color: #fcfcf8;
        padding: 20px;
        border-radius: 20px;

    }

    .listProduct .item h2{
        font-weight: 500;
        font-size: large;

    }

    .listProduct .item .price{
        letter-spacing: 7px;
        font-size: small;
    }

    .listProduct .item button{
        background-color: #353432;
        color: #eee;
        padding: 5px 10px;
        border-radius: 20px;
        margin-top: 10px;
        border: none;
        cursor: pointer;
    }

    .cartTab{
        width: 400px;
        background-color: whitesmoke;
        color: #eee;
        position: fixed;
        inset: 0 -400px 0 auto;
        display: grid;
        grid-template-rows: 70px 1fr 70px;
        transition: 0.5s;
        color: black;
    }
    body.showCart .cartTab{
        inset: 0 0 0 auto;
    }
    body.showCart .container{
        transform: translateX(-250px);
    }
    .cartTab h1{
        padding: 20px;
        margin: 0;
        font-weight: 300;
        border-bottom: grey  2px solid;
    }

    .cartTab a .btn{
        display: grid;
        grid-template-columns: repeat(2, 1fr); 
    }

    .cartTab .btn a button{
        background-color: yellow;
        border: none;
        font-family: Arial,;
        font-weight: 500;
        cursor: pointer;
    }

    .cartTab .btn a .close{
        background-color: white ;

    }


    .cartTab .listCart .item img{
        width: 100%;
        filter: drop-shadow(0 5px 5px #132013);

    }

    .cartTab .listCart .item{
        display: grid;
        grid-template-columns: 70px 150px 50px 1fr;
        gap: 8px;
        text-align: center;
        align-items: center;   
        border-bottom: 2px solid;
        margin: 5px 5px;
    }

    .listCart .quantity span{
        display: inline-block;
        width: 25px;
        height: 25px;
        background-color: #eee;
        color: #555;
        border-radius: 50%;
        cursor: pointer;
    }


    .listCart .quantity span::nth-child(2){
        background-color: transparent;
        color: #eee;
    }
    .listCart .item:nth-child(even){
        background-color: #eee1;
    }

    .listCart{
        overflow: auto;
    }

    .listCart::-webkit-scrollbar{
        width: 0;
    }

    @media screen and (max-width: 650px) {
        .navBar ul {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .navBar ul li {
            font-size: 14px;
            justify-content: center;
            align-items: center;
        }

        .navBar ul li img {
            height: 40px;
            width: 40px;
        }

        .Searchbar {
            display: none;
        }

        .Searchbar2 {
            display: flex;
            width: 100%;
            justify-content: center;
            padding: 10px;
        }

        .Searchbar2 input {
            width: 90%;
            max-width: 300px;
            height: 30px;
            border-radius: 8px;
        }
        header .tittle{
            display: flex;
            justify-content: flex-start;
        }

        .Categories ul {
            overflow-x: auto;
            display: flex;
            gap: 20px;
            padding: 10px 0;
        }

        .Categories ul li {
            font-size: 14px;
            white-space: nowrap;
        }

        .Categories ul::-webkit-scrollbar {
            display: none;
        }

        .container {
            width: 100%;
            padding: 10px;
        }

        .listProduct {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .listProduct .item {
            padding: 10px;
        }

        .listProduct .item img {
            width: 100%;
            height: auto;
        }

        .cartTab {
            width: 100%;
            inset: 0 -100% 0 auto;
        }

        body.showCart .container {
            transform: none;
        }

        .cartTab .listCart .item {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            gap: 10px;
            border-bottom: 2px solid;
        }

        .cartTab .listCart .item .image {
            flex: 0 0 50px;
        }

        .cartTab .listCart .item .image img {
            width: 50px;
            height: auto;
        }

        .cartTab .listCart .item .name,
        .cartTab .listCart .item .totalPrice,
        .cartTab .listCart .item .quantity {
            flex: 1 1 auto;
            font-size: 12px;
            text-align: center;
        }

        header {
            flex-direction: column;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
        }

        .page {
            height: auto;
            width: 100%;
        }

        header .icon-cart span {
            top: -5px;
            right: -5px;
            width: 16px;
            height: 16px;
            font-size: 10px;
        }

        .listProduct .item .price {
            letter-spacing: normal;
        }
    }

        
    </style>
    </style>
    </head>
    <body class="">
        <section class="header1">
            <img src="img/deli.jpg" class="page" alt="Header Image">
        </section>
        <nav class="navBar">
            <ul class="navbtn">
              <li>
                <a href="landingpage3.php">
                  <img src="img/SSD.jfif" alt="Logo" />
                </a>
              </li>
          
              <li>
                <div class="Searchbar">
                  <input type="text" id="search-item" placeholder="Search products" onkeyup="search()" />
                </div>
              </li>
          
              <li>
                <a href="Shoppage2.php">Home</a>
              </li>
          
              <li>
                <a href="ORDERS.php">Orders</a>
              </li>
          
              <li>
                <a href="Account.php">
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
          
            <div class="Searchbar2">
              <input type="text" id="search-item-2" placeholder="Search products" oninput="search('search-item-2')" />
            </div>
          </nav>
          
        <div class="container"> 
            <nav class="Categories">
                <ul>
                    <li>All</li>
                    <li>Sweet</li>
                    <li>Salty</li>
                    <li>Spicy</li>
                </ul>
            </nav>
            
            <header>
                <div class="title">product list</div>
                <div class="icon-cart">
                    <svg  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                    </svg>
                    <span>0</span>
                    
                </div>
            </header>

            <div class="listProduct">
                <div class="item">
                    <img src="img/FP5.jpg" alt="">
                    <h2>Name product</h2>
                    <div class="price">$200</div>
                    <button class="addcart">
                        Add To Cart
                    </button>
                </div>
            </div>
        </div>
        <div class="cartTab">
            <h1>Shopping Cart</h1>
            <div class="listCart">
                <div class="item">
                    <div class="image">
                        <img class="picture" src="img/BEANS.jpg" alt="">
                    </div>
                    <div class="name">
                        NAME
                    </div>
                    <div class="totalPrice">
                        $200
                    </div>
                    <div class="quantity">
                        <span class="minus">-</span>
                        <span>1</span>
                        <span class="plus">+</span>
                    </div>
                </div>
            </div> 
            <div class="btn">
                    <button class="close">Close</button>
                    <a href="checkoutpage.php"><button class="CheckOut">Checkout</button></a>
            </div>           
        </div>
    <script src="IPTcartjava2.js"></script>
    </body>
    </html>