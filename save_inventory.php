<?php
require_once 'connection.php';
session_start();

// Check if the user is logged in and is an admin
if ($_SESSION['user_name'] != 'alsafa') {
    // Redirect to the home page
    header("Location: homepage.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the "year" and "month" are set and not empty
    if (isset($_POST['year']) && isset($_POST['month'])) {
        $year = $_POST['year'];
        $month = $_POST['month'];

        // Check if the year and month combination already exists in the profits table
        $checkStmt = $conn->prepare("SELECT * FROM profits WHERE year = ? AND month = ?");
        $checkStmt->execute([$year, $month]);

        if ($checkStmt->rowCount() > 0) {
            // Year and month already exist in the table
            echo 'exists';
        } else {
           
            // Calculate net sales, net purchases, and net profit (you can use your calculation logic here)

            $netSales =$_POST['netSales']; 
            $netPurchases = $_POST['netPurchases']; 
            $netProfit = $netSales - $netPurchases;

            // Insert the data into the profits table
            $insertStmt = $conn->prepare("INSERT INTO profits (year, month, netsales, netpurchases, netProfit) VALUES (?, ?, ?, ?, ?)");
            $insertStmt->execute([$year, $month, $netSales, $netPurchases, $netProfit]);

            // Data saved successfully
            echo 'success';
        }
     } else {
        // Invalid or missing data
        echo 'error';
    }
}
?>
