<?php
// Check if the user is logged in and is an admin
session_start();
if (($_SESSION['user_name'] != 'alsafa') ) {
    // Redirect to the home page
    header("Location: homepage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Options Page</title>
    <style>
        /* Your existing CSS styles here */

        /* Style for the top navigation */
        .top-nav {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-nav a {
            color: #fff;
            text-decoration: none;
            margin: 10px;
        }

        .top-nav a:hover {
            text-decoration: underline;
        }

        body {
            background-image: url('2.jpg'); /* Replace 'background.jpg' with your image file */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .options {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .square-option {
            display: block;
            width: 150px;
            height: 150px;
            background-color: #3498db;
            color: #fff;
            text-align: center;
            line-height: 150px;
            text-decoration: none;
            font-weight: bold;
            margin: 10px;
            border-radius: 10px;
            transition: background-color 0.3s;
        }

        .square-option:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="top-nav">
        <a href="main_page.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="options">
        <a href="sales.php" class="square-option">مبيعات </a>
        <a href="purchases.php" class="square-option">مشتريات </a>
        <a href="new_invoice.php" class="square-option">فاتورة جديدة </a>

        <a href="delete_sales_and_purchases_information.php" class="square-option">حذف بياتات </a>
        <a href = "clients_invoices_information.php " class ="square-option">عرض الفواتير </a>
        <a href = "add_new_clients.php " class ="square-option">إضافة صيدليات </a>
        <a href="details.php" class="square-option">أخري</a>
    </div>
</body>
</html>