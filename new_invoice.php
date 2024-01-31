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
    <title>purchases Data</title>
    <script>
        function generateClientList(){
            var selectedType = document.getElementById("type").value; // get the selected type 
            var Container = document.getElementById("container"); // get the container with its ID 
            Container.innerHTML = "";
            if (selectedType ==="sales"){
                //set the data list 
                const clientSelect = document.createElement("select");
                clientSelect.name = "clientSelect[]";
                clientSelect.id = "clientSelect" ;
                var clientSelectDefaultOption = document.createElement("option");
                clientSelectDefaultOption.value = "";
                clientSelectDefaultOption.disabled = true;
                clientSelectDefaultOption.selected = true;
                clientSelectDefaultOption.textContent = "الزبون  ";
                clientSelect.appendChild(clientSelectDefaultOption);
                clientSelect.required = true;
                
                // set the first option 
                var option1 = document.createElement("option");
                option1.id = "client";
                option1.value = "client";
                option1.textContent = "صيدلية";
                clientSelect.appendChild(option1);
                
                // set the second option 
                var option2 = document.createElement("option");
                option2.value ="personal";
                option2.textContent = "شخص";
                clientSelect.appendChild(option2);
                Container.appendChild(clientSelect);

            }
        }
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


    



                    var numberSelect = document.createElement("select");
                    numberSelect.name = "number[]";
                    numberSelect.id = "number" + index;
                    var numberDefaultOption = document.createElement("option");
                    numberDefaultOption.value = "";
                    numberDefaultOption.disabled = true;
                    numberDefaultOption.selected = true;
                    numberDefaultOption.textContent = "العدد ";
                    numberSelect.appendChild(numberDefaultOption);

                    for (var j = 1; j <= 100; j++) {
                        var option = document.createElement("option");
                        option.value = j;
                        option.textContent = j;
                        numberSelect.appendChild(option);
                    }

                    // Check the type value
                    var type = document.getElementById("type").value;
                    var selectedClient = document.getElementById("clientSelect");
                    if (type === "purchases") {
                        var salePriceInput = document.createElement("input");
                        salePriceInput.type = "text";
                        salePriceInput.name = "sale_price[]";
                        salePriceInput.id = "sale_price" + index;
                        salePriceInput.placeholder = "سعر البيع القطاعي ";
                        
                        var salePriceInputClient = document.createElement("input");
                        salePriceInputClient.type = "text";
                        salePriceInputClient.name = "sale_price_client[]";
                        salePriceInputClient.id = "sale_price_client" + index;
                        salePriceInputClient.placeholder = "  سعر البيع الجملة ";

                        var purchasePriceInput = document.createElement("input");
                        purchasePriceInput.type = "text";
                        purchasePriceInput.name = "purchase_price[]";
                        purchasePriceInput.id = "purchase_price" + index;
                        purchasePriceInput.placeholder = "سعر الشراء";
                        dropdownContainer.appendChild(itemInput);
                        dropdownContainer.appendChild(itemDatalist);
                        dropdownContainer.appendChild(numberSelect);
                        dropdownContainer.appendChild(salePriceInput);
                        dropdownContainer.appendChild(salePriceInputClient);
                        dropdownContainer.appendChild(purchasePriceInput);
                        

                    } else if (type === "sales" && selectedClient.value === "personal") {
                        // If the type is sales, add fields for sale price and total price
                        var salePriceInput = document.createElement("input");
                        salePriceInput.type = "text";
                        salePriceInput.name = "sale_price[]";
                        salePriceInput.id = "sale_price" + index;
                        salePriceInput.placeholder = "سعر البيع";

                        var totalPriceInput = document.createElement("input");
                        totalPriceInput.type = "text";
                        totalPriceInput.name = "total_price[]";
                        totalPriceInput.id = "total_price" + index;
                        totalPriceInput.placeholder = "السعر الإجمالي";

                        itemInput.addEventListener("change", function () {
                            var selectedItemName = itemInput.value;
                            var selecteditemnumber = numberSelect.value;
                            if (selectedItemName &&selecteditemnumber) {
                                var xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function () {
                                    if (xhr.readyState === 4 && xhr.status === 200) {
                                        var response = JSON.parse(xhr.responseText);
                                        if (response.sale_price) {
                                            var selectedSalePrice = response.sale_price;
                                            var selectedNumber = parseInt(numberSelect.value, 10);
                                            var total = selectedSalePrice * selectedNumber;
                                            document.getElementById("sale_price" + index).value = selectedSalePrice;
                                            document.getElementById("total_price" + index).value = total;
                                            
                                        } else {
                                            alert("   المنتج غير موجود او  لا يوحد سعر بيع مسجل  ");
                                        }
                                    }
                                };
                                xhr.open("GET", "get_sale_price.php?item_name=" + selectedItemName, true);
                                xhr.send();
                            }
                        });
                        var lineBreak = document.createElement("br");

                        dropdownContainer.appendChild(lineBreak);
                        dropdownContainer.appendChild(itemInput);
                        dropdownContainer.appendChild(itemDatalist);
                        dropdownContainer.appendChild(numberSelect);
                        dropdownContainer.appendChild(salePriceInput);
                        dropdownContainer.appendChild(totalPriceInput);
               
                    }
                    else if (type === "sales" && selectedClient.value === "client") {
                        // If the type is sales, add fields for sale price and total price
                        var salePriceInput = document.createElement("input");
                        salePriceInput.type = "text";
                        salePriceInput.name = "sale_price[]";
                        salePriceInput.id = "sale_price" + index;
                        salePriceInput.placeholder = "سعر البيع";

                        var totalPriceInput = document.createElement("input");
                        totalPriceInput.type = "text";
                        totalPriceInput.name = "total_price[]";
                        totalPriceInput.id = "total_price" + index;
                        totalPriceInput.placeholder = "السعر الإجمالي";

                        itemInput.addEventListener("change", function () {
                            var selectedItemName = itemInput.value;
                            var selecteditemnumber = numberSelect.value;
                            if (selectedItemName &&selecteditemnumber) {
                                var xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function () {
                                    if (xhr.readyState === 4 && xhr.status === 200) {
                                        var response = JSON.parse(xhr.responseText);
                                        if (response.sale_price) {
                                            var selectedSalePrice = response.sale_price;
                                            var selectedNumber = parseInt(numberSelect.value, 10);
                                            var total = selectedSalePrice * selectedNumber;
                                            document.getElementById("sale_price" + index).value = selectedSalePrice;
                                            document.getElementById("total_price" + index).value = total;
                                            
                                        } else {
                                            alert("   المنتج غير موجود او  لا يوحد سعر بيع مسجل  ");
                                        }
                                    }
                                };
                                xhr.open("GET", "get_sale_price_tot.php?item_name=" + selectedItemName, true);
                                xhr.send();
                            }
                        });
                        var lineBreak = document.createElement("br");

                        dropdownContainer.appendChild(lineBreak);
                        dropdownContainer.appendChild(itemInput);
                        dropdownContainer.appendChild(itemDatalist);
                        dropdownContainer.appendChild(numberSelect);
                        dropdownContainer.appendChild(salePriceInput);
                        dropdownContainer.appendChild(totalPriceInput);
                    }
                })(i);
            }
            
            var selectedClient = document.getElementById("clientSelect");
            var Container2 = document.getElementById("container2");
            Container2.innerHTML = "";

            if (selectedClient.value === "client") {
                var clientName = document.createElement("input");
                clientName.type = "text";
                clientName.id = "client_name";
                clientName.name = "client_name[]";
                clientName.placeholder = "أختر أسم الصيدلية ";

                clientName.required = true;

                var clientDatalist = document.createElement("datalist");
                clientDatalist.id = "client_list";

                clientName.setAttribute("list", clientDatalist.id);

                // Make an AJAX request to get client names from the PHP script
                var xhr1 = new XMLHttpRequest();
                xhr1.onreadystatechange = function () {
                    if (xhr1.readyState === 4 && xhr1.status === 200) {
                        var clientsNames = JSON.parse(xhr1.responseText);
                        var dataList = clientDatalist;
                        dataList.innerHTML = ""; // Clear any existing options
                        clientsNames.forEach(function (client) {
                            var option = document.createElement("option");
                            option.value = client; // Assuming the client names are retrieved from the database
                            dataList.appendChild(option);
                        });
                    }
                };
                xhr1.open("GET", "get_client_names.php", true);
                xhr1.send();
                // displaying the net price of the invoice and number of the invoice 
                var invoiceNumberInput = document.createElement("input");
                invoiceNumberInput.type = "number";
                invoiceNumberInput.name = "invoiceNumber[]";
                invoiceNumberInput.id = "invoiceNumber" ;
                invoiceNumberInput.placeholder = "رقم الفاتورة ";

                
                
                clientName.addEventListener("change", function () {
                    var selectedClientName = clientName.value;
                    if (selectedClientName) {
                        var xhr3 = new XMLHttpRequest();
                        xhr3.onreadystatechange = function () {
                            if (xhr3.readyState === 4 && xhr3.status === 200) {
                                var response = JSON.parse(xhr3.responseText); // Fixed the property name
                                if (response.next_invoice_number) {
                                    var selectedInvoiceNumber = response.next_invoice_number;
                                    // The next line should set the invoice number to the selectedInvoiceNumber
                                    document.getElementById("invoiceNumber").value = selectedInvoiceNumber; // Fixed the element ID
                                } else {
                                    alert("No invoice number found for this client.");
                                }
                            }
                        };
                        // The URL should pass 'client_name' as the parameter
                        xhr3.open("GET", "get_invoice_number.php?client_name=" + selectedClientName, true);
                        xhr3.send();
                    }
                });
                
                Container2.appendChild(clientName);
                Container2.appendChild(clientDatalist);
                Container2.appendChild(invoiceNumberInput);

            }

        }
    </script>


</head>
    <body>
        <div class="top-nav">
            <a href="main_page.php">Home</a>
            <a href="logout.php">Logout</a>
        </div>
        <h1>فاتورة  جديدة </h1>
        <form method="POST" action="newinvoice - Copy.php">

            <!-- Year dropdown list -->
            <label for="year">السنة :</label>
            <select name="year" id="year" required>
                <option value="" selected disabled>اختر السنة  </option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
            </select>

            <!-- Month dropdown list -->
            <label for="month">الشهر :</label>
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
                <option value="نوفمبر">نوفمبر</option>
                <option value="ديسمبر">ديسمبر</option>
            </select>

            <!-- Day dropdown list -->
            <label for="day">اليوم :</label>
            <select name="day" id="day"required>
                <option value="" selected disabled>اختر اليوم  </option>

                <?php
                    for ($day = 1; $day <= 31; $day++) {
                        echo "<option value=\"$day\">$day</option>";
                    }
                ?>
            </select>
            <!-- type dropdown list -->
            <select name="type" id="type" onchange="generateClientList()"required>
                <option value="" selected disabled>اختر نوع الفاتوة   </option>
                <option value="sales">مبيعات </option>
                <option value="purchases">مشتريات</option>
            </select>
            <br>
            <div id= "container"></div>
            <!-- Number of items dropdown list -->
            <label for="countnumber">اختر عدد المنتجات في الفاتورة :</label>
            <select name="countnumber" id="countnumber" onchange="generateDropdowns()"required>
                <option value="" selected disabled>اختر عدد المنتجات في الفاتورة </option>
                <?php
                    for ($i = 1; $i <= 100; $i++) {
                        echo "<option value=\"$i\">$i</option>";
                    }
                ?>
            </select>
            
            <!-- Container for dynamically generated dropdowns -->
            <div id="dropdown-container"></div>
            <br>
            <div id= "container2"></div>
            <!-- add button within the form -->
            <input type="submit" name="add" value="إضافة ">
        </form>
    </body>
</html>