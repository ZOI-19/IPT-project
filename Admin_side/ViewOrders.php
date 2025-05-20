<?php
session_start();

include("IPTconnect.php"); 
include("IPTfunction.php"); 

// Check if user is logged in
$user_data = check_login($conn);


// Fetch orders from the database
$query = "SELECT * FROM orders"; // Fetch all orders regardless of status
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC); // Fetch all orders as an associative array
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp" rel="stylesheet" />
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

:root{
    --color-primary: #7380ec;
    --color-danger: #ff7782;
    --color-success: #41f1b6;   
    --color-warning: #ffbb55;
    --color-white: #fff;
    --color-info-dark: #7d8da1; 
    --color-info-light: #dceleb;
    --color-dark: #363949;
    --color-light: rgba(132, 139, 200, 0.18);
    --color-primary-variant: #111e88;
    --color-dark-variant: #677483;
    --color-background: #f6f6f9;
    
    --card-border-radius: 2rem;
    --border-radius-1: 0.4rem;
    --border-radius-2: 0.8rem;
    --border-radius-3: 1.2rem;

    --card-padding: 1.8rem;
    --padding-1: 1.2rem;

    --box-shadow: 0 2rem 3rem var(--color-light);
}

.dark-theme-variable{
    --color-background: #181a1e;
    --color-white: #202528;
    --color-dark: #edeffd;
    --color-dark-variant: #a3bdcc;
    --color-light: rgba(0, 0, 0, 0.4);
    --box-shadow: 0 2rem 3rem var(--color-light);
}
*{
    margin: 0;
    padding: 0;
    outline: 0;
    appearance: none;
    border: 0;
    text-decoration: none;
    list-style: none;
    box-sizing: border-box;
}

html{
    font-size: 14px;
}

body{
    width: 100vw;
    height: 100vh;
    font-family: poppins, sans-serif;
    font-size: 0.88rem;
    background: var(--color-background);
    user-select: none;
    overflow: visible;
    color: var(--color-dark);
}
.page {
      width: 100%;
      height: 130px;
      position: sticky;
      top: 0;
      z-index: 1000;
    
}
.container{
    display: grid;
    width: 100%;
    margin: 0 auto;
    gap: 1.8rem;
    grid-template-columns: 14rem auto 23rem;
}


a{
    color: var(--color-dark);
}

aside{
    height: 100vh;
    background: white;
    overflow-y: auto;
}

aside::-webkit-scrollbar {
  width: 6px;
}

aside::-webkit-scrollbar-thumb {
  background-color: var(--color-light);
  border-radius: 10px;
  display: none;
}


aside .top{
    background: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1.4rem;
}

aside .logo{
    display: flex;
    gap: 0.8rem;
}

aside .logo img{
    width: 2rem;
    height: 2rem;
}

aside .close{
    display: none;
}

/* == SIDEBAR ==*/
aside .sidebar{
    display: flex;
    flex-direction: column;
    height: 90vh;
    position: relative;
    top: 3rem;
}

aside h3{
    font-weight: 500;
}

aside .sidebar a{
    display: flex;
    color: var(--color-info-dark);
    margin: 1rem;
    gap: 1rem;
    align-items: center;
    position: relative;
    height: 3.7rem;
    transition: all 300ms ease;
}

aside .sidebar a span{
    font-size: 1.6rem,;
    transition: all 300ms ease;
}

aside .sidebar a:last-child{
    position: absolute;
    bottom: 2rem;
    width: 100%;
}

aside .sidebar a.active{
    background: var(--color-light);
    color: var(--color-primary);
    margin-left: 0;
}

aside .sidebar a.active::before{
    content: '';
    width: 6px;
    height: 100%;
    background:  var(--color-primary);
}

aside .sidebar a.active span{
    color: var(--color-primary);
    margin-left: calc(1rem - 3px);
}

aside .sidebar a:hover{
    color: var(--color-primary);
}

aside .sidebar a:hover span{
    margin-left: 1rem;
}

aside .sidebar .message-count span{
    background: var(--color-danger);
    color: var(--color-white);
    padding: 2px 10px;
    font-size: 11px;
    border-radius: var(--border-radius-1);
}

.Categories {
    width: 100%;
    display: flex;
    justify-content: center;
    margin-top: 10px;
    position: absolute;
    margin-left: 3rem;
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

.Pending, .Packing, .Dispatch, .All-Orders, .Complete {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin-top: 3rem;
    margin-left: 8rem;
    padding: 1rem;
    box-sizing: border-box;
    margin-top: 20px; /* Adds spacing below Categories */
}

.Pending h3, .Packing h3, .Dispatch h3, .All-Orders h3, .Complete h3 {
    font-size: larger;
    font-weight: bold;
    margin-top: 3rem;
    margin-bottom: 1rem;
}

.Pending table, .Packing table, .Dispatch table, .All-Orders table, .Complete table {
    width: 100%;
    max-width: 1200px;
    justify-content: center;
    border-collapse: collapse;
    background: white;
    box-shadow: var(--box-shadow);
    overflow: hidden;
    margin: 0 auto;
}

.Pending table th, .Packing table th, .Dispatch table th, .All-Orders table th, .Complete table th,
.Pending table td, .Packing table td, .Dispatch table td, .All-Orders table td, .Complete table td {
    border: 1px solid #ccc;
    padding: 1rem;
    text-align: left;
}

.Pending table td button, .Packing table td button, .Dispatch table td button {
    cursor: pointer;
    background-color: #677483;
    padding: 10px;
    border-radius: 5px;
}

.Pending table th, .Packing table th, .Dispatch table th, .All-Orders table th, .Complete table th {
    background-color: var(--color-light);
    font-weight: 600;
}



.Pending {
    display: none;
}
.All-Orders {
    display: none;  
}
.Packing {
    display: none;
}
.Dispatch {
    display: none;
}

.Complete{
    display: none;
}

button.Confirm {
    background-color: #4CAF50;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button.Confirm:hover {
    background-color: #45a049;
}

</style>
<body>
<section class="header1">
    <img src="image\deli.jpg" class="page" alt="Header Image"/>
</section>
<div class="container">
    <aside>
            <div class="top">
                <div class="logo">
                    <img src="image/SSD.jpeg" alt="">
                    <h2 class="danger">Delizeus Kai Food Products</h2>
                </div>
                <div class="close" id="close-btn">
                <span class="material-symbols-sharp">close</span>
                </div>
            </div>
            <div class="sidebar">
                <a href="Dashboard.php">
                    <span class="material-symbols-sharp">dashboard</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="ViewOrders.php" class="active">
                    <span class="material-symbols-sharp">receipt_long</span>
                    <h3>Orders</h3>
                </a>
                <a href="ViewCustomers.php" >
                    <span class="material-symbols-sharp">groups</span>
                    <h3>View Customers</h3>
                </a>
                <a href="Inventory.php">
                    <span class="material-symbols-sharp">inventory_2</span>
                    <h3>Inventory</h3>
                </a>
                <a href="Settings.php">
                    <span class="material-symbols-sharp">settings</span>
                    <h3>Settings</h3>
                </a>
                <a href="Logout.php" class="Logout">
                    <span class="material-symbols-sharp">logout</span>
                    <h3>Logout</h3>
                </a>  
            </div>
        </aside>

                <div class="Categories">
                    <ul>
                        <li><a href="ViewOrders.php" onclick="showCategory('All-Orders')">All Orders</a></li>
                        <li onclick="showCategory('Pending')">Pending</li>
                        <li onclick="showCategory('Packing')">Packing</li>
                        <li onclick="showCategory('Dispatch')">Dispatch</li>
                        <li onclick="showCategory('Complete')">Complete</li>
                    </ul>
                </div>



        <div class="All-Orders">
            <h3>All Orders</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Address</th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="allOrders">
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['user_id']; ?></td>
                                <td><?php echo $order['address']; ?></td>
                                <td><a href="orderDetails.php?id=<?php echo $order['id']; ?>">View Products</a></td>
                                <td><?php echo $order['total_price']; ?></td>
                                <td><?php echo ucfirst($order['status']); ?></td> <!-- Displaying the status -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>

        <div class="Pending" style="display: none;">
            <h3>Pending Orders</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Address</th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="pendingOrders">
                        <?php
                        $pendingOrdersQuery = "SELECT * FROM orders WHERE status = 'pending' ORDER BY id DESC";
                        $pendingOrdersResult = $conn->query($pendingOrdersQuery);
                        if ($pendingOrdersResult && $pendingOrdersResult->num_rows > 0) {
                            while ($order = $pendingOrdersResult->fetch_assoc()) {
                                $products = json_decode($order['products'], true);
                                ?>
                                <tr>
                                    <td><?php echo $order['id']; ?></td>
                                    <td><?php echo $order['user_id']; ?></td>
                                    <td><?php echo $order['address']; ?></td>
                                    <td>
                                        <?php
                                        foreach ($products as $product) {
                                            echo $product['name'] . ' x ' . $product['quantity'] . '<br>';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $order['total_price']; ?></td>
                                    <td>
                                        <button class="Confirm" onclick="confirmOrder(<?php echo $order['id']; ?>)">Confirm</button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='6'>No pending orders.</td></tr>";
                        }
                        ?>
                </tbody>
                </table>
        </div>



        <div class="Packing" style="display: none;">
            <h3>Packing Orders</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Address</th>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="packingOrders">
                    <?php foreach ($orders as $order): ?>
                        <?php if ($order['status'] === 'packing'): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['user_id']; ?></td>
                                <td><?php echo $order['address']; ?></td>
                                <td><a href="orderDetails.php?id=<?php echo $order['id']; ?>">View Products</a></td>
                                <td><?php echo $order['total_price']; ?></td>
                                <td>
                                    <button onclick="moveOrderToDispatch(<?php echo $order['id']; ?>)">Move to Dispatch</button>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="Dispatch" style="display: none;">
            <h3>Dispatch Orders</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Address</th>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="dispatchOrders">
                    <?php foreach ($orders as $order): ?>
                        <?php if ($order['status'] === 'dispatch'): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['user_id']; ?></td>
                                <td><?php echo $order['address']; ?></td>
                                <td><a href="orderDetails.php?id=<?php echo $order['id']; ?>">View Products</a></td>
                                <td><?php echo $order['total_price']; ?></td>
                                <td>
                                    <button onclick="moveToComplete(<?php echo $order['id']; ?>)">Move to Complete</button>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="Complete" style="display: none;">
            <h3>Completed Orders</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Address</th>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="completeOrders">
                    <?php foreach ($orders as $order): ?>
                        <?php if ($order['status'] === 'complete'): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['user_id']; ?></td>
                                <td><?php echo $order['address']; ?></td>
                                <td><a href="orderDetails.php?id=<?php echo $order['id']; ?>">View Products</a></td>
                                <td><?php echo $order['total_price']; ?></td>
                                <td>Complete</td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<script>
function showCategory(category) {
    const sections = ['Pending', 'Packing', 'Dispatch', 'Complete', 'All-Orders'];
    sections.forEach(cat => {
        document.querySelector(`.${cat}`).style.display = (cat === category) ? 'block' : 'none';
    });
}

// Ensure the All Orders section is displayed by default
document.addEventListener('DOMContentLoaded', function() {
    showCategory('All-Orders');
});
document.addEventListener('DOMContentLoaded', function() {
    const confirmedOrders = JSON.parse(sessionStorage.getItem('confirmedOrders')) || [];
    confirmedOrders.forEach(orderId => {
        // Logic to display the order in the Packing section
        addOrderToPacking(orderId);
    });
});


function confirmOrder(orderId) {
    if (!confirm("Are you sure you want to confirm this order and move it to Packing?")) return;

    fetch('manage_product.php?action=move_to_packing_and_deduct', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ orderId: orderId })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert("Order has been moved to Packing and stock updated.");
            location.reload();
        } else {
            alert(data.message || "Failed to confirm order.");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Something went wrong: " + error.message);
    });
}



function confirmOrder(orderId) {
    if (!confirm("Are you sure you want to confirm this order and move it to Packing?")) return;

    // Store the order ID in session storage
    let confirmedOrders = JSON.parse(sessionStorage.getItem('confirmedOrders')) || [];
    confirmedOrders.push(orderId);
    sessionStorage.setItem('confirmedOrders', JSON.stringify(confirmedOrders));

    fetch('manage_product.php?action=move_to_packing_and_deduct', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ orderId: orderId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Order has been moved to Packing and stock updated.");
            location.reload();
        } else {
            alert(data.message || "Failed to confirm order.");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Something went wrong.");
    });
}

function refreshPendingOrders() {
    fetch('ViewOrders.php') // Fetch the updated list of pending orders
        .then(response => response.text())
        .then(html => {
            document.querySelector('.Pending').innerHTML = html; // Update the Pending section with new data
        })
        .catch(error => console.error('Error refreshing pending orders:', error));
}

function removeOrderFromPending(orderId) {
    const pendingOrdersTable = document.getElementById('pendingOrders');
    const rows = pendingOrdersTable.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const idCell = row.cells[0]; // Assuming the first cell contains the order ID
        if (idCell && idCell.textContent == orderId) {
            pendingOrdersTable.deleteRow(i); // Remove the row from the Pending table
            break; // Exit the loop after removing the order
        }
    }
}


// Move order to Packing action
function moveOrderToPacking(orderId) {
    fetch('manage_product.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'move_to_packing',
            orderId: orderId
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Order moved to Packing!');
            // Update the UI to reflect the order has been moved
            removeOrderFromPending(orderId); // Remove from Pending
            addOrderToPacking(orderId); // Add to Packing
        } else {
            alert('Error moving order: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error moving order:', error);
        alert('Error moving order: ' + error.message);
    });
}


function addOrderToPacking(orderId) {
    fetch(`orderDetails.php?id=${orderId}`)
        .then(response => response.json())
        .then(order => {
            if (order.success) {
                const packingOrdersTable = document.getElementById('packingOrders'); // Ensure this table exists
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${order.id}</td>
                    <td>${order.user_id}</td>
                    <td>${order.address}</td>
                    <td><a href="orderDetails.php?id=${order.id}">View Products</a></td>
                    <td>₱${order.total_price}</td>
                    <td>
                        <button onclick="moveOrderToDispatch(${order.id})">Move to Dispatch</button>
                    </td>
                `;
                packingOrdersTable.appendChild(newRow);
            } else {
                console.error('Order not found:', order.message);
            }
        })
        .catch(error => console.error('Error fetching order details:', error));
}

function moveOrderToDispatch(orderId) {
    fetch('manage_product.php?action=move_to_dispatch', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ orderId: orderId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Order moved to Dispatch!');
            removeOrderFromPending(orderId); // Remove from Pending
            addOrderToDispatch(orderId, data.riders); // Add to Dispatch and update riders
            updateCustomerOrders(orderId, data.riders); // Update the ORDERS.php
        } else {
            alert('Error moving order: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong: ' + error.message);
    });
}

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
            console.log('ORDERS.php updated successfully.');
        } else {
            console.error('Error updating ORDERS.php:', data.message);
        }
    })
    .catch(error => console.error('Error updating ORDERS.php:', error));
}



function addOrderToDispatch(orderId, riders) {
    fetch(`orderDetails.php?id=${orderId}`)
        .then(response => response.json())
        .then(order => {
            if (order.success) {
                const dispatchOrdersTable = document.getElementById('dispatchOrders'); // Ensure this table exists
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${order.id}</td>
                    <td>${order.user_id}</td>
                    <td>${order.address}</td>
                    <td><a href="orderDetails.php?id=${order.id}">View Products</a></td>
                    <td>₱${order.total_price}</td>
                    <td>
                        <button onclick="moveToComplete(${order.id})">Move to Complete</button>
                    </td>
                `;
                dispatchOrdersTable.appendChild(newRow);

                // Update the to-ship section with rider information
                const toShipSection = document.getElementById('to-ship-btn');
                riders.forEach(rider => {
                    const riderInfo = document.createElement('div');
                    riderInfo.innerHTML = `
                        <strong>Will Deliver by:</strong><br>
                        Name: ${rider.first_name} ${rider.last_name}<br>
                        Number: ${rider.rider_number}<br>
                    `;
                    toShipSection.appendChild(riderInfo);
                });
            } else {
                console.error('Order not found:', order.message);
            }
        })
        .catch(error => console.error('Error fetching order details:', error));
}


function removeOrderFromPacking(orderId) {
    const packingOrdersTable = document.getElementById('packingOrders');
    const rows = packingOrdersTable.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const idCell = row.cells[0]; // Assuming the first cell contains the order ID
        if (idCell && idCell.textContent == orderId) {
            packingOrdersTable.deleteRow(i); // Remove the row from the Packing table
            break; // Exit the loop after removing the order
        }
    }
}



    function moveToComplete(orderId) {
       fetch('manage_product.php?action=move_to_complete', {
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
           } else {
               alert('Error moving order: ' + data.message);
           }
       })
       .catch(error => {
           console.error('Error:', error);
           alert('Something went wrong: ' + error.message);
       });
   }
   

function removeOrderFromDispatch(orderId) {
    const packingOrdersTable = document.getElementById('dispatchOrders');
    const rows = packingOrdersTable.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const idCell = row.cells[0]; // Assuming the first cell contains the order ID
        if (idCell && idCell.textContent == orderId) {
            packingOrdersTable.deleteRow(i); // Remove the row from the Packing table
            break; // Exit the loop after removing the order
        }
    }
}

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
   
function addOrderToComplete(orderId) {
    fetch(`orderDetails.php?id=${orderId}`)
        .then(response => response.json())
        .then(order => {
            if (order.success) {
                const dispatchOrdersTable = document.getElementById('completeOrders'); // Ensure this table exists
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${order.id}</td>
                    <td>${order.user_id}</td>
                    <td>${order.address}</td>
                    <td><a href="orderDetails.php?id=${order.id}">View Products</a></td>
                    <td>₱${order.total_price}</td>
                    <td>Complete</td>
                `;
                dispatchOrdersTable.appendChild(newRow);
            } else {
                console.error('Order not found:', order.message);
            }
        })
        .catch(error => console.error('Error fetching order details:', error));
}
</script>
</body>
</html>