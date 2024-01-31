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
            background-image: url('1.jpeg'); /* Replace 'background.jpg' with your image file */
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
        /* Style for the table and page centering */
        .page-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }



        label {
            display: block;
            margin-bottom: 10px;
            text-size-adjust: 100px;
        }

        select, input {
            width: 150px;
            padding: 10px;
            margin: 5px 0;

        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 150px;

        }       
    </style>
</head>
<body>
    <div class="top-nav">
        <a href="main_page.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>
    <h1> حذف البيانات </h1>
    <form method="POST" action="delete_sales_and_purchases_information_BE.php">
        <select name="year"id="year" required >
            <option value="" selected disabled>اختر السنة  </option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
        </select>
        <br>
        <select name="month" id="month" required>
            <option value="" selected disabled>اختر الشهر  </option>
            <option value="يناير">يناير </option>
            <option value="فبراير">فبراير</option>
            <option value="مارس">مارس</option>
            <option value="إبرايل">إبرايل</option>
            <option value="مايو">مايو</option>
            <option value="يونيه">يونيه</option>
            <option value="يوليو">يوليو</option>
            <option value="أغسطس">أغسطس</option>
            <option value="سبتمبر">سبتمبر</option>
            <option value="أكتوبر">أكتوبر</option>
            <option value="نوفمبر ">نوفمبر</option>
            <option value="ديسمبر">ديسمبر</option>
        </select>
        <br>        
        <select name="type" id="type"required>
                <option value="" selected disabled>اختر نوع البيانات    </option>
                <option value="sales">مبيعات </option>
                <option value="purchases">مشتريات</option>
        </select>
        <br>
        <button type="submit">حذف</button>
        </form>
    </body>
</html>
