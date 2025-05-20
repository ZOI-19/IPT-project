<?php
session_start();
include("IPTconnect.php");
include("IPTfunction.php");

$user_data = check_login($conn);

// Add rider
if (isset($_POST['add_rider'])) {
    $number = $_POST['rider_number'];
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $stmt = $conn->prepare("INSERT INTO delivery_riders (rider_number, first_name, last_name) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $number, $fname, $lname);
    $stmt->execute();
    header("Location: Settings.php");
    exit();
}

// Delete rider
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM delivery_riders WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: Settings.php");
    exit();
}

// Update rider
if (isset($_POST['update_rider'])) {
    $id = $_POST['id'];
    $number = $_POST['rider_number'];
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $stmt = $conn->prepare("UPDATE delivery_riders SET rider_number = ?, first_name = ?, last_name = ? WHERE id = ?");
    $stmt->bind_param("sssi", $number, $fname, $lname, $id);
    $stmt->execute();
    header("Location: Settings.php");
    exit();
}
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
/* Form container */
.rider-form {
    padding: 2rem;
    background: var(--color-white);
    border-radius: var(--border-radius-2);
    box-shadow: var(--box-shadow);
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Section headings inside the form */
.rider-form h2,
.rider-form h3 {
    margin-bottom: 1rem;
    color: var(--color-primary);
}

/* Form input fields */
.rider-form form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.rider-form input[type="text"] {
    padding: 0.8rem 1rem;
    border-radius: var(--border-radius-1);
    border: 1px solid var(--color-info-light);
    background: var(--color-background);
    font-family: inherit;
    font-size: 1rem;
    transition: border 0.3s ease;
}

.rider-form input[type="text"]:focus {
    border: 1px solid var(--color-primary);
    outline: none;
}

/* Form buttons */
.rider-form button {
    padding: 0.8rem 1.5rem;
    background-color: var(--color-primary);
    color: white;
    border-radius: var(--border-radius-1);
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
    align-self: flex-start;
}

.rider-form button:hover {
    background-color: var(--color-primary-variant);
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
                <a href="Dashboard.php">
                    <span class="material-symbols-sharp">dashboard</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="ViewOrders.php">
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

                <a href="Settings.php" class="active">
                    <span class="material-symbols-sharp">settings</span>
                    <h3>Settings</h3>
                </a>
                <a href="Logout.php" class="Logout">
                    <span class="material-symbols-sharp">logout</span>
                    <h3>Logout</h3>
                </a>  
            </div>
        </aside>
    <main class="rider-form">
        <h2>Delivery Rider Information</h2>

        <!-- Add Rider Form -->
        <form method="POST" style="margin-bottom: 2rem;">
            <h3>Add Rider</h3>
            <input type="text" name="rider_number" placeholder="Rider Number" required>
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <button type="submit" name="add_rider">Add Rider</button>
        </form>

        <!-- Table -->
        <table border="1" cellpadding="10" cellspacing="0" style="background:white; width: 100%; border-collapse: collapse;">
            <thead style="background-color: #7380ec; color: white;">
                <tr>
                    <th>Rider Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM delivery_riders");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['rider_number']}</td>";
                    echo "<td>{$row['first_name']}</td>";
                    echo "<td>{$row['last_name']}</td>";
                    echo "<td>
                        <a href='?edit={$row['id']}'>Edit</a> |
                        <a href='?delete={$row['id']}' onclick=\"return confirm('Are you sure?')\">Delete</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <?php if (isset($_GET['edit'])): ?>
        <form method="POST" style="margin-top: 2rem;">
            <h3>Edit Rider</h3>
            <input type="hidden" name="id" value="<?= $edit_row['id'] ?>">
            <input type="text" name="rider_number" value="<?= $edit_row['rider_number'] ?>" required>
            <input type="text" name="first_name" value="<?= $edit_row['first_name'] ?>" required>
            <input type="text" name="last_name" value="<?= $edit_row['last_name'] ?>" required>
            <button type="submit" name="update_rider">Update Rider</button>
        </form>
        <?php endif; ?>
    </main>
</div>
</body>
</html>