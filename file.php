<form action="test.php" method ="POST">
<div id="dropdown-container" ></div>

</form>


<script>
var dropdownContainer = document.getElementById("dropdown-container");
            dropdownContainer.innerHTML = "";

            for (var i = 1; i <= 1; i++) {
                (function (index) {
                    var itemInput = document.createElement("input");
                    itemInput.type = "text";
                    itemInput.id = "item_name" + index;
                    itemInput.name = "item_name[]";
                    itemInput.required = true;

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
                    dropdownContainer.appendChild(itemInput);
                    dropdownContainer.appendChild(itemDatalist);
                        
                })(i);

            }
            var lineBreak = document.createElement("br");
            var buuton = document.createElement("input");
            buuton.type="submit";
            buuton.name="edit"
            buuton.value= "تعديل ";
            dropdownContainer.appendChild(lineBreak);
            dropdownContainer.appendChild(buuton);

</script>