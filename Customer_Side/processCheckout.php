<?php
include 'IPTconnect.php'; // Assume this initializes $conn DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true); // Get JSON data
    $user_id = intval($data['user_id']);
    $address = $data['address'];
    $products = $data['products']; // This is a JSON string
    $total_price = floatval($data['total_price']);

    $stmt = $conn->prepare("INSERT INTO orders (user_id, address, products, total_price, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("issd", $user_id, $address, $products, $total_price);

    if ($stmt->execute()) {
        $orderId = $stmt->insert_id; // Get the newly created order ID
        echo json_encode(['success' => true, 'orderId' => $orderId]); // Include order ID in response
    } else {
        echo json_encode(['success' => false, 'message' => 'Error processing order: ' . $stmt->error]);
    }
}

?>
