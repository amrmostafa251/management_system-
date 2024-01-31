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
    <h1>بيانات البيع </h1>
    
    <table border="1">
        <tbody>
            <?php
            // Include the connection file
            require_once 'connection.php';

            // SQL  to retrieve data from the "sales" table
            $query = "SELECT item_name, number, sale_price FROM sales";
            $result = $conn->query($query);

            // Initialize the table header
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>اسم المنتج </th>";
            echo "<th>العدد</th>";
            echo "<th>سعر البيع للقطعة الواحدة </th>";
            echo "<th>إجمالي السعر </th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Loop through the results and display them in the table
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['item_name'] . "</td>";
                echo "<td>" . $row['number'] . "</td>";
                echo "<td>" . $row['sale_price'] . "</td>";
    
                // Calculate the total price and display it
                $totalPrice = $row['number'] * $row['sale_price'];
                echo "<td>" . $totalPrice . "</td>";
    
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
            ?>
        </tbody>
    </table>
    <!-- Search form with POST method -->
    <form method="POST" action="sale_search_results.php">
        <!-- Year dropdown list -->
        <label for="year">السنة:</label>
        <select name="year" id="year" required>
        <option value="" selected disabled>اختر السنة  </option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
        </select>

        <!-- Month dropdown list -->
        <label for="month">الشهر:</label>
        <select name="month" id="month">
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

        <!-- Day dropdown list -->
        <label for="day">اليوم:</label>
        <select name="day" id="day">
        <option value="" selected disabled>اختر اليوم   </option>
            <?php
            for ($day = 1; $day <= 31; $day++) {
                echo "<option value=\"$day\">$day</option>";
            }
            ?>
        </select>

        <!-- Search button within the form -->
        <input type="submit" name="search" value="Search">
    </form>

</body>
</html>
