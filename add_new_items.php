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
            width: 200px ;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 25px;
        }

        form input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
    <title>Item Selection</title>
</head>
<body>
    <div class="top-nav">
        <a href="main_page.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>
    <h1>إضافة منتجات غير موجودة </h1>
    
    <form method="POST" action="add_new_items_BE.php">
        <!-- Dropdown for selecting the number of items -->
        <label for="item_count"></label>
        <select id="item_count" name="item_count" onchange="generateItemFields()">
            <option value="" selected disabled>اختر عدد المنتجات المراد إضافتها  </option>
                <?php
                    for ($i = 1; $i <= 100; $i++) {
                        echo "<option value=\"$i\">$i</option>";
                    }
                ?>
        </select>

        <div id="item_details"></div>

        <input type="submit" name="add" value="إضافة ">
    </form>

    <script>
        // Function to generate item fields based on the selected number
        function generateItemFields() {
            var item_count = document.getElementById("item_count").value;
            var item_details = document.getElementById("item_details");
            item_details.innerHTML = "";

            for (var i = 1; i <= item_count; i++) {
                item_details.innerHTML += `
                    <label for="item_name${i}">اسم المنتج:</label>
                    <input type="text" name="item_name[]" id="item_name${i}" required>



                    <br><br>
                `;
            }
        }
    </script>
</body>
</html>
