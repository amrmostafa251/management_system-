<?php
// Include the connection file
require_once 'connection.php';

// SQL query to retrieve item names from the "items" table
$query = "SELECT DISTINCT client_name FROM clients";
$result = $conn->query($query);

$clientsNames = array();

if ($result) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $clientsNames[] = $row['client_name'];
    }

    // Close the database connection
    $conn = null;
    function customArabicSort($a, $b) {
        setlocale(LC_COLLATE, 'ar_AE.utf8'); // Set Arabic locale
        return strcoll($a, $b); // Compare Arabic strings
    }
    
    // Sort the Arabic array using the custom sorting function
    usort($clientsNames, 'customArabicSort');
    echo json_encode($clientsNames);
} else {
    // Handle database query error
    echo json_encode(array('error' => 'Database query error'));
}
?>
