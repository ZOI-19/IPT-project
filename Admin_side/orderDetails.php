<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'IPTconnect.php'; // Assume this initializes $conn DB connection

// Check if 'id' is set in the GET request
if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Order ID is required.']);
    exit;
}

$order_id = intval($_GET['id']);
$query = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo json_encode(['success' => false, 'message' => 'Order not found.']);
    exit;
}

// Assuming $products is correctly fetched and decoded
$products = json_decode($order['products'], true); // Decode the JSON string

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Invalid products data.']);
    exit;
}

// Return the order details as JSON
echo json_encode([
    'success' => true,
    'id' => $order['id'],
    'user_id' => $order['user_id'],
    'address' => $order['address'],
    'total_price' => $order['total_price'],
    'products' => $products
]);

?>
