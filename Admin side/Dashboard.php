<?php

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
                    <img src="img - Copy\SSD.jpeg" alt="">
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
                <a href="Orders.php">
                    <span class="material-symbols-sharp">receipt_long</span>
                    <h3>Orders</h3>
                </a>
                <a href="#" class="active">
                    <span class="material-symbols-sharp">groups</span>
                    <h3>View Customers</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-sharp">inventory_2</span>
                    <h3>Inventory</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-sharp">mail</span>
                    <h3>Message</h3>
                    <span class="message-count">26</span>
                </a>
                <a href="#">
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

            <div class="recent-order">
                <h2>Recent Orders</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product Number</th>
                            <th>Payment</th>
                            <th>status</th>
                            <th>due</th>
                            <th>Pending</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Foldable Mini drone</td>
                            <td>85631</td>
                            <td>due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>Foldable Mini drone</td>
                            <td>85631</td>
                            <td>due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>Foldable Mini drone</td>
                            <td>85631</td>
                            <td>due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>Foldable Mini drone</td>
                            <td>85631</td>
                            <td>due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>Foldable Mini drone</td>
                            <td>85631</td>
                            <td>due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                </table>
                <a href="">Show All</a>
            </div>
        </main>
        <!------------------------------ END OF MAIN ------------------------>

        <div class="right">
            <div class="top">
                <button id="menu-btn">
                <span class="material-symbols-sharp">menu</span>
                </button>
                <div class="theme-toggler">
                    <span class="material-symbols-sharp active">light_mode</span>
                    <span class="material-symbols-sharp">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Daniel</b></p>
                        <small class="text">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="img - Copy\SSD.jfif" >
                    </div>
                </div>
            </div>
            <!-------------END OF TOP------------>
            <div class="recent-updates">
                <h2>Recent Updates</h2>
                <div class="updates">
                    <div class="update">
                        <div class="profile-photo">
                            <img src="img - Copy\bakcgroud.jpg">
                        </div>
                        <div class="message">
                            <p><b>Mike Tyson</b> received his order of night lion tech gps drone <small class="text-muted">2 munites ago</small></p>
                        </div>
                    </div>
                    <div class="update">
                        <div class="profile-photo">
                            <img src="img - Copy\bakcgroud.jpg">
                        </div>
                        <div class="message">
                            <p><b>Mike Tyson</b> received his order of night lion tech gps drone <small class="text-muted">2 munites ago</small></p>
                        </div>
                    </div>
                    <div class="update">
                        <div class="profile-photo">
                            <img src="img - Copy\bakcgroud.jpg">
                        </div>
                        <div class="message">
                            <p><b>Mike Tyson</b> received his order of night lion tech gps drone <small class="text-muted">2 munites ago</small></p>
                        </div>
                    </div>
                </div>
                <!------------------------ END OF RECENT UPDATES -------------------------->
                <div class="sales-analytics">
                    <h2>Sales analytics</h2>
                    <div class="item online">
                        <div class="icon">
                            <span class="material-symbols-sharp">shopping_cart</span>
                        </div>
                        <div class="righ">
                            <div class="info">
                                <h3>Online Orders</h3>
                                <small class="text-muted">Last 24 hours</small>
                            </div>
                            <h5 class="success">+25%</h5>
                            <h3>849</h3>
                        </div>
                    </div>
                    <div class="item offline">
                        <div class="icon">
                            <span class="material-symbols-sharp">shopping_cart</span>
                        </div>
                        <div class="righ">
                            <div class="info">
                                <h3>offline Orders</h3>
                                <small class="text-muted">Last 24 hours</small>
                            </div>
                            <h5 class="danger">-17%</h5>
                            <h3>1100</h3>
                        </div>
                    </div>
                    <div class="item customers">
                        <div class="icon">
                            <span class="material-symbols-sharp">shopping_cart</span>
                        </div>
                        <div class="righ">
                            <div class="info">
                                <h3>New customers</h3>
                                <small class="text-muted">Last 24 hours</small>
                            </div>
                            <h5 class="success">+25%</h5>
                            <h3>849</h3>
                        </div>
                    </div>
                    <div class="item add-product">
                        <div>
                            <span class="material-icons-sharp">add</span>
                            <h3>Add Product</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script src="dashboard.js"></script>
</body>
</html>