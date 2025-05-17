   <?php
   // Fetch order details based on order ID
   $order_id = $_GET['id'];
   $query = "SELECT * FROM orders WHERE id = ?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param("i", $order_id);
   $stmt->execute();
   $order = $stmt->get_result()->fetch_assoc();

   // Decode products
   $products = json_decode($order['products'], true);
   ?>

   <h1>Order Details</h1>
   <p>Order ID: <?php echo $order['id']; ?></p>
   <p>Address: <?php echo $order['address']; ?></p>
   <p>Total Price: <?php echo $order['total_price']; ?></p>
   <p>Status: <?php echo $order['status']; ?></p>

   <h2>Products</h2>
   <ul>
       <?php foreach ($products) as

    ?>