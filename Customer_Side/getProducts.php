<?php
header('Content-Type: application/json');

// Include your database connection
include('IPTconnect.php');

$sql = "SELECT * FROM products WHERE status = 'active'";
$result = $conn->query($sql);

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'price' => $row['price'],
        'image' => $row['image'],
        'category' => $row['category'],
        'description' => $row['description']
    ];
}

echo json_encode($products);

$conn->close();
?>
