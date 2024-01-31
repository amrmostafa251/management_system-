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
       body {
            background-image: url('1.jpeg'); 
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

        h1 {
            color: #333;
        }

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

        #clientNameDropdown {
            width: 250px;
            margin: 0 auto;
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        table th {
            background-color: #335;
            color: #fff;
        }

        #invoiceSummaryTable {
            margin-top: 50px;
        }

        #invoiceDetailsTable {
            margin-top: 50px;
        }
        

    </style>
    <script>
        // Function to fetch and display invoice summary for a selected client
        function getInvoiceSummary() {
            // Get the selected client name from the dropdown
            let clientName = document.getElementById('clientNameDropdown').value;

            // Make an AJAX request to fetch the invoice summary data
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_invoice_summary.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let data = JSON.parse(xhr.responseText);
                    // Update the invoice summary table
                    displayInvoiceSummary(data);
                }
            };
            xhr.send('clientName=' + clientName);
        }

        // Function to display invoice summary in a table
        function displayInvoiceSummary(data) {
            let summaryTable = document.getElementById('invoiceSummaryTable');
            summaryTable.innerHTML = ''; // Clear the table

            let table = document.createElement('table');
            let thead = table.createTHead();
            let row = thead.insertRow();

            // Create table headers
            for (let key in data[0]) {
                let th = document.createElement('th');
                th.innerHTML = key;
                row.appendChild(th);
            }

            // Create table rows
            data.forEach(function(item) {
                let row = table.insertRow();
                for (let key in item) {
                    let cell = row.insertCell();
                    cell.innerHTML = item[key];
                    // Add a click event to the invoice number cells
                    if (key === 'invoice_number') {
                        cell.addEventListener('click', function() {
                            getInvoiceDetails(item['invoice_number']);
                        });
                    }
                }
            });

            summaryTable.appendChild(table);
        }

        // Function to fetch and display invoice details based on invoice number
        function getInvoiceDetails(invoiceNumber) {
            let clientName = document.getElementById('clientNameDropdown').value;
            // Make an AJAX request to fetch the invoice details
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_invoice_details.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let data = JSON.parse(xhr.responseText);
                    // Update the invoice details table
                    displayInvoiceDetails(data);
                    
                }
            };
            xhr.send('invoiceNumber=' + invoiceNumber + '&clientName=' + clientName);
        }
        // Function to display invoice details in a table
        function displayInvoiceDetails(data) {
            let detailsTable = document.getElementById('invoiceDetailsTable');
            detailsTable.innerHTML = ''; // Clear the table

            let table = document.createElement('table');
            let thead = table.createTHead();
            let row = thead.insertRow();

            // Create table headers
            for (let key in data[0]) {
                let th = document.createElement('th');
                th.innerHTML = key;
                row.appendChild(th);
            }

            // Create table rows
            data.forEach(function(item) {
                let row = table.insertRow();
                for (let key in item) {
                    let cell = row.insertCell();
                    cell.innerHTML = item[key];
                }
            });

            detailsTable.appendChild(table);
        }
    </script>
    <title> clients invoices data </title>
</head>
<body>
    <div class="top-nav">
            <a href="main_page.php">Home</a>
            <a href="logout.php">Logout</a>
    </div>
    <br><br><br>
    <h1>فواتير العملاء </h1>

        <select id="clientNameDropdown" onchange=" getInvoiceSummary()">
        <option value="" selected disabled>أسم الصيدلية</option>
        <?php
                require_once 'connection.php';
                $stmt = $conn-> prepare("SELECT DISTINCT client_name from invoices_summary ");
                $stmt -> execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['client_name'] . '">' . $row['client_name'] . '</option>';
                }
            ?>
        </select>

        <div id="invoiceSummaryTable">
            <!-- Display the selected client's invoice summary here -->
        </div>

        <div id="invoiceDetailsTable">
            <!-- Display the invoice details here when clicked -->
        </div>

            
    </body>
</html>