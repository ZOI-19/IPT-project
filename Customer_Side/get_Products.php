<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "iptdelezuskai";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed."]));
}

// Get the search term from the request (if available)
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare the SQL query to filter products by name
$sql = "SELECT id, name, price, image, category FROM products WHERE status = 'active' AND name LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $searchTerm . "%"; // Add wildcards for partial match
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['image'] = '../admin_side/uploads/' . $row['image']; // prepend upload path
        $products[] = $row;
    }
}

$stmt->close();
$conn->close();
echo json_encode($products);
?>
