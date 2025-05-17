<?php
include('IPTconnect.php');

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$categoryId = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT p.*, c.name AS category_name 
        FROM products p 
        JOIN categories c ON p.category = c.id";

$conditions = [];
$params = [];
$types = "";

// Add search filter
if (!empty($searchTerm)) {
    $conditions[] = "p.name LIKE ?";
    $params[] = "%" . $searchTerm . "%";
    $types .= "s";
}

// Add category filter
if (!empty($categoryId)) {
    $conditions[] = "p.category = ?";
    $params[] = $categoryId;
    $types .= "i";
}

// Apply conditions
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
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

    .Searchbar{
        margin-left: 30px;
        gap: 10px;
    }
    .Searchbar button{
        border-radius: 10px;
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
        width: 90%;
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
        cursor: pointer;
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
        width: 100%;
        height: 100px;
        filter: drop-shadow(0 5px 5px #132013);

    }

    .listProduct{
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        column-gap: 20px;
        row-gap: 4rem;
    }

    .listProduct .item{
        background-color: #fcfcf8;
        padding: 20px;
        border-radius: 20px;


    }

    .listProduct .item h2{
        font-weight: 500;
        font-size: large;
        font-style: normal;

    }

    .listProduct .item .price{
        letter-spacing: 7px;
        font-size: small;
        display: flex;
        flex-direction: column;
    }
    .listProduct .item {
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* pushes button to bottom */
        height: 100%; /* or a fixed height like 300px */
    }


    .listProduct .item button{
        background-color: #353432;
        color: #eee;
        padding: 5px 10px;
        border-radius: 20px;
        margin-top: 10px;
        border: none;
        cursor: pointer;
        position: relative;

    }

    .cartTab {
        position: fixed;
        top: 0;
        right: 0;
        width: 430px;
        max-width: 90%;
        height: 100%;
        background-color: #fff;
        box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
        z-index: 1000;

        overflow-y: auto;
    }
    body.showCart .cartTab {
        transform: translateX(0);
    }
    body.showCart .container{
        transform: translateX(-250px);
    }
    body.showCart::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 999;
    }
    .closeCart {
        position: absolute;
        top: 10px;
        right: 15px;
        background: transparent;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
    }
    .cartTab h1{
        padding: 20px;
        margin: 0;
        font-weight: 300;
        display: flex;
        justify-content: center;
        align-items: center;
        border-bottom: black 2px solid;
        background-color: #353432;
    }

    .cartTab a .btn{
        position: fixed;
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
        padding: 10px;
        display: grid;
        grid-template-columns: 70px 150px 50px 1fr;
        gap: 5px;
        text-align: center;
        align-items: center;   
        border-bottom: 2px solid;
        margin-top: 10px;
        margin-bottom: 10px;
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
            width: 90%;
            gap: 10px;
            justify-content: center;
            padding: 10px;

        }
        .Searchbar2 button {
            background-color:lightyellow;
            font-weight: bold;
            border-radius: 10px;
            
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
            
            display: flex;
            gap: 20px;
            padding: 10px   0;
            overflow-y: auto;
        }

        .Categories ul li {
            font-size: 14px;
            white-space: nowrap;
            overflow-y: auto;
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
            row-gap: 2rem;
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
            padding: 10px; 
            font-size: 14px; 
        }

        .cartTab h1 {
            font-size: 20px; 
            text-align: center; 
        }

        .cartTab .listCart {
            display: flex; 
            flex-direction: column; 
            gap: 10px; 
        }
        .cartTab .listCart .item {
            flex-direction: row; /* Row layout on mobile */
            justify-content: flex-start; /* Adjust alignment */
            padding: 5px; /* Adjust padding */
        }

        .cartTab .listCart .item img {
            width: 60px; /* Set image width */
            height: auto; /* Maintain aspect ratio */
        }
        .cartTab .listCart .item .name {
            flex: 2; /* Give name more space */
            text-align: left; /* Left align the name */
            font-size: 14px; /* Adjust font size */
        }

        .cartTab .listCart .item .name,
        .cartTab .listCart .item .totalPrice,
        .cartTab .listCart .item .quantity {
            flex: 1; 
            text-align: left; 
            font-size: 14px; 
        }
        .cartTab .listCart .item .totalPrice {
            flex: 1; /* Set flex for price */
            text-align: center; /* Center align price */
        }

        .cartTab .listCart .item .quantity {
            flex: 1; /* Set flex for quantity */
            display: flex; 
            align-items: center; 
            justify-content: center; /* Center align quantity controls */
            gap: 5px; /* Spacing between quantity controls */
        }

        .cartTab .listCart .item .quantity span {
            width: 25px;
            height: 25px; 
            background-color: #eee; 
            color: #555; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }

        .btn {
            
            display: grid; 
            grid-template-columns: repeat(2, 1fr);
            gap: 10px; 
            padding: 10px 0; 
        }

        .btn button {
            width: 100%; 
            padding: 10px; 
            font-size: 14px; 
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
        .listCart .item  {
            align-items: center;
            justify-content: center;
        }
        .listCart .item  img{
            height: 100px;
            width: 30px;
        }

    }
    

        
    </style>
    </head>
    <body>
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
            <form class="Searchbar" method="GET" action="">
                <input type="text" name="search" placeholder="Search products..." 
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">Search</button>
            </form>
            </li>
            <li><a href="Shoppage2.php">Home</a></li>
            <li><a href="ORDERS.php">Orders</a></li>
            <li>
                <a href="Account.php">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                </a>
            </li>
        </ul>
        <form class="Searchbar2" method="GET" action="">
                <input type="text" name="search" placeholder="Search products..." 
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">Search</button>
        </form>


    <div class="container">
        <!-- Category filter section -->
        <div class="Categories">
            <ul>
                <!-- 'All' Category Link -->
                <?php
                    // Fetch all categories
                    $categoryQuery = "SELECT * FROM categories";
                    $categoryResult = $conn->query($categoryQuery);

                    echo '<li><a href="shoppage2.php" style="text-decoration:none;color:black;">All</a></li>'; // "All" category

                    while ($row = $categoryResult->fetch_assoc()) {
                        $isActive = ($categoryId == $row['id']) ? 'style="text-decoration:underline;"' : '';
                        echo '<li><a href="?category=' . $row['id'] . '" ' . $isActive . ' style="text-decoration:none;color:black;">' . htmlspecialchars($row['name']) . '</a></li>';
                    }
                ?>
            </ul>
        </div>






        <header>
            <div class="title">Product List</div>
            <div class="icon-cart" >
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                </svg>
                <span>0</span>
            </div>
        </header>

        <div class="listProduct">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="item" data-id="<?= $row['id'] ?>">
                    <img src="../Admin_side/uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image">
                    <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                    <div class="price">₱<?php echo number_format($row['price'], 2); ?></div>
                    <div class="Quantity">Stock:<?php echo number_format($row['quantity']); ?></div>
                    <button class="addToCartBtn" data-id="<?= $row['id'] ?>"
                            data-name="<?= htmlspecialchars($row['name']) ?>"
                            data-price="<?= $row['price'] ?>"
                            data-image="<?= htmlspecialchars($row['image']) ?>">
                        Add to Cart
                    </button>
                </div>
            <?php endwhile; ?>
        </div>

    </div>

    <div class="cartTab">
        <h1>Shopping Cart</h1>
        <div class="listCart">

        </div>
        <div class="btn">
            <button class="close">Close</button>
            <a href="checkoutpage.php"><button>Checkout</button></a>
        </div>
    </div>

<script src="IPTcartjava2.js"></script>
</body> 
</html>