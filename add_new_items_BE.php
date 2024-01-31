<?php
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $item_count = $_POST["item_count"];
    $item_names = $_POST["item_name"];
    
    $existingItemNames = array(); // Create an array to store existing item names

    try {
        for ($i = 0; $i < $item_count; $i++) {
            $item_name = $item_names[$i];
            
            // Prepare a statement to check if the item_name already exists
            $checkItemStmt = $conn->prepare("SELECT item_name FROM items WHERE item_name = ?");
        
            // Execute the prepared statement to check if the item_name exists
            $checkItemStmt->execute([$item_name]);
            $itemCount = $checkItemStmt->fetchColumn();
        
            if ($itemCount == 0) {
                // The item_name doesn't exist, so insert it
                $insertItemStmt = $conn->prepare("INSERT INTO items (item_name, sale_price, price) VALUES (?, ?, ?)");
                $insertItemStmt->execute([$item_name, 0, 0]);
                
                $Stmt = $conn->prepare("INSERT INTO exist (item_name, number, sale_price) VALUES (?, ?, ?)");
                $Stmt->execute([$item_name, 0, 0]);
                
                $stmt1 = $conn->prepare("INSERT INTO client_sales (item_name, client_sale_price) VALUES (?, ?)");
                $stmt1->execute([$item_name, 0]);
                
                // Store the item name in the "client_sale_price" table 
            } else {
                // The item_name already exists, so add it to the existingItemNames array
                $existingItemNames[] = $item_name;
            }
        }

        // Display an alert for each existing item name
        foreach ($existingItemNames as $existingName) {
            echo "<script>alert('Item name $existingName already exists.');</script>";
        }

        // Redirect or perform other actions after data processing
        echo '<script>alert("تم إضافة المنتجات بنجاح "); window.location.href = "main_page.php";</script>'; 
   } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    // Add a JavaScript alert
    echo '<script>alert("An error occurred!");</script>';
}
}
?>
