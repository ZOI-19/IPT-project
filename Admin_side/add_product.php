    <?php
    $conn = new mysqli("localhost", "root", "", "iptdelezuskai");
    $product = ['id' => '', 'name' => '', 'price' => '', 'category' => '', 'description' => '', 'quantity' => ''];

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
    }

    $isUpdate = !empty($product['id']);
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title><?= $isUpdate ? "Update" : "Add" ?> Product</title>
    </head>
    <style>
        /* Apply blur background and centering */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            backdrop-filter: blur(8px);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            flex-direction: column;
            color: #333;
        }
        .Back {
            position: fixed;
            top: 1rem;
            left: 1rem;
            color: white;
            background: rgba(0, 0, 0, 0.4);
            padding: 0.5rem 1rem;
            border-radius: 0.4rem;
            text-decoration: none;
            font-weight: 500;
            z-index: 999;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #fff;
            background: rgba(0, 0, 0, 0.6);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }


        form {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 500px;
        }

        label {
            font-weight: 600;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 0.8rem;
            margin-top: 0.3rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        button {
            background-color: #7380ec;
            color: white;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #5a67d8;
        }

        a {
            margin-top: 1rem;
            display: inline-block;
            color: white;
            background: rgba(0, 0, 0, 0.4);
            padding: 0.5rem 1rem;
            border-radius: 0.4rem;
            text-decoration: none;
            font-weight: 500;
        }

        img {
            margin-top: 0.5rem;
            border-radius: 0.3rem;
        }
    </style>
    <body>
    <a class="Back" href="Inventory.php">⬅️ Back to Inventory</a>
    <h2><?= $isUpdate ? "Update" : "Add New" ?> Product</h2>

    <form action="manage_product.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?= $isUpdate ? 'update' : 'add' ?>">
        <?php if ($isUpdate): ?>
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <?php endif; ?>

        <label>Name:</label><br>
        <input type="text" name="name" required value="<?= htmlspecialchars($product['name']) ?>"><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" required value="<?= htmlspecialchars($product['price']) ?>"><br><br>

        <label>Category (Select or Add New):</label><br>
            <select name="category" id="categorySelect">
                <option value="">-- Select Category --</option>
                <?php
                $catQuery = $conn->query("SELECT name FROM categories ORDER BY name ASC");
                while ($row = $catQuery->fetch_assoc()) {
                    $catName = $row['name'];
                    $selected = ($product['category'] == $catName) ? 'selected' : '';
                    echo "<option value=\"$catName\" $selected>$catName</option>";
                }
                ?>
            </select><br><br>

            <label>Or Add New Category:</label><br>
            <input type="text" name="new_category" placeholder="e.g., Sweet and Sour"><br><br>



        <label>Description:</label><br>
        <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea><br><br>
        
        <label>Stock quantity:</label><br>
        <textarea name="quantity"><?= htmlspecialchars($product['quantity']) ?></textarea><br><br>

        <label>Image:</label><br>
        <input type="file" name="image"><br>
        <?php if ($isUpdate && $product['image']): ?>
            <img src="uploads/<?= htmlspecialchars($product['image']) ?>" width="80"><br>
        <?php endif; ?>

        <button type="submit"><?= $isUpdate ? "Update" : "Add" ?> Product</button>
    </form>



    </body>
    </html>
