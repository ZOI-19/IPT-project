<?php
header('Content-Type: application/json');
require 'IPTconnect.php'; // or your DB connection

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];

while($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
?>
