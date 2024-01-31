<?php

include "connection.php"; 

// Check if the clientName parameter is set
if (isset($_POST['clientName'])) {
    $clientName = $_POST['clientName'];
    // Your SQL query to fetch invoice summary data
    $query = "SELECT invoice_number, net_sales FROM invoices_summary WHERE client_name = :clientName";

    // Prepare and execute the SQL query
    // Replace 'your_connection_code' with your actual database connection code
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':clientName', $clientName);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the data as JSON
    echo json_encode($data);
} else {
    // Handle the case where clientName parameter is missing
    echo json_encode(array('error' => 'Missing clientName parameter'));
}
?>
