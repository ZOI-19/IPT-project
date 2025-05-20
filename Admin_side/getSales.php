<?php
include("IPTconnect.php");

$timeFrame = $_GET['timeFrame'] ?? 'weekly';
$totalSales = 0;
$percentage = 0;

// Determine the date range based on the time frame
switch ($timeFrame) {
    case 'monthly':
        $startDate = date('Y-m-01'); // First day of the current month
        break;
    case 'yearly':
        $startDate = date('Y-01-01'); // First day of the current year
        break;
    case 'weekly':
    default:
        $startDate = date('Y-m-d', strtotime('last monday')); // Start of the current week
        break;
}

// Query to get total sales for completed orders only
$query = "SELECT SUM(total_price) AS total_sales FROM orders WHERE timestamp >= ? AND status = 'complete'";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $startDate);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $totalSales = $row['total_sales'] ?? 0;
}

// Calculate percentage (for demonstration, you can adjust this logic)
$percentage = ($totalSales > 0) ? 100 : 0; // Example logic

echo json_encode([
    'success' => true,
    'totalSales' => number_format($totalSales, 2),
    'percentage' => $percentage
]);
?>
