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
        <a href="add_new_items.php" class="square-option">إضافة عنصر غير موجود</a>
        <a href="inventory.php" class="square-option">جرد  </a>
        <a href="storehouse.php" class="square-option"> عرض المنتجات المتواجدة  </a>
        <a href="prevoiuse_introvies.php" class="square-option"> عرض نتائج الجرد السابقة   </a>
        <a href="edit_delete_items.php" class="square-option">تعديل وحذف المنتجات </a>
        <a href="edit_prices.php" class="square-option">تعديل  الأسعار </a>

    </div>
</body>
</html>
