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

    .cartTab .btn{
        display: grid;
        grid-template-columns: repeat(2, 1fr); 
    }

    .cartTab .btn button{
        background-color: yellow;
        border: none;
        font-family: Arial,;
        font-weight: 500;
        cursor: pointer;
    }

    .cartTab .btn .close{
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

.subtotal {
  font-size: 18px;
  margin-bottom: 20px;
}

.payment-button {
  width: 100%;
  padding: 15px;
  background: #FFD700;
  color: black;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
}

.payment-button:hover {
  background: #e6c200;
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
  <a href="Shoppage2.php">← Back to Shop</a>
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
      <input type="text" name="house_number" placeholder="House Number" required>
      <input type="text" name="street" placeholder="Street Name" required>
      <input type="text" name="barangay" placeholder="Barangay" required>
      <input type="text" name="municipality" placeholder="Municipality" required>

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
      <button class="payment-button" onclick="checkout()">Checkout</button>
    </div>
  </div>
</div>
<script src="IPTcheckout.js"></script>
<script>
// Read cart from localStorage
let cart = JSON.parse(localStorage.getItem('cart')) || [];

function loadCart() {
  const listCart = document.getElementById('listCart');
  listCart.innerHTML = '';

  let subtotal = 0;

  if (cart.length === 0) {
    listCart.innerHTML = '<p>Your cart is empty!</p>';
  } else {
    cart.forEach(item => {
      subtotal += item.price * item.quantity;
      listCart.innerHTML += `
        <div class="item">
          <div class="image"><img src="${item.image}" alt=""></div>
          <div class="name">${item.name}</div>
          <div class="totalPrice">₱${item.price * item.quantity}</div>
          <div class="quantity">${item.quantity}</div>
        </div>
      `;
    });
  }

  document.getElementById('subtotal').innerHTML = `<strong>Subtotal:</strong> ₱${subtotal}`;
}

function selectPayment(method) {
  document.getElementById('payment_method').value = method;
  alert("Payment method selected: " + method);
}

function checkout() {
  const paymentMethod = document.getElementById('payment_method').value;
  if (!paymentMethod) {
    alert('Please select a payment method!');
    return;
  }

  if (cart.length === 0) {
    alert('Your cart is empty!');
    return;
  }

  const formData = {
    name: document.querySelector('[name="name"]').value,
    email: document.querySelector('[name="email"]').value,
    phone: document.querySelector('[name="phone"]').value,
    address: {
      house_number: document.querySelector('[name="house_number"]').value,
      street: document.querySelector('[name="street"]').value,
      barangay: document.querySelector('[name="barangay"]').value,
      municipality: document.querySelector('[name="municipality"]').value,
    },
    payment_method: paymentMethod,
    cart: cart
  };

  fetch('checkout.php', {
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
      localStorage.removeItem('cart');
      window.location.href = 'Shoppage2.php'; // Go back to shop
    } else {
      alert('Checkout failed: ' + data.message);
    }
})

  .catch(error => {
    console.error('Error:', error);
    alert('Checkout failed. Try again.');
  });
}

document.addEventListener('DOMContentLoaded', loadCart);
</script>

</body>
</html>