<?php
// Include your database connection
include "connection.php"; 

if (isset($_GET['item_name'])) {
   $item_name = $_GET['item_name'];
    // Prepare a SQL query to get the sale price based on the item name
    $stmt = $conn->prepare("SELECT sale_price FROM items WHERE item_name = ?");
    $stmt->execute([$item_name]);

    // Fetch the result as an associative array
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $sale_price = $row['sale_price'];
    
        echo json_encode(['sale_price' => $sale_price]);
    } else {
        echo json_encode(['error' => 'Item not found']);
    }
} else {
    echo json_encode(['error' => 'Item name not provided']);
}
?>
