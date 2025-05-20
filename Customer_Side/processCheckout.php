<?php
include 'IPTconnect.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate required fields
    if (empty($data['user_id']) || empty($data['address']) || empty($data['products']) || empty($data['total_price'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit;
    }

    $user_id = intval($data['user_id']);
    $address = $data['address'];
    $products = $data['products']; // Already a JSON string
    $total_price = floatval($data['total_price']);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO orders (user_id, address, products, total_price, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("issd", $user_id, $address, $products, $total_price);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        $orderId = $stmt->insert_id;
        echo json_encode(['success' => true, 'orderId' => $orderId]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
