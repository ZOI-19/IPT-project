<?php
session_start();
include("IPTconnect.php");
include("IPTfunction.php");

// Check if user is logged in
$user_data = check_login($conn);

$user_email = $user_data['email'] ?? '';
$user_first_name = $user_data['fname'] ?? '';
$user_last_name = $user_data['lname'] ?? '';
$user_phone = $user_data['phone'] ?? '';

// Fetch user address
$query = "SELECT address, house_number, barangay_name, municipality FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_data['id']);
$stmt->execute();
$result = $stmt->get_result();
$user_address = $result->fetch_assoc();

// Use null coalescing operator to provide default values
$address = htmlspecialchars($user_address['address'] ?? '');
$house_number = htmlspecialchars($user_address['house_number'] ?? '');
$barangay_name = htmlspecialchars($user_address['barangay_name'] ?? '');
$municipality = htmlspecialchars($user_address['municipality'] ?? '');

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout Page</title>
    
</head>
<style>

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: Arial, sans-serif;
}

body {
  background: #f9f9f9;
  padding: 20px;
}

.page {
    width: 100%;
    height: 130px;
    display: block;
}

.back-button {
  margin-top: 10px;
  margin-bottom: 20px;
}

.back-button a {
  text-decoration: none;
  color: #333;
  font-size: 16px;
}



.back-button a:hover {
  text-decoration: underline;

}

.container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.payment-details, .order-summary {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  flex: 1 1 400px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

h2, h3 {
  margin-bottom: 15px;
}

form label {
  display: block;
  margin-top: 10px;
  margin-bottom: 5px;
}

form input {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.payment-methods {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-top: 10px;
}

.method {
  padding: 10px;
  border: 1px solid #4CAF50;
  background: white;
  color: #4CAF50;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
}

.method:hover {
  background: #4CAF50;
  color: white;
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

.subtotal {
  display: flex;
  justify-content: flex-end;
  gap: 5px  ;
  font-size: 18px;
  margin-bottom: 20px;
}

.payment-button {
  width: 100%;
  padding: 15px;
  background:rgb(255, 220, 22);
  color: black;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
}



.payment-button:hover {
  background:rgb(255, 213, 0);
}



/* === MOBILE RESPONSIVE FIXES === */
@media (max-width: 768px) {
  .container {
    flex-direction: column;
  }

  .payment-details, .order-summary {
    flex: 1 1 100%;
  }

  .page {
    height: auto;
  }

  .back-button a {
    font-size: 18px;
  }

  .payment-button {
    font-size: 18px;
  }
}

</style>
<body>
<section class="header1">
  <img src="img/deli.jpg" class="page" alt="Header Image">
</section>

<div class="back-button">
  <a href="Shoppage2.php"> ← Back to shop</a>
</div>

<div class="container">
  <div class="payment-details">
    <h2>Payment Details</h2>
    <form id="checkoutForm">
        <label>Full Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user_first_name . ' ' . $user_last_name); ?>" readonly>
        <label>Email Address</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user_email); ?>" readonly>
        <label>Phone Number</label>
        <input type="tel" name="phone" value="<?php echo htmlspecialchars($user_phone); ?>" required>
        <h3>Delivery Address</h3>
            <input type="text" id="address" name="address" placeholder="Full address" value="<?php echo htmlspecialchars($user_address['address']); ?>" required>
            <input type="text" id="house_number" name="house_number" placeholder="House number" value="<?php echo htmlspecialchars($user_address['house_number']); ?>" required>
            <input type="text" id="barangay_name" name="barangay_name" placeholder="Barangay" value="<?php echo htmlspecialchars($user_address['barangay_name']); ?>" required>
            <input type="text" id="municipality" name="municipality" placeholder="Municipality" value="<?php echo htmlspecialchars($user_address['municipality']); ?>" required>
        <h3>Payment Method</h3>
        <div class="payment-methods">
            <button type="button" class="method" onclick="selectPayment('GCash')">GCash</button>
            <button type="button" class="method" onclick="selectPayment('COD')">Cash on Delivery</button>
        </div>
        <input type="hidden" name="payment_method" id="payment_method" required>
    </form>
</div>



  <div class="order-summary">
    <div class="cartTab">
      <h1>Shopping Cart</h1>
      <div class="listCart" id="listCart"></div>
      <div class="subtotal" id="subtotal"><strong>Subtotal:</strong> ₱0</div>
      <button class="payment-button" type="submit" onclick="checkout()">Checkout</button>
    </div>
  </div>
</div>
<script src="IPTcartjava2.js"></script>
<script>
// Read cart from localStorage
let cart = JSON.parse(localStorage.getItem('myCart')) || [];

function loadCart() {
    const listCart = document.getElementById('listCart');
    listCart.innerHTML = ''; // Clear previous content

    let subtotal = 0;

    if (cart.length === 0) {
        listCart.innerHTML = '<p>Your cart is empty!</p>';
    } else {
        cart.forEach(item => {
            subtotal += item.price * item.quantity;
            listCart.innerHTML += `
                <div class="item">
                    <div class="image"><img src="${item.image}" alt="${item.name}"></div>
                    <div class="name">${item.name}</div>
                    <div class="totalPrice">₱${(item.price * item.quantity).toFixed(2)}</div>
                    <div class="quantity">${item.quantity}</div>
                </div>
            `;
        });
    }

    document.getElementById('subtotal').innerHTML = `<strong>Subtotal:</strong> ₱${subtotal.toFixed(2)}`;
}

// Load cart when the page is loaded
document.addEventListener('DOMContentLoaded', loadCart);
function selectPayment(method) {
  document.getElementById('payment_method').value = method;
  alert("Payment method selected: " + method);
}

function checkout() {
    const paymentMethod = document.getElementById('payment_method').value;
    const address = document.querySelector('[name="address"]').value;
    const houseNumber = document.querySelector('[name="house_number"]').value;
    const barangayName = document.querySelector('[name="barangay_name"]').value;
    const municipality = document.querySelector('[name="municipality"]').value;

    // Check if all address fields are filled
    if (!address || !houseNumber || !barangayName || !municipality) {
        alert('Please fill in all address fields before checking out!');
        return;
    }

    if (!paymentMethod) {
        alert('Please select a payment method!');
        return;
    }

    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }

    const formData = {
        user_id: <?php echo $user_data['id']; ?>, // Pass user ID
        address: address,
        products: JSON.stringify(cart), // Convert cart to JSON string
        total_price: cart.reduce((total, item) => total + (item.price * item.quantity), 0) // Calculate total price
    };

    fetch('processCheckout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Checkout Successful!');
            localStorage.removeItem('myCart'); // Clear cart
            window.location.href = 'ViewOrders.php'; // Redirect to ViewOrders
        } else {
            alert('Checkout failed: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Checkout failed. Try again.');
    });
}


function addOrderToPending(orderId) {
    // Fetch the order details to display in the Pending category
    fetch(`../Admin_side/orderDetails.php?id=${orderId}`)
        .then(response => response.json())
        .then(order => {
            const pendingOrdersTable = document.getElementById('pendingOrders' , '');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${order.id}</td>
                <td>${order.user_id}</td>
                <td>${order.address}</td>
                <td><a href="orderDetails.php?id=${order.id}">View Products</a></td>
                <td>₱${order.total_price}</td>
                <td><button onclick="confirmOrder(${order.id})">Confirm</button></td>
            `;
            pendingOrdersTable.appendChild(newRow);
        })
        .catch(error => console.error('Error fetching order details:', error));
}

</script>

</body>
</html>




