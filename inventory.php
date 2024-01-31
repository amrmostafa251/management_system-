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
    <title>Net Sales and Purchases</title>
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
        .netSalesAndPurchases {
            font-size: 18px;
            color: green;
            color: blue;


        }

        .netSalesAndPurchases {
            color: green;
        }

        .net-purchases {
            color: red;
        }

        .net-profit {
            color: blue;
        }     
    </style>
</head>
<body>
<div class="top-nav">
            <a href="main_page.php">Home</a>
            <a href="logout.php">Logout</a>
    </div>    
    <h1>الجرد الشهري </h1>
    <form id="searchForm">
        <!-- Year dropdown list -->
        <label for="year">السنة:</label>
        <select name="year" id="yearSelect" required>
        <option value="" selected disabled>اختر السنة  </option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
        </select>
        
        <select id="monthSelect" required>
            <option value="" selected disabled>اختر الشهر  </option>
            <option value="يناير">يناير </option>
            <option value="فبراير">فبراير</option>
            <option value="مارس">مارس</option>
            <option value="إبرايل">إبريل</option>
            <option value="مايو">مايو</option>
            <option value="يونيه">يونيه</option>
            <option value="يوليو">يوليو</option>
            <option value="أغسطس">أغسطس</option>
            <option value="سبتمبر">سبتمبر</option>
            <option value="أكتوبر">أكتوبر</option>
            <option value="نوفمبر ">نوفمبر</option>
            <option value="ديسمبر">ديسمبر</option>
        </select>
        <button type="button" onclick = "searchData()">جرد</button>
        <button type="button" onclick="saveInventory()">حفظ الجرد لهذا الشهر</button>

    </form>
    <table id="resultsTable">
        <!-- Table headers will be generated dynamically -->
    </table>
    <div id="netSalesAndPurchases">
        <!-- Net Sales and Purchases will be displayed here -->
    </div>
    <script>
        // Declare variables to store netSales and netPurchases
        let netSales = 0;
        let netPurchases = 0;

        function searchData() {
            const selectedYear = document.getElementById("yearSelect").value;
            const selectedMonth = document.getElementById("monthSelect").value;
            // Check if selectedYear has a value and it's an integer
            if (!isNaN(selectedYear) && Number.isInteger(Number(selectedYear))) {
            // Value is a valid integer
            } else {
            alert("من فضلك اختر سنة");
            return; // Exit the function if the year is invalid
            }

            // Check if selectedMonth has a value and it's a string
            if (typeof selectedMonth === "string" && selectedMonth.length > 0) {
                // Value is a valid non-empty string
            } else {
                alert("من فضلك اختر شهر");
                return; // Exit the function if the month is invalid
            }    
            // Send an AJAX request to a PHP script
                const xhr = new XMLHttpRequest();
                xhr.open("GET", `getdata.php?year=${selectedYear}&month=${selectedMonth}`, true);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const data = JSON.parse(xhr.responseText);

                        // Initialize variables for netSales and netPurchases
                        netSales = 0;
                        netPurchases = 0;

                        // Create a table and table headers
                        let tableHtml = "<table>";
                        tableHtml += "<th>اسم المنتج </th><th>سعر البيع </th><th>عدد القطع </th><th>سعر الشراء </th></tr>";

                        data.forEach(item => {
                            // Add a row to the table
                            tableHtml += `<tr><td>${item.item_name}</td><td>${item.sale_price}</td><td>${item.number}</td><td>${item.price}</td></tr>`;

                            // Calculate net sales and net purchases
                            netSales += item.sale_price * item.number;
                            netPurchases += item.price * item.number;
                        });

                        tableHtml += "</table>";

                        // Update the table and result div
                        document.getElementById("resultsTable").innerHTML = tableHtml;

                        // Display net sales and net purchases
                        const netSalesAndPurchasesHtml = `<p> ${netSales} =مجموع المبيعات  </p><p> ${netPurchases} =مجموع المشتريات </p><p> ${netSales - netPurchases} =صافي الأرباح</p>`;
                        document.getElementById("netSalesAndPurchases").innerHTML = netSalesAndPurchasesHtml;
                    }
                };

                xhr.send();
        }


        function saveInventory() {
            // Now you can access netSales and netPurchases here
            const selectedYear = document.getElementById("yearSelect").value;
            const selectedMonth = document.getElementById("monthSelect").value;

            // Send an AJAX request to a PHP script to save the inventory data
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "save_inventory.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // Handle the response from the server, display alerts, and redirect
                        const response = xhr.responseText;
                        if (response === "success") {
                            alert("تم التخزين بنجاح");
                        } else if (response === "exists") {
                            alert("لقد قمت بتخزين جرد هذا الشهر مسبقاً");
                        } else {
                            alert("حدث خطأ أثناء التخزين");
                        }
                        window.location.href = "inventory.php";
                    } else {
                        alert("حدث خطأ أثناء الطلب");
                    }
                }
            };

            // Send the POST data with year, month, netSales, and netPurchases
            const data = `year=${selectedYear}&month=${selectedMonth}&netSales=${netSales}&netPurchases=${netPurchases}`;
            xhr.send(data);
        }
    </script>
</body>
</html>
