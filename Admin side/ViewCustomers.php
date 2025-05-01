<?php
include 'IPTconnect.php';
session_start();

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
    color: var(--color-dark);
}
.page {
      width: 100%;
      height: 130px;
      position: sticky;
      top: 0;
      z-index: 1000;
    
}
.logo{
    background-color: var(--color-light);
    align-items: center;
    position: relative;
}
.logo img{
    border-radius: 50%;
}
.container{
    display: grid;
    width: 100%;
    margin: 0 auto;
    gap: 1.8rem;
    grid-template-columns: 14rem auto 23rem;
    background-color: var(--color-white);
}


a{
    color: var(--color-dark);
}

aside{
    height: 100vh;
    background: white;
    overflow-y: auto;
    border-right: 1px solid;
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


main h1 {
    margin: 1.5rem 0 1rem 1.5rem;
    font-size: 2rem;
    font-weight: 600;
}


main .Customer {
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 1rem;
    box-sizing: border-box;
}

.Customer table {
    width: 100%;
    max-width: 1200px;
    border-collapse: collapse;
    background: white;
    box-shadow: var(--box-shadow);
    overflow: hidden;
    margin: 0 auto;
}

.Customer table th,
.Customer table td {
    border: 1px solid #ccc;
    padding: 1rem;
    text-align: left;
}

.Customer table th {
    background-color: var(--color-light);
    font-weight: 600;
}


</style>
<body>
<section class="header1">
    <img src="img - Copy\deli.jpg" class="page" alt="Header Image"/>
</section>
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
                <a href="ViewCustomers.php" class="active">
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
            <h1>Customers</h1>
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
        </main>
    </div>
</body>
</html>