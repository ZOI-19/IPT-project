<?php
$conn = new mysqli("localhost", "root", "", "iptdelezuskai");
$result = $conn->query("SELECT * FROM products");

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['price']}</td>
        <td>{$row['category']}</td><td>{$row['description']}</td>
        <td><img src='uploads/{$row['image']}' width='50'></td>
        <td>
            <a href='edit_product.php?id={$row['id']}'>Edit</a> | 
            <a href='delete_product.php?id={$row['id']}'>Delete</a>
        </td>
    </tr>";
}
?>
