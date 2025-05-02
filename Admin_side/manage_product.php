<?php
echo '<pre>';
print_r($_FILES);
echo '</pre>';


$host = "localhost";
$user = "root";
$pass = "";
$db = "iptdelezuskai"; // Replace with your DB name

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determine action: add, update, or delete
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add') {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $imageName = '';

    // Check for duplicate name
    $stmt = $conn->prepare("SELECT id FROM products WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        die("Error: A product with the name '$name' already exists. <a href='add_product.php'>Go back</a>");
    }
    $stmt->close();

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $imageName = uniqid() . "_" . basename($_FILES["image"]["name"]);
        $uploadDir = 'uploads/';
        $targetFile = $uploadDir . $imageName;
    
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // success
        } else {
            die("Error uploading file. Check folder permissions and file size.");
        }
    }
    

    $stmt = $conn->prepare("INSERT INTO products (name, price, category, description, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsss", $name, $price, $category, $description, $imageName);
    $stmt->execute();
    $stmt->close();

    header("Location: Inventory.php");
    exit();
}


 elseif ($action === 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? '';
    
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target = 'uploads/' . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        
        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, category=?, description=?, image=? WHERE id=?");
        $stmt->bind_param("sdsssi", $name, $price, $category, $description, $image_name, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, category=?, description=? WHERE id=?");
        $stmt->bind_param("sdssi", $name, $price, $category, $description, $id);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: Inventory.php");

} elseif ($action === 'delete') {
    $id = $_GET['id'] ?? 0;
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: Inventory.php");
}

$conn->close();
?>
