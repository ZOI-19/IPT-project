<?php
session_start();
include("IPTconnect.php");
include("IPTfunction.php");

// Check if user is logged in
$user_data = check_login($conn);
// Fetch pending orders for the logged-in user
$user_id = $_SESSION['user_id']; // Ensure user_id is set in session
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? AND status = 'pending' ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$pendingResult = $stmt->get_result();
// Fetch dispatch orders for the logged-in user
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? AND status = 'dispatch' ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$dispatchResult = $stmt->get_result();
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

      #pendingSection {
        display: none;
      }
      #Pendin-btn {
          cursor: pointer;
          /* Add your styles */
      }
      #pendingOrdersList li, #shipped-orders-list li, #to-review li{
          list-style: none;
          margin-bottom: 20px;
          border-bottom: 1px solid #ccc;
          padding-bottom: 10px;
          display: flex;
      }
      #pendingOrdersList img, #shipped-orders-list img, #to-review img{
          width: 80px;
          height: 80px;
          object-fit: cover;
          margin-right: 10px;
      }
      #pendingOrdersList .details, #shipped-orders-list .details, #to-review .details{
          display: flex;
          flex-direction: column;
          justify-content: center;
      }
      #pendingOrdersList .details div, #shipped-orders-list .details div, #to-review .details div {
          margin: 2px 0;
      }
      #to-ship-orders-list li {
    list-style: none;
    margin-bottom: 20px;
    border-bottom: 1px solid #ccc;
    padding-bottom: 10px;
    display: flex;
}

#to-ship-orders-list img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    margin-right: 10px;
}

#to-ship-orders-list .order-details {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

#to-ship-orders-list .order-details div {
    margin: 2px 0;
}

#to-ship-orders-list .rider-info {
    margin-top: 5px;
    font-size: 14px;
    color: #555;
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
          <li id="to-review-btn">To review</li>
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
      <div id="pendingSection" style="display: none;">
            <h3>Pending Orders</h3>
            <ul id="pendingOrdersList">
                <?php while ($order = $pendingResult->fetch_assoc()): ?>
                    <?php 
                    $products = json_decode($order['products'], true); // Decode JSON products array
                    // Check if products is an array
                    if (is_array($products)) {
                        foreach ($products as $product): ?>
                            <li class="order-item">
                                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
                                <div class="order-details">
                                    <div><strong><?php echo htmlspecialchars($product['name']); ?></strong></div>
                                    <div>Quantity: <?php echo (int)$product['quantity']; ?></div>
                                    <div>Total Price: ₱<?php echo number_format($product['price'] * $product['quantity'], 2); ?></div>
                                </div>
                            </li>
                        <?php endforeach; 
                    } else {
                        echo "<li>Error: Products data is not valid.</li>";
                    }
                endwhile; ?>
            </ul>
        </div>
        <div id="to-ship-orders" style="display: none;">
            <h3>To Ship Orders</h3>
            <ul id="to-ship-orders-list">
                <?php while ($order = $dispatchResult->fetch_assoc()): ?>
                    <?php $products = json_decode($order['products'], true); // Decode JSON products array ?>
                    <?php foreach ($products as $product): ?>
                           <li class="order-item" data-order-id="<?php echo $order['id']; ?>">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
                            <div class="order-details">
                                <div><strong><?php echo htmlspecialchars($product['name']); ?></strong></div>
                                <div>Quantity: <?php echo (int)$product['quantity']; ?></div>
                                <div>Total Price: ₱<?php echo number_format($product['price'] * $product['quantity'], 2); ?></div>
                                <div class="rider-info">
                                    <strong>Will Deliver by:</strong><br>
                                    <?php
                                    // Assuming you have a way to get the rider information
                                    $ridersQuery = "SELECT first_name, last_name, rider_number FROM delivery_riders";
                                    $ridersResult = $conn->query($ridersQuery);
                                    while ($rider = $ridersResult->fetch_assoc()) {
                                        echo "Name: {$rider['first_name']} {$rider['last_name']}<br>";
                                        echo "Number: {$rider['rider_number']}<br>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endwhile; ?>
            </ul>
        </div>
        <div id="shipped-orders" style="display: none;">
            <h3>Shipped Orders</h3>
            <ul id="shipped-orders-list">
                <?php
                // Fetch and display shipped orders from the database
                $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? AND status = 'complete' ORDER BY id DESC");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $shippedResult = $stmt->get_result();
                while ($order = $shippedResult->fetch_assoc()): 
                    $products = json_decode($order['products'], true);
                    foreach ($products as $product): ?>
                        <li class="order-item">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
                            <div class="order-details">
                                <div><strong><?php echo htmlspecialchars($product['name']); ?></strong></div>
                                <div>Quantity: <?php echo (int)$product['quantity']; ?></div>
                                <div>Total Price: ₱<?php echo number_format($product['price'] * $product['quantity'], 2); ?></div>
                                <div class="rider-info">
                                    <strong>Delivered by:</strong><br>
                                    <?php
                                    // Assuming you have a way to get the rider information
                                    $ridersQuery = "SELECT first_name, last_name, rider_number FROM delivery_riders";
                                    $ridersResult = $conn->query($ridersQuery);
                                    while ($rider = $ridersResult->fetch_assoc()) {
                                        echo "Name: {$rider['first_name']} {$rider['last_name']}<br>";
                                        echo "Number: {$rider['rider_number']}<br>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; 
                endwhile; ?>
            </ul>
        </div>
           <div id="to-review" style="display: none;">
    <h3>To Review Orders</h3>
    <ul id="to-review-list">
        <?php
        // Fetch and display orders that need to be reviewed from the database
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? AND status = 'review' ORDER BY id DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $reviewResult = $stmt->get_result();
        while ($order = $reviewResult->fetch_assoc()): 
            $products = json_decode($order['products'], true);
            foreach ($products as $product): ?>
                <li class="order-item">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
                    <div class="order-details">
                        <div><strong><?php echo htmlspecialchars($product['name']); ?></strong></div>
                        <div>Quantity: <?php echo (int)$product['quantity']; ?></div>
                        <div>Total Price: ₱<?php echo number_format($product['price'] * $product['quantity'], 2); ?></div>
                        <div class="rider-info">
                                    <strong>Delivered by:</strong><br>
                                    <?php
                                    // Assuming you have a way to get the rider information
                                    $ridersQuery = "SELECT first_name, last_name, rider_number FROM delivery_riders";
                                    $ridersResult = $conn->query($ridersQuery);
                                    while ($rider = $ridersResult->fetch_assoc()) {
                                        echo "Name: {$rider['first_name']} {$rider['last_name']}<br>";
                                        echo "Number: {$rider['rider_number']}<br>";
                                    }
                                    ?>
                                </div>
                    </div>
                </li>
            <?php endforeach; 
        endwhile; ?>
        <?php
        // Also display shipped orders in the To Review section
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? AND status = 'complete' ORDER BY id DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $shippedResult = $stmt->get_result();
        while ($order = $shippedResult->fetch_assoc()): 
            $products = json_decode($order['products'], true);
            foreach ($products as $product): ?>
                <li class="order-item">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
                    <div class="order-details">
                        <div><strong><?php echo htmlspecialchars($product['name']); ?></strong></div>
                        <div>Quantity: <?php echo (int)$product['quantity']; ?></div>
                        <div>Total Price: ₱<?php echo number_format($product['price'] * $product['quantity'], 2); ?></div>
                        <div class="rider-info">
                                    <strong>Delivered by:</strong><br>
                                    <?php
                                    // Assuming you have a way to get the rider information
                                    $ridersQuery = "SELECT first_name, last_name, rider_number FROM delivery_riders";
                                    $ridersResult = $conn->query($ridersQuery);
                                    while ($rider = $ridersResult->fetch_assoc()) {
                                        echo "Name: {$rider['first_name']} {$rider['last_name']}<br>";
                                        echo "Number: {$rider['rider_number']}<br>";
                                    }
                                    ?>
                                </div>
                    </div>
                </li>
            <?php endforeach; 
        endwhile; ?>
    </ul>
</div>
<script>
   document.getElementById('Pendin-btn').addEventListener('click', function() {
       document.getElementById('pendingSection').style.display = 'block';
       document.getElementById('to-ship-orders').style.display = 'none';
       document.getElementById('shipped-orders').style.display = 'none';
       document.getElementById('to-review').style.display = 'none';
       document.querySelector('.cartTab').style.display = 'none'; // Hide cart
   });

   document.getElementById('to-ship-btn').addEventListener('click', function() {
       document.getElementById('pendingSection').style.display = 'none';
       document.getElementById('to-ship-orders').style.display = 'block';
       document.getElementById('shipped-orders').style.display = 'none';
       document.getElementById('to-review').style.display = 'none';
       document.querySelector('.cartTab').style.display = 'none'; // Hide cart
   });

   document.getElementById('shipped-btn').addEventListener('click', function() {
       document.getElementById('pendingSection').style.display = 'none';
       document.getElementById('to-ship-orders').style.display = 'none';
       document.getElementById('shipped-orders').style.display = 'block';
       document.getElementById('to-review').style.display = 'none';
       document.querySelector('.cartTab').style.display = 'none'; // Hide cart
   });

   document.getElementById('to-review-btn').addEventListener('click', function() {
       document.getElementById('pendingSection').style.display = 'none';
       document.getElementById('to-ship-orders').style.display = 'none';
       document.getElementById('shipped-orders').style.display = 'none';
       document.getElementById('to-review').style.display = 'block';
       document.querySelector('.cartTab').style.display = 'none'; // Hide cart
   });

   document.getElementById('cart-tab-btn').addEventListener('click', function() {
       document.querySelector('.cartTab').classList.toggle('active'); // Toggle cart visibility
       document.getElementById('pendingSection').style.display = 'none';
       document.getElementById('to-ship-orders').style.display = 'none';
       document.getElementById('shipped-orders').style.display = 'none';
       document.getElementById('to-review').style.display = 'none'; // Hide other sections
   });
   

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

 // Load pending orders from session storage
    document.addEventListener('DOMContentLoaded', function() {
        const pendingOrderData = sessionStorage.getItem('pendingOrder');
        if (pendingOrderData) {
            const orderDetails = JSON.parse(pendingOrderData);
            const pendingOrdersList = document.getElementById('pendingOrders');
            // Loop through products and create list items
            orderDetails.products.forEach(product => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `
                    <div class="image"><img src="${product.image}" alt="${product.name}"></div>
                    <div class="name">${product.name}</div>
                    <div class="quantity">Quantity: ${product.quantity}</div>
                    <div class="price">Price: ₱${product.price}</div>
                    <div class="total">Total: ₱${(product.price * product.quantity).toFixed(2)}</div>
                `;
                pendingOrdersList.appendChild(listItem);
            });
            // Clear the stored order after displaying
            sessionStorage.removeItem('pendingOrder');
        }
    });
    function updateCustomerOrders(orderId, riders) {
    // Send a request to update the ORDERS.php
    fetch('../Customer_side/ORDERS.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ orderId: orderId, riders: riders })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Assuming you want to append the rider information to the to-ship-orders div
            const toShipOrdersDiv = document.getElementById('to-ship-orders');
            toShipOrdersDiv.innerHTML += `<strong>Will Deliver by:</strong><br>`;
            riders.forEach(rider => {
                const riderInfo = document.createElement('div');
                riderInfo.innerHTML = `
                    Name: ${rider.first_name} ${rider.last_name}<br>
                    Number: ${rider.rider_number}<br>
                `;
                toShipOrdersDiv.appendChild(riderInfo);
            });
            console.log('ORDERS.php updated successfully.');
        } else {
            console.error('Error updating ORDERS.php:', data.message);
        }
    })
    .catch(error => console.error('Error updating ORDERS.php:', error));
}
   function moveToComplete(orderId) {
       fetch('../Admin_side/manage_product.php?action=move_to_complete', {
           method: 'POST',
           headers: {
               'Content-Type': 'application/json'
           },
           body: JSON.stringify({ orderId: orderId })
       })
       .then(response => response.json())
       .then(data => {
           if (data.success) {
               alert('Order moved to Complete!');
               removeOrderFromToShip(orderId); // Remove from To Ship section
               addOrderToShipped(orderId); // Add to Shipped section
               addOrderToReview(orderId); // Add to To Review section
           } else {
               alert('Error moving order: ' + data.message);
           }
       })
       .catch(error => {
           console.error('Error:', error);
           alert('Something went wrong: ' + error.message);
       });
   }
   
// Function to remove order from To Ship list
   function removeOrderFromToShip(orderId) {
       const toShipOrdersList = document.getElementById('to-ship-orders-list');
       const rows = toShipOrdersList.getElementsByTagName('li');
       for (let i = 0; i < rows.length; i++) {
           const row = rows[i];
           if (row.dataset.orderId == orderId) {
               toShipOrdersList.removeChild(row); // Remove the order from the To Ship list
               break;
           }
       }
   }
   
// Function to add order to Shipped list
   function addOrderToShipped(orderId) {
       fetch(`../Admin_side/orderDetails.php?id=${orderId}`)
           .then(response => response.json())
           .then(order => {
               if (order.success) {
                   const shippedOrdersList = document.getElementById('shipped-orders-list'); // Ensure this exists
                   const newRow = document.createElement('li');
                   newRow.innerHTML = `
                       <img src="${order.products[0].image}" alt="Product Image">
                       <div class="order-details">
                           <div><strong>${order.products[0].name}</strong></div>
                           <div>Quantity: ${order.products[0].quantity}</div>
                           <div>Total Price: ₱${order.total_price}</div>
                       </div>
                   `;
                   shippedOrdersList.appendChild(newRow);
               } else {
                   console.error('Order not found:', order.message);
               }
           })
           .catch(error => console.error('Error fetching order details:', error));
   }
   function addOrderToReview(orderId) {
       fetch(`../Admin_side/orderDetails.php?id=${orderId}`)
           .then(response => response.json())
           .then(order => {
               if (order.success) {
                   const toReviewList = document.getElementById('to-review-list'); // Ensure this exists
                   const newRow = document.createElement('li');
                   newRow.innerHTML = `
                       <img src="${order.products[0].image}" alt="Product Image">
                       <div class="order-details">
                           <div><strong>${order.products[0].name}</strong></div>
                           <div>Quantity: ${order.products[0].quantity}</div>
                           <div>Total Price: ₱${order.total_price}</div>
                       </div>
                   `;
                   toReviewList.appendChild(newRow);
               } else {
                   console.error('Order not found:', order.message);
               }
           })
           .catch(error => console.error('Error fetching order details:', error));
   }
   
   
</script>

    
  </body>
  </html>
