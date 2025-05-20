<?php
session_start();
include("IPTconnect.php");
include("IPTfunction.php");

// Check if user is logged in
$user_data = check_login($conn);
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
// Check if the query was successful
if (!$result) {
    echo "Error: " . mysqli_error($conn); // Display error message
    exit; // Stop execution if there's an error
}
// Fetch all orders regardless of status
$query_orders = "SELECT * FROM orders"; 
$stmt = $conn->prepare($query_orders);
$stmt->execute();
$result_orders = $stmt->get_result();
$orders = $result_orders->fetch_all(MYSQLI_ASSOC); // Fetch all orders as an associative array
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
    width: 100%;
    font-family: poppins, sans-serif;
    font-size: 0.88rem;
    background: var(--color-background);
    user-select: none;
    color: var(--color-dark);
}
body.dark-theme {
    background-color: #121212;
    color: white;
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

img{
    display: block;
    width: 100%;
}

h1{
    font-weight: 800;
    font-size: 1.8rem;
}

h2{
    font-size: 1.4rem;
}

h3{
    font-size: 0.87rem;
}

h4{
    font-size: 0.rem;
}

h5{
    font-size: 0.77rem;
}

small{
    font-size: 0.75rem;
}

.profile-photo{
    width: 2.8rem;
    height: 2.8rem;
    border-radius: 50%;
    overflow: hidden;
}

.text-muted{
    color: var(--color-info-dark);
}

p{
    color: var(--color-dark-variant);
}

b{
    color: var(--color-dark);
}

.primay{
    color: var(--color-primary);
}
.danger{
    color: var(--color-danger);
}
.success{
    color: var(--color-success);
}
.warning{
    color: var(--color-warning);
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

aside .close {
    display: none; /* Show close button */
    position: absolute;
    top: 1rem;
    right: 1rem;
    cursor: pointer;
}

/* == SIDEBAR ==*/
aside .sidebar {
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




/* =================== MAIN ==================*/
main{
   margin-top: 1.4rem; 
}

/* New container for the top two sections in one row */
.top-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.4rem;
}

/* Adjust date to fit nicely on left */
.date {
    background: var(--color-light);
    border-radius: var(--border-radius-1);
    padding: 0.5rem 1.6rem;
    display: inline-block;
}

/* Styling for date input */
.date input[type='date']{
    background: transparent;
    color: var(--color-dark);
    border: none;
    font-size: 1rem;
}

/* Right section next to date */
.right {
    display: flex;
    align-items: center;
}

/* The top div inside right */
.right .top{
    display: flex;
    justify-content: flex-end;
    gap: 2rem;
    background: var(--color-info-light);
    padding: 0.3rem 1rem;
    border-radius: var(--border-radius-1);
}

/* Hide menu button by default */
.right .top button{
    display: none;
}

/* Theme toggler */
.right .theme-toggler{
    background: var(--color-light);
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 1.6rem;
    width: 4.2rem;
    cursor: pointer;
    border-radius: var(--border-radius-1);
}

.right .theme-toggler span{
    font-size: 1.2rem;
    width: 50%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.right .theme-toggler span.active{
    background: var(--color-primary);
    color: white;
    border-radius: var(--border-radius-1);
}

.right .top .profile{
    display: flex;
    gap: 2rem;
    text-align: right;
}

/* New container for insights and recent updates in one row */
.bottom-row {
    display: flex;
    justify-content: space-between;
    margin-top: 1.4rem;
    gap: 1.6rem; /* spacing between */
}

/* Adjust insights to take about half width */
.insights {
    flex: 1;
    background: var(--color-white);
    padding: var(--card-padding);
    border-radius: var(--card-border-radius);
    margin-top: 0;
    box-shadow: var(--box-shadow);
    transition: all 300ms ease;
}

/* Ensure hover effect remains */
.insights:hover {
    box-shadow: none;
}

.insights > div span {
    background: var(--color-primary);
    padding: 0.5rem;
    border-radius: 50%;
    color: var(--color-white);
    font-size: 2rem;
}

/* Nested elements inside insights */
.insights > div .middle {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.insights h3{
    margin: 1rem 0 0.6rem;
    font-size: 1rem;
}

.insights .progress {
    position: relative;
    width: 92px;
    height: 92px;
    border-radius: 50%;
}

.insights svg {
    width: 7rem;
    height: 7rem;
}

.insights svg circle {
    fill: none;
    stroke: var(--color-primary);
    stroke-width: 14;
    stroke-linecap: round;
    transform: translate(5px, 5px);
    stroke-dasharray: 110;
    stroke-dashoffset: 92;
}

.insights .sales svg circle {
    stroke-dashoffset: -30;
    stroke-dasharray: 200;
}

.insights .progress .number {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.insights small {
    margin-top: 1.6rem;
    display: block;
}

.time-frame {
    margin-top: 1rem;
}

.time-frame button {
    background: var(--color-primary);
    border: none;
    color: var(--color-white);
    padding: 0.4rem 1rem;
    margin-right: 0.5rem;
    border-radius: var(--border-radius-1);
    cursor: pointer;
    transition: background 0.3s ease;
}

.time-frame button:hover {
    background: var(--color-primary-variant);
}

/* Recent updates take about half width */
.recent-updates {
    flex: 1;
    background: var(--color-white);
    padding: var(--card-padding);
    border-radius: var(--card-border-radius);
    margin-top: 0;
    box-shadow: var(--box-shadow);
    transition: all 300ms ease;
}

.recent-updates:hover {
    box-shadow: none;
}

.recent-updates h2 {
    margin-bottom: 0.8rem;
}

.recent-updates .updates {
    background: var(--color-white);
    padding: var(--card-padding);
    border-radius: var(--card-border-radius);
    box-shadow: var(--box-shadow);
    transition: all 300ms ease;
    overflow-y: auto;
    max-height: 400px; /* optional fixed height for scrolling */
}

.recent-updates .updates:hover {
    box-shadow: none;
}

.recent-updates .update {
    display: grid;
    grid-template-columns: 2.6rem auto;
    gap: 1rem;
    margin-bottom: 1rem;
}

/* Customer and orders tables remain unchanged */
.tables-container {
    width: 100%;
    margin-top: 2rem;
    display: flex;
    gap: 3rem;
}

.tables-container h3{
    display: flex;
}

.Customer, .All-Orders {
    background: var(--color-white);
    padding: var(--card-padding);
    border-radius: var(--card-border-radius);
    box-shadow: var(--box-shadow);
    margin-bottom: 2rem;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background-color: var(--color-light);
    font-weight: 600;
}


/* Other existing styles remain unchanged */

@media screen and (max-width: 1200px){
    .container{
        width: 94%;
        grid-template-columns: 7rem auto 23rem;
    }

    aside .logo h2{
        display: none;
    }

    aside .sidebar h3{
        display: none;
    }

    aside .sidebar a{
        width: 5.6rem;
    }

    aside .sidebar a:last-child{
        position: relative;
        margin-top: 1.8rem;
    }

    main .insights{
        grid-template-columns: 1fr;
        gap: 0;
    }

    main .recent-orders{
        width: 94%;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        margin: 2rem 0 0 8.8rem;
    }

    main .recent-orders table{
        width: 84vw;
    }

    main table thead tr th:last-child,
    main table thead tr th:first-child{
        display: none;
    }

    main table tbody tr th:last-child,
    main table tbody tr th:first-child{
        display: none;
    }

}


@media screen and (max-width: 768px){
    .container{
        width: 100%;
        grid-template-columns: 1fr;
    }

    aside{
        position: fixed;
        left: 0;
        background: var(--color-white);
        width: 18rem;
        z-index: 3;
        box-shadow: 1rem 3rem 4rem var(--color-light);
        height: 100vh;
        padding-right: var(--card-padding);
        display: none;
        animation: showMenu 400ms ease forwards;
    }

    @keyframes  showMenu {
        to{
            left: 0;
        }
    }

    aside .logo{
        margin-left: 1rem;
    }

    aside .logo h2{
        display: inline;
    }

    aside .sidebar h3{
        display: inline;
    }

    aside .sidebar a{
        width: 100%;
        height: 3,4rem;
    }

    aside .sidebar a:last-child{
        position: absolute;
        bottom: 5rem;
    }

    aside .close{
        display: inline-block;
        cursor: pointer;
    }

    main{
        margin-top: 8rem;
        padding: 0 1rem;
    }

    main .recent-orders{
        position: relative;
        margin: 3rem 0 0 0;
        width: 100%;
    }

    main .recent-orders table{
        width: 100%;
        margin: 0;
    }

    .right{
        width: 94%;
        margin:  0 auto 4rem;
    }

    .right .top{
        position: fixed;
        top: 0;
        left: 0;
        align-items: center;
        padding: 0 0.8rem;
        height: 4.6rem;
        background: var(--color-white);
        width: 100%;
        margin: 0;
        z-index:  2;
        box-shadow: 0 1rem 1rem var(--color-light);
    }

    .right .top .theme-toggler{
        width: 4.4rem;
        position: absolute;
        left: 66%;
    }

    .right .profile .info{
        display: none;
    }

    .right .top button{
        display: inline-block;
        background: transparent;
        cursor: pointer;
        color: var(--color-dark);
        position: absolute;
        left: 1rem;
    }

    .right .top button span{
        font-size: 2rem;
    }
    
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
        <main>
            <h1>Dashboard</h1>
            <div class="top-row">
                <div class="date">
                    <input type="date">
                </div>
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
                                <img src="image\SSD.jfif">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bottom-row">
                <div class="insights">
                    <div class="sales">
                        <span class="material-symbols-sharp">monitoring</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Sales</h3>
                                <h1 id="total-sales">₱0.00</h1>
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx='38' cy='38' r='36'></circle>
                                </svg>
                                <div class="number">
                                    <p id="sales-percentage">0%</p>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">Last 24 hours</small>
                        <div class="time-frame">
                            <button onclick="updateSales('weekly')">Weekly</button>
                            <button onclick="updateSales('monthly')">Monthly</button>
                            <button onclick="updateSales('yearly')">Yearly</button>
                        </div>
                    </div>
                </div>
                
                <div class="recent-updates">
                    <h2>Recent Updates</h2>
                    <div class="updates">
                        <div class="update">
                            <div class="profile-photo">
                                <img src="image\bakcgroud.jpg">
                            </div>
                            <div class="message">
                                <p><b>Mike Tyson</b> received his order of night lion tech gps drone <small class="text-muted">2 minutes ago</small></p>
                            </div>
                        </div>
                        <div class="update">
                            <div class="profile-photo">
                                <img src="image\bakcgroud.jpg">
                            </div>
                            <div class="message">
                                <p><b>Mike Tyson</b> received his order of night lion tech gps drone <small class="text-muted">2 minutes ago</small></p>
                            </div>
                        </div>
                        <div class="update">
                            <div class="profile-photo">
                                <img src="image\bakcgroud.jpg">
                            </div>
                            <div class="message">
                                <p><b>Mike Tyson</b> received his order of night lion tech gps drone <small class="text-muted">2 minutes ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                        <!-------------- END OF SALES ------------->
            <div class="tables-container">
                <div class="Customer">
                    <h3>Customers</h3>
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
                            <?php 
                            // Display customer data
                            if ($result) {
                                while($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['id']) ?></td>
                                        <td><?= htmlspecialchars($row['fname'] . ' ' . $row['lname']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= $row['total_orders'] ?></td>
                                    </tr>
                                <?php } 
                            } else {
                                echo "<tr><td colspan='4'>No customer data available.</td></tr>";
                            } ?>
                        </tbody>
                    </table>
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
                                    <td><?php echo ucfirst($order['status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <!------------------------------ END OF MAIN ------------------------>


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
function updateSales(timeFrame) {
    fetch(`getSales.php?timeFrame=${timeFrame}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('total-sales').innerText = `₱${data.totalSales}`;
                document.getElementById('sales-percentage').innerText = `${data.percentage}%`;
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error("Error fetching sales data:", error);
        });
}
</script>

</body>
</html>