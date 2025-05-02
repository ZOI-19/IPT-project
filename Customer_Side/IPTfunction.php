<?php
function check_login($conn) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1";
        $result = mysqli_query($conn, $query);
        $user_data = mysqli_fetch_assoc($result);
        return $user_data;
    }
    // If no session, redirect to login
    header("Location: loginform.php");
    exit;
}

function update_product_status_to_pending($conn, $product_id) {
    // Update the product status to "Pending"
    $sql = "UPDATE products SET status = 'Pending' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
}

?>
