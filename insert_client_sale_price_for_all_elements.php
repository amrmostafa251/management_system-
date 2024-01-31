<form method="POST" action="edit_prices_BE.php">
    <!-- Container for dynamically generated input fields -->
    <div id="input-fields-container"></div>
    <input type="hidden" name="countnumber" id="countnumber" value="">
    <input type="submit" name="edit" value="تعديل">
</form>

<script>
    window.addEventListener("load", function () {
        var inputFieldsContainer = document.getElementById("input-fields-container");

        // Make an AJAX request to get all item names from the PHP script
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var itemNames = JSON.parse(xhr.responseText);

                itemNames.forEach(function (item) {
                    var itemDiv = document.createElement("div");
                    itemDiv.classList.add("item-div");

                    var itemNameInput = document.createElement("input");
                    itemNameInput.type = "text";
                    itemNameInput.name = "item_name[]";
                    itemNameInput.value = item;
                    itemNameInput.readOnly = true;

                    var purchasePriceInput = document.createElement("input");
                    purchasePriceInput.type = "number";
                    purchasePriceInput.name = "purchasePrice[]";
                    purchasePriceInput.placeholder = "سعر الشراء الجديد";

                    var editedClientSalePriceInput = document.createElement("input");
                    editedClientSalePriceInput.type = "number";
                    editedClientSalePriceInput.name = "editedClientsalePrice[]";
                    editedClientSalePriceInput.placeholder = "سعر البيع الجملة الجديد";

                    var editedSalePriceInput = document.createElement("input");
                    editedSalePriceInput.type = "number";
                    editedSalePriceInput.name = "editedsalePrice[]";
                    editedSalePriceInput.placeholder = "سعر البيع القطاعي الجديد";

                    itemDiv.appendChild(itemNameInput);
                    itemDiv.appendChild(purchasePriceInput);
                    itemDiv.appendChild(editedClientSalePriceInput);
                    itemDiv.appendChild(editedSalePriceInput);

                    inputFieldsContainer.appendChild(itemDiv);
                });

                // Set the countnumber input value to the number of items
                document.getElementById("countnumber").value = itemNames.length;
            }
        };
        xhr.open("GET", "get_item_names.php", true);
        xhr.send();
    });
</script>
