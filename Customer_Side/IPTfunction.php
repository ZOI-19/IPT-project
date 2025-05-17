<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function check_login($conn) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Use prepared statement to avoid SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user_data = $result->fetch_assoc()) {
            return $user_data;
        }
    }

    // Redirect if not logged in or user not found
    header("Location: loginform.php");
    exit;
}

function update_product_status_to_pending($conn, $product_id) {
    $sql = "UPDATE products SET status = 'Pending' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
}

function get_products($conn) {
    $sql = "SELECT * FROM products WHERE status = 'Active' ORDER BY date_added DESC";
    $result = mysqli_query($conn, $sql);
    
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    return $products;
}

function get_categories($conn) {
    $sql = "SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != ''";
    $result = mysqli_query($conn, $sql);
    
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category'];
    }

    return $categories;
}
?>
