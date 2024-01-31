<?php
// Include  connection file
include 'connection.php';

// Replace 'your_item_name' with the actual item_name you want to delete
$item_name = 'فسطين أرض الأبطال ';

try {
    //  SQL query to delete one occurrence of the item_name
    $sql = "DELETE FROM items WHERE item_name = :item_name LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);
    $stmt->execute();

    echo "Record deleted successfully";
} catch (PDOException $e) {
    echo "Error deleting record: " . $e->getMessage();
}
?>
