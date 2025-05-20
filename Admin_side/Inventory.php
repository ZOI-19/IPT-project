    <?php
    // Include DB connection
    $conn = new mysqli("localhost", "root", "", "iptdelezuskai");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch all products
    $sql = "SELECT * FROM products ORDER BY id DESC";
    $result = $conn->query($sql);
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

    :root {
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

    .dark-theme-variable {
        --color-background: #181a1e;
        --color-white: #202528;
        --color-dark: #edeffd;
        --color-dark-variant: #a3bdcc;
        --color-light: rgba(0, 0, 0, 0.4);
        --box-shadow: 0 2rem 3rem var(--color-light);
    }

    * {
        margin: 0;
        padding: 0;
        outline: 0;
        appearance: none;
        border: 0;
        text-decoration: none;
        list-style: none;
        box-sizing: border-box;
    }

    html {
        font-size: 14px;
    }

    body {
        width: 100vw;
        height: 100vh;
        font-family: poppins, sans-serif;
        font-size: 0.88rem;
        background: var(--color-background);
        user-select: none;
        overflow: hidden;
        color: var(--color-dark);
    }

    .page {
        display: block;
        width: 100%;
        height: 130px;
        margin: 0 auto;
    }

    /* Main Content Styling */
    .container {
        display: flex; /* Use flexbox for the container */
        height: 100%;
    }


    /* Sidebar Styling */
    aside {
        width: 18rem;
        height: 100vh;
        background: white;
        box-shadow: var(--box-shadow);
        position: fixed; /* Keep sidebar fixed */
        left: 0;
        overflow-y: auto;
    }

    /* Sidebar Top Section */
    aside .top {
        background: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1.4rem;
    }

    aside .logo {
        display: flex;
        gap: 0.8rem;
    }

    aside .logo img {
        width: 2rem;
        height: 2rem;
    }

    aside .close {
        display: none;
    }

    /* Sidebar Links */
    aside .sidebar {
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        top: 3rem;
    }

    aside h3 {
        font-weight: 500;
    }

    aside .sidebar a {
        display: flex;
        color: var(--color-info-dark);
        margin: 1rem;
        gap: 1rem;
        align-items: center;
        position: relative;
        height: 3.7rem;
        transition: all 300ms ease;
    }

    aside .sidebar a span {
        font-size: 1.6rem;
        transition: all 300ms ease;
    }

    aside .sidebar a:last-child {
        bottom: 1rem;
        width: 100%;
    }

    aside .sidebar a.active {
        background: var(--color-light);
        color: var(--color-primary);
        margin-left: 0;
    }

    aside .sidebar a.active::before {
        content: '';
        width: 6px;
        height: 100%;
        background: var(--color-primary);
    }

    aside .sidebar a.active span {
        color: var(--color-primary);
        margin-left: calc(1rem - 3px);
    }

    aside .sidebar a:hover {
        color: var(--color-primary);
    }

    aside .sidebar a:hover span {
        margin-left: 1rem;
    }

    aside .sidebar .message-count span {
        background: var(--color-danger);
        color: var(--color-white);
        padding: 2px 10px;
        font-size: 11px;
        border-radius: var(--border-radius-1);
    }

    /* Product Management Section */
    .Product {
        margin-left: 18rem;
        width: calc(100% - 18rem);
        height: 100vh;
        padding: 2rem;
        box-sizing: border-box;
        overflow-y: auto;
        position: relative;
    }

    /* Product Header */
    .product-header h2 {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    /* Table Container */
    .product-table-container {
        width: 100%;
        padding: 1rem;
        box-sizing: border-box;
    }

    .Product table {
        width: 94%;
        border-collapse: collapse;
        background: white;
        box-shadow: var(--box-shadow);
    }

    .Product table th, .Product table td {
        padding: 1rem;
        border: 1px solid #ccc;
        text-align: left;
    }


    /* Add Product Button */
    .Add-Product {
        position: absolute;
        right: 2rem;
        top: 10rem;
        padding: 0.8rem 1.2rem;
        background-color: var(--color-primary);
        color: white;
        border-radius: var(--border-radius-2);
        cursor: pointer;
        font-size: 1rem;
        z-index: 3;
    }


    aside, .Product {
        overflow-y: auto; /* Allow scrolling if content overflows */
        scrollbar-width: none;
    }

    /* Style for Table Column with Description */
    th.desc-column, td.desc-column {
        width: 50%; /* Increased width of description column */
        word-wrap: break-word;
    }
    body {
        overflow-y: auto;
    }
    body::-webkit-scrollbar {
        scrollbar-width: none   ;
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
                    <a href="Inventory.php" class="active">
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
                <a href="add_product.php"><button class="Add-Product">+ Add Product</button></a>
                <div class="Product" id="Product">
                <div class="product-header">
                    <h2>Product List</h2>
                </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th class="desc-column">Description</th>
                                <th>Quantity</th>
                                <th>Image</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td>₱<?= number_format($row['price'], 2) ?></td>
                                    <td><?= htmlspecialchars($row['category']) ?></td>
                                    <td><?= htmlspecialchars($row['description']) ?></td>
                                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                                    <td>
                                        <?php if ($row['image']): ?>
                                            <img src="./uploads/<?= htmlspecialchars($row['image']) ?>" alt="Image" width="50">
                                        <?php else: ?>
                                            No image
                                        <?php endif; ?>
                                    </td>
                                    <td class="actions">
                                        <a href="add_product.php?id=<?= $row['id'] ?>">✏️ Edit</a> |
                                        <a href="manage_product.php?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Delete this product?')">🗑️ Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="8">No products found.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
        </div>

    </body>
    </html>