<?php
// Include the connection file
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_name'])) {
    // Retrieve the selected item_name from the POST data
    $selectedItem = $_POST['item_name'];

    // Prepare and execute a query to get the price and sale_price for the selected item
    $query = "SELECT price, sale_price FROM purchases WHERE item_name = :item_name";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':item_name', $selectedItem, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Send the result as JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    // Handle invalid or missing input
    header("HTTP/1.1 400 Bad Request");
    echo "Invalid or missing input data.";
}
?>
