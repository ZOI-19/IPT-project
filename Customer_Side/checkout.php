<?php
// checkout.php
header('Content-Type: application/json');

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!$data || empty($data['cart'])) {
    echo json_encode(['success' => false, 'message' => 'No cart data received.']);
    exit;
}

// Prepare orders file
$ordersFile = 'orders.json';
if (!file_exists($ordersFile)) {
    file_put_contents($ordersFile, '[]');
}
$orders = json_decode(file_get_contents($ordersFile), true);

// Create new order
$newOrder = [
    'order_id' => count($orders) + 1,
    'timestamp' => date('Y-m-d H:i:s'),
    'name' => $data['name'],
    'email' => $data['email'],
    'phone' => $data['phone'],
    'address' => $data['address'],
    'payment_method' => $data['payment_method'],
    'items' => $data['cart'],
    'total_price' => array_reduce($data['cart'], function ($sum, $item) {
        return $sum + ($item['price'] * $item['quantity']);
    }, 0),
    'status' => 'pending'
];

// Add and save
$orders[] = $newOrder;
file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));

// Respond
echo json_encode(['success' => true, 'message' => 'Order saved successfully.']);
?>
