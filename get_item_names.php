<?php
// Include the connection file
require_once 'connection.php';

// SQL query to retrieve item names from the "items" table
$query = "SELECT DISTINCT item_name FROM items";
$result = $conn->query($query);

$itemNames = array();

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $itemNames[] = $row['item_name'];
}
// Define a custom sorting function for Arabic text
function customArabicSort($a, $b) {
    setlocale(LC_COLLATE, 'ar_AE.utf8'); // Set Arabic locale
    return strcoll($a, $b); // Compare Arabic strings
}

// Sort the Arabic array using the custom sorting function
usort($itemNames, 'customArabicSort');
echo json_encode($itemNames);
?>
