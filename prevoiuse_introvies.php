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

        table {
            border-collapse: collapse;
            width: 80%; /* Adjust the width as needed */
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }
        /* Style for the form section */
        form {
            text-align: center;
            margin: 20px auto;
            max-width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        select, input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        
    </style>
    <title>Sales Data</title>
</head>
<body>
    <div class="top-nav">
            <a href="main_page.php">Home</a>
            <a href="logout.php">Logout</a>
    </div>
    <h1>بيانات الجرد السابقة </h1>
    
    <table border="1">
        <tbody>
            <?php
            // Include the connection file
            require_once 'connection.php';

            // SQL query to retrieve data from the "sales" table
            $query = "SELECT *  FROM profits";
            $result = $conn->query($query);

            // Initialize the table header
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>الشنة   </th>";
            echo "<th>الشهر</th>";
            echo "<th> مجموع سعر البيع </th>";
            echo "<th>مجموع سعر الشراء   </th>";
            echo "<th> صافي الربح </th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Loop through the results and display them in the table
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['year'] . "</td>";
                echo "<td>" . $row['month'] . "</td>";
                echo "<td>" . $row['netsales'] . "</td>";
                echo "<td>" . $row['netpurchases'] . "</td>";
                echo "<td>" . $row['netProfit'] . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
            ?>
        </tbody>
    </table>
</body>
</html>
