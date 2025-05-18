<?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
$host = "localhost";
$user = "root";
$pass = "";
$db = "iptdelezuskai";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';
   error_log("Script started"); // At the beginning of the script
   
// Resolve category ID (create if not exists)
function resolveCategoryId($conn, $category, $newCategory) {
    $finalCategory = !empty($newCategory) ? trim($newCategory) : trim($category);
    if (empty($finalCategory)) return 0;

    $category_id = 0; // Initialize to avoid undefined variable
    $stmt = $conn->prepare("SELECT id FROM categories WHERE name = ?");
    $stmt->bind_param("s", $finalCategory);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $stmt->close();
        $insert = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        if ($insert) {
            $insert->bind_param("s", $finalCategory);
            if ($insert->execute()) {
                $category_id = $insert->insert_id;
            }
            $insert->close();
        }
    } else {
        $stmt->bind_result($category_id);
        $stmt->fetch();
        $stmt->close();
    }

    return $category_id;
}




// ADD PRODUCT
if ($action === 'add') {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $category = $_POST['category'] ?? '';
    $newCategory = $_POST['new_category'] ?? '';
    $description = trim($_POST['description']);
    $quantity = intval($_POST['quantity']);
    $imageName = '';

    $category_id = resolveCategoryId($conn, $category, $newCategory);
    if (!$category_id) die("Invalid category.");

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $imageName = uniqid() . "_" . basename($_FILES["image"]["name"]);
        $uploadDir = 'uploads/';
        $targetFile = $uploadDir . $imageName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileType, $allowedTypes)) {
            die("Only JPG, JPEG, PNG & GIF files are allowed.");
        }



        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            die("Error uploading file.");
        }
    }

    $stmt = $conn->prepare("INSERT INTO products (name, price, category, description, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdssis", $name, $price, $category_id, $description, $quantity, $imageName);
    $stmt->execute();
    $stmt->close();

    header("Location: Inventory.php");
    exit();
}

// UPDATE PRODUCT
elseif ($action === 'update') {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $category = $_POST['category'] ?? '';
    $newCategory = $_POST['new_category'] ?? '';
    $description = trim($_POST['description']);
    $quantity = intval($_POST['quantity']);

    $category_id = resolveCategoryId($conn, $category, $newCategory);
    if (!$category_id) die("Invalid category.");

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target = 'uploads/' . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, category=?, description=?, quantity=?, image=? WHERE id=?");
        $stmt->bind_param("sdssisi", $name, $price, $category_id, $description, $quantity, $image_name, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, category=?, description=?, quantity=? WHERE id=?");
        $stmt->bind_param("sdssii", $name, $price, $category_id, $description, $quantity, $id);
    }
    $stmt->execute();
    $stmt->close();

    header("Location: Inventory.php");
    exit();
}
// Deduct stock action
if ($action === 'deduct_stock') {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = intval($data['productId']);
    $quantity = intval($data['quantity']);

    // Update the product stock
    $stmt = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
    $stmt->bind_param("ii", $quantity, $productId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating stock.']);
    }
    $stmt->close();
}

// Move order to Packing action
if ($action === 'move_to_packing') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['orderId'])) {
        echo json_encode(['success' => false, 'message' => 'Order ID is required.']);
        exit;
    }

    $orderId = intval($data['orderId']);
    $stmt = $conn->prepare("UPDATE orders SET status = 'packing' WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error moving order.']);
    }
    $stmt->close();
    exit; // Ensure to exit after sending the response
}


if ($action === 'move_to_dispatch') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['orderId'])) {
        echo json_encode(['success' => false, 'message' => 'Order ID is required.']);
        exit;
    }

    $orderId = intval($data['orderId']);
    $stmt = $conn->prepare("UPDATE orders SET status = 'dispatch' WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $response = ['success' => true]; // or false based on your logic
        $jsonResponse = json_encode($response);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['success' => false, 'message' => 'JSON encoding error: ' . json_last_error_msg()]);
        } else {
            echo $jsonResponse;
        }
        exit;
        


    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
        error_log("Move to dispatch action triggered");
    } else {
        echo json_encode(['success' => false, 'message' => 'Error moving order.']);
    }
    $stmt->close();
    exit; // Ensure to exi  t after sending the response
}


   

if ($action === 'move_to_packing_and_deduct') {
    $data = json_decode(file_get_contents('php://input'), true);
    $orderId = intval($data['orderId']);

    // Fetch order
    $stmt = $conn->prepare("SELECT products FROM orders WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    if (!$order) {
        echo json_encode(['success' => false, 'message' => 'Order not found.']);
        exit;
    }

    $products = json_decode($order['products'], true);

    if (json_last_error() !== JSON_ERROR_NONE || !is_array($products)) {
        echo json_encode(['success' => false, 'message' => 'Invalid product data.']);
        exit;
    }

    // Deduct quantity for each product
    foreach ($products as $product) {
        $productId = intval($product['id']);
        $quantity = intval($product['quantity']);

        $stmt = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
        $stmt->bind_param("ii", $quantity, $productId);
        $stmt->execute();
        $stmt->close();
    }

    // Move order status to 'packing'
    $stmt = $conn->prepare("UPDATE orders SET status = 'packing' WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update order status.']);
    }
    $stmt->close();
}

?>