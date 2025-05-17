<?php
// Start session
session_start();


include("IPTconnect.php"); 
include("IPTfunction.php"); 

// Check if user is logged in
$user_data = check_login($conn);
include 'IPTconnect.php';


// Fetch users and their total orders
$query = "
    SELECT 
     u.id, u.fname, u.lname, u.email,
    COUNT(o.id) AS total_orders
    FROM users u
    LEFT JOIN orders o ON u.id = o.user_id
    GROUP BY u.id, u.fname, u.lname, u.email
    ORDER BY u.id DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--MATERIAL CDN-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Sharp" rel="stylesheet">


    <!--STYLE SHEET-->
    <link rel="stylesheet" href="dashboardstyle.css">
</head>
<body>
<div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="image\SSD.jpeg" alt="">
                    <h2 class="danger">Delizeus Kai Food Products</h2>
                </div>
                <div class="close" id="close-btn">
                <span class="material-symbols-sharp">close</span>
                </div>
            </div>
            <div class="sidebar">
                <a href="Dashboard.php" class="active">
                    <span class="material-symbols-sharp">dashboard</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="ViewOrders.php">
                    <span class="material-symbols-sharp">receipt_long</span>
                    <h3>Orders</h3>
                </a>
                <a href="ViewCustomers.php">
                    <span class="material-symbols-sharp">groups</span>
                    <h3>View Customers</h3>
                </a>
                <a href="Inventory.php">
                    <span class="material-symbols-sharp">inventory_2</span>
                    <h3>Inventory</h3>
                </a>
                <a href="Message.php">
                    <span class="material-symbols-sharp">mail</span>
                    <h3>Message</h3>
                    <span class="message-count">26</span>
                </a>
                <a href="Settings.php">
                    <span class="material-symbols-sharp">settings</span>
                    <h3>Settings</h3>
                </a>
                <a href="#" class="Logout">
                    <span class="material-symbols-sharp">logout</span>
                    <h3>Logout</h3>
                </a>  
            </div>
        </aside>
        <main>
            <h1>Dashboard</h1>

            <div class="date">
                <input type="date">
            </div>

            <div class="insights">
                <div class="sales">
                <span class="material-symbols-sharp">monitoring</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Sales</h3>
                            <h1>₱25,024</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx= '38' cy='38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>51%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 hours</small>
                </div>
                <!-------------- END OF SALES ------------->
                <div class="expenses">
                    <span class="material-symbols-sharp">monitoring</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Expenses</h3>
                            <h1>₱14,024</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx= '38' cy='38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>62%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 hours</small>
                </div>
                <!-------------- END OF EXPENSES -------------> 
                <div class="income">
                    <span class="material-symbols-sharp">monitoring</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Income</h3>
                            <h1>₱40,052</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx= '38' cy='38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>44%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 hours</small>
                </div>
                <!-------------- END OF INCOME ------------->
            </div>
            <!------------------- END OF INSIGHTS ------------------>

            <div class="Customer">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Total Orders</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['fname'] . ' ' . $row['lname']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= $row['total_orders'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="Recent-Orders">
                
            </div>
        </main>
        <!------------------------------ END OF MAIN ------------------------>

        <div class="right">
            <div class="top">
                <button id="menu-btn">
                <span class="material-symbols-sharp">menu</span>
                </button>
                <div class="theme-toggler">
                    <span id="" class="material-symbols-sharp active">light_mode</span>
                    <span class="material-symbols-sharp">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Daniel</b></p>
                        <small class="text">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="image\SSD.jfif" >
                    </div>
                </div>
            </div>
            <!-------------END OF TOP------------>
            <div class="recent-updates">
                <h2>Recent Updates</h2>
                <div class="updates">
                    <div class="update">
                        <div class="profile-photo">
                            <img src="image\bakcgroud.jpg">
                        </div>
                        <div class="message">
                            <p><b>Mike Tyson</b> received his order of night lion tech gps drone <small class="text-muted">2 munites ago</small></p>
                        </div>
                    </div>
                    <div class="update">
                        <div class="profile-photo">
                            <img src="image\bakcgroud.jpg">
                        </div>
                        <div class="message">
                            <p><b>Mike Tyson</b> received his order of night lion tech gps drone <small class="text-muted">2 munites ago</small></p>
                        </div>
                    </div>
                    <div class="update">
                        <div class="profile-photo">
                            <img src="image\bakcgroud.jpg">
                        </div>
                        <div class="message">
                            <p><b>Mike Tyson</b> received his order of night lion tech gps drone <small class="text-muted">2 munites ago</small></p>
                        </div>
                    </div>
                </div>
                <!------------------------ END OF RECENT UPDATES -------------------------->
        <script>
const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");
const themetoggler = document.querySelector(".theme-toggler");

// Open sidebar
menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
});

// Close sidebar
closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
});

// Theme toggle
const themeToggler = document.querySelector('.theme-toggler');
const spans = themeToggler.querySelectorAll('.material-symbols-sharp');

themeToggler.addEventListener('click', () => {
    // Toggle active class
    spans.forEach(span => span.classList.toggle('active'));

    // Toggle theme on body
    document.body.classList.toggle('dark-theme');
});

</script>

</body>
</html>