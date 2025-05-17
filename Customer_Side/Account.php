<?php
session_start();
include("IPTconnect.php"); 
include("IPTfunction.php");

// Check if user is logged in and fetch user data
$user_data = check_login($conn);

// Fetch user address after update
$query = "SELECT address, house_number, barangay_name, municipality FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_data['id']);
$stmt->execute();
$result = $stmt->get_result();
$user_address = $result->fetch_assoc();
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Account Settings</title>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp" rel="stylesheet" />
</head>

<style>
/* Basic reset */
/* Basic reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  height: 100vh;
  padding-top: 130px; /* Ensure the content starts below the fixed header */
}

/* Header Styling */
.header1 {
  position: fixed;
  top: 0;
  left: 0;
  display: block;
  width: 100%;
  height: 130px; /* Adjust the height as needed */
  z-index: 9999; /* Ensure the header is above other content */
}

.page {
  width: 100%;
  height: 130px; /* Ensure the image fills the header */
}

/* Sidebar Styling */
.sidebar {
  flex: 0 0 250px;
  background-color: lightyellow;
  color: white;
  padding: 20px;
  height: 100%;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
  position: fixed; /* Ensure it stays in place */
  top: 130px; /* Start the sidebar below the header */
  left: 0;
  display: flex;
  flex-direction: column;
  gap: 20px;
  transition: transform 0.3s ease-in-out;
  z-index: 999; /* Make sure sidebar is below header but above content */
}


.sidebar-btn{
    font-size: large;
    background-color: white ;
    padding: 5px;
    border-radius: 10px;
    width: 80px;
    cursor: pointer;
    transition: all 300ms ease ;
}

.sidebar-btn:hover{
    background-color: yellow;

}

/* Main Content */
.main-content {
  position: relative;
  flex-grow: 1;
  margin-left: 270px; /* Make space for the sidebar */
  padding: 20px;
  margin-top: 20px; /* Avoid overlap with the header */
  transition: margin-left 0.3s ease-in-out;
}

.main-content h1 {
  font-size: 28px;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
}

label {
  font-size: 18px;
  margin-bottom: 8px;
  display: block;
}

input {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

.update-btn {
  background-color: #3498db;
  padding: 10px 20px;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

.update-btn:hover {
  background-color: #2980b9;
}

/* Mobile view adjustments */
@media (max-width: 768px) {
  /* Adjust Sidebar to cover 50% of the screen */


  .sidebar {
    width: 50%; /* Sidebar will cover 50% of the screen width */
    height: calc(100vh - 130px); /* Sidebar takes up the rest of the screen height */
    position: absolute;
    left: -50%; /* Initially hidden off the screen */
    top: 130px; /* Start below the header */
    z-index: 1000; /* Sidebar stays on top */
    transition: left 0.3s ease-in-out; /* Smooth transition */
  }

  /* When sidebar is active, show it */
  .sidebar.active {
    left: 0; /* Show sidebar */
  }

  .main-content {
    margin-left: 0; 
    margin-top: 3rem;
  }


  .mobile-menu-btn {
    position: absolute; /* Changed from fixed to absolute */
    top: 140px; /* Adjusted to be below the header */
    left: 10px; /* Distance from the left */
    background-color: white;
    padding: 10px;
    font-size: 18px;
    cursor: pointer;
    z-index: 1001; 
    background: transparent;
    border: 2px solid;
    border-radius: 10px;
  }

}

/* PC View adjustments */
@media (min-width: 769px) {
  .sidebar {
    position: fixed;
    top: 130px; /* Ensure the sidebar starts below the header */
    left: 0;
    height: calc(100vh - 130px); /* Ensure the sidebar takes up the remaining height below the header */
  }

  .main-content {
    margin-left: 270px; /* Make space for the sidebar */
    padding-top: 20px; /* Padding top for main content */
  }
}

</style>


<body>
<section class="header1">
     <img src="img/deli.jpg" class="page" alt="Header Image">
</section>


  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <a href="Shoppage2.php"><button class="sidebar-btn">Home</button></a>
    <button class="sidebar-btn" onclick="loadSettings()">Settings</button>
    <button class="sidebar-btn" onclick="loadAddress()">Address</button>
    <button class="sidebar-btn" onclick="logout()">Logout</button>
  </div>


  <!-- Main Content -->
  <div class="main-content" id="main-content">
    <!-- Default content (Settings Form) -->
    <h1>Account Settings</h1>
    <form action="account_update_settings.php" method="POST">
        <div class="form-group">
            <label for="address">Complete Delivery Address</label>
            <input type="text" id="address" name="address" placeholder="Enter your delivery address" required>
        </div>
        <div class="form-group">
            <label for="house_number">House Number</label>
            <input type="text" id="house_number" name="house_number" placeholder="Enter House Number" required>
        </div>
        <div class="form-group">
            <label for="barangay_name">Barangay Name</label>
            <input type="text" id="barangay_name" name="barangay_name" placeholder="Enter Barangay Name" required>
        </div>
        <div class="form-group">
            <label for="municipality">Municipality</label>
            <input type="text" id="municipality" name="municipality" placeholder="Enter Municipality" required>
        </div>
        <button type="submit" class="update-btn">Update Settings</button>
    </form>


  </div>

  <!-- Hidden Data (PHP variables stored in JS-readable format) -->
  <div id="user-data" data-first-name="<?php echo htmlspecialchars($user_first_name); ?>" data-last-name="<?php echo htmlspecialchars($user_last_name); ?>" data-email="<?php echo htmlspecialchars($user_email); ?>"></div>

  <!-- JavaScript to dynamically load content and handle sidebar toggle -->
  <script>
    // Function to load settings content dynamically
    function loadSettings() {
      const userData = document.getElementById('user-data');
      const firstName = userData.getAttribute('data-first-name');
      const lastName = userData.getAttribute('data-last-name');
      const email = userData.getAttribute('data-email');

      const mainContent = document.getElementById('main-content');
      mainContent.innerHTML = `
        <h1>Account Settings</h1>
        <form action="account_update_settings.php" method="POST">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" value="${firstName}" required>
          </div>

          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="${lastName}" required>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="${email}" required>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter new password">
          </div>

          <button type="submit" class="update-btn">Update Settings</button>
        </form>
      `;
    }

    // Function to load address content dynamically
    // Function to load address content dynamically
function loadAddress() {
  const mainContent = document.getElementById('main-content');
  mainContent.innerHTML = `
    <h1>Update Address</h1>
    <form action="account_update_address.php" method="POST">
      <div class="form-group">
        <label for="address">Complete Delivery Address</label>
        <input type="text" id="address" name="address" placeholder="Enter your delivery address" required>
      </div>

      <div class="form-group">
        <label for="barangay_number">House number</label>
        <input type="text" id="house_number" name="barangay_number" placeholder="Enter House Number" required>
      </div>

      <div class="form-group">
        <label for="barangay_name">Barangay Name</label>
        <input type="text" id="barangay_name" name="barangay_name" placeholder="Enter Barangay Name" required>
      </div>

      <div class="form-group">
        <label for="municipality">Municipality</label>
        <input type="text" id="municipality" name="municipality" placeholder="Enter Municipality" required>
      </div>

      <button type="submit" class="update-btn">Update Address</button>
    </form>
  `;
}


    // Function to handle logout
    function logout() {
      window.location.href = 'logout.php'; // Redirect to logout
    }

    // Function to toggle sidebar visibility on mobile view

        function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
        }

        // Add event listener for mobile view
        document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.createElement('button');
        mobileMenuBtn.textContent = 'Menu';
        mobileMenuBtn.classList.add('mobile-menu-btn');
        mobileMenuBtn.onclick = toggleSidebar;
        document.body.appendChild(mobileMenuBtn);
        });

  </script>

</body>
</html>
