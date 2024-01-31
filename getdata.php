<?php
include('connection.php'); 


    $selectedYear = $_GET['year'];
    $selectedMonth = $_GET['month'];
    // Initialize an array to store the data
    $data = [];

    try {
        $stmt = $conn->prepare("SELECT item_name, sale_price, number FROM sales WHERE year = ? AND month = ?");
        $stmt->execute([$selectedYear, $selectedMonth]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stmt1 = $conn->prepare("SELECT price FROM items WHERE item_name = ?");
            $stmt1->execute([$row['item_name']]);
            $res = $stmt1->fetch(PDO::FETCH_ASSOC);

            $itemData = [];
            $itemData['item_name'] = $row['item_name'];
            $itemData['sale_price'] = $row['sale_price'];
            $itemData['number'] = $row['number'];
            
            // Check if price exists before accessing it
            if ($res !== false) {
                $itemData['price'] = $res['price'];
            } else {
                $itemData['price'] = "Price not found"; // Or handle this case as per your requirements
            }

            $data[] = $itemData; // Append the item data to the $data array
        }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
