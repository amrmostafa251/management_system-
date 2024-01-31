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

        .page-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
            direction: rtl; /* Right-to-left direction */
        }

        form label,
        form select {
            margin: 10px;
        }

        form label[for="number"] {
            display: block;
            font-size: 16px; /* Increase font size */
        }

        form #number {
            margin: 10px 0; /* Reduce margin for the number dropdown */
        }

        form #dropdown-container {
            text-align: center;
        }

        form input[type="submit"] {
            margin: 20px 0;
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
    <script>
        function generateDropdowns() {
            var selectedNumber = document.getElementById("countnumber").value;
            var dropdownContainer = document.getElementById("dropdown-container");
            dropdownContainer.innerHTML = "";

            for (var i = 1; i <= selectedNumber; i++) {
                (function (index) {
                    var itemInput = document.createElement("input");
                    itemInput.type = "text";
                    itemInput.id = "item_name" + index;
                    itemInput.name = "item_name[]";
                    itemInput.required = true;
                    itemInput.placeholder = "أسم المنتج ";

                    var itemDatalist = document.createElement("datalist");
                    itemDatalist.id = "item_list" + index;

                    itemInput.setAttribute("list", itemDatalist.id);

                    // Make an AJAX request to get item names from the PHP script
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var itemNames = JSON.parse(xhr.responseText);
                            var dataList = itemDatalist;
                            dataList.innerHTML = ""; // Clear any existing options

                            itemNames.forEach(function (item) {
                                var option = document.createElement("option");
                                option.value = item; // Assuming the item names are retrieved from the database
                                dataList.appendChild(option);
                            });
                        }   
                    };
                    xhr.open("GET", "get_item_names.php", true);
                    xhr.send();
    
                    // Check the type value
                        var purchasePrice = document.createElement("input");
                        purchasePrice.type = "number";
                        purchasePrice.name = "purchasePrice[]";
                        purchasePrice.id = "purchasePrice" + index;
                        purchasePrice.placeholder = "سعر الشراء الجديد   ";
                        
                        var editedsalePrice = document.createElement("input");
                        editedsalePrice.type = "number";
                        editedsalePrice.name = "editedsalePrice[]";
                        editedsalePrice.id = "editedsalePrice" + index;
                        editedsalePrice.placeholder = "سعر البيع القطاعي الجديد ";

                        var editedClientsalePrice = document.createElement("input");
                        editedClientsalePrice.type = "number";
                        editedClientsalePrice.name = "editedClientsalePrice[]";
                        editedClientsalePrice.id = "editedClientsalePrice" + index;
                        editedClientsalePrice.placeholder = "سعر البيع الجملة  الجديد ";

                        dropdownContainer.appendChild(itemInput);
                        dropdownContainer.appendChild(itemDatalist);
                        dropdownContainer.appendChild(purchasePrice);
                        dropdownContainer.appendChild(editedClientsalePrice);
                        dropdownContainer.appendChild(editedsalePrice);
                })(i);
            }
            var lineBreak = document.createElement("br");
            var buuton = document.createElement("input");
            buuton.type="submit";
            buuton.name="edit"
            buuton.value= "تعديل ";
            dropdownContainer.appendChild(lineBreak);
            dropdownContainer.appendChild(buuton);


        }
    </script>


</head>
    <body>
        <div class="top-nav">
            <a href="main_page.php">Home</a>
            <a href="logout.php">Logout</a>
        </div>
        <h1>تعديل اسعار المنتجات </h1>
        <form method="POST" action="edit_prices_BE.php">

            <br>
            <!-- Number of items dropdown list -->
            <label for="countnumber"></label>
            <select name="countnumber" id="countnumber" onchange="generateDropdowns()"required>
                <option value="" selected disabled>اختر عدد المنتجات   </option>
                <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo "<option value=\"$i\">$i</option>";
                    }
                ?>
            </select>
        
            <!-- Container for dynamically generated dropdowns -->
            <div id="dropdown-container"></div>
        </form>
    </body>
</html>