<?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the user is logged in and is an admin
        session_start();
        if ($_SESSION['user_name'] != 'alsafa') {
            // Redirect to the home page
            header("Location: homepage.php");
            exit();
        }
        require_once 'connection.php';

        try{   
            $countnumber = $_POST['countnumber'];
            for ($i = 1; $i <= $countnumber; $i++) {
                if (isset($_POST['item_name'][$i - 1])) {
                    $item_name = $_POST['item_name'][$i - 1];
                    $purchasePrice = $_POST['purchasePrice'][$i - 1];
                    $editedsalePrice = $_POST['editedsalePrice'][$i - 1];
                    $editedClientsalePrice = $_POST['editedClientsalePrice'][$i - 1];
                    if ($_POST['editedClientsalePrice'][$i - 1]!= null){
                        // Update the 'client_sales ' table
                        $sql = "UPDATE client_sales SET client_sale_price = :editedClientsalePrice WHERE item_name = :item_name";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(['editedClientsalePrice' => $editedClientsalePrice, 'item_name' => $item_name]);
                        // Update the 'exist' table
                        $sql = "UPDATE exist SET client_sale_price  = :editedClientsalePrice  WHERE item_name = :item_name";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(['editedClientsalePrice' => $editedClientsalePrice, 'item_name' => $item_name]);
                    }    
                    // Update the 'exist' table
                    if ($_POST['editedsalePrice'][$i - 1]!=null){
                        $sql = "UPDATE exist SET sale_price  = :editedsalePrice  WHERE item_name = :item_name";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(['editedsalePrice' => $editedsalePrice, 'item_name' => $item_name]);
                         // Update the 'items' table
                        $sql = "UPDATE items SET sale_price = :editedsalePrice WHERE item_name = :item_name";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(['editedsalePrice' => $editedsalePrice, 'item_name' => $item_name]);
                    }

                    if ($_POST['purchasePrice'][$i - 1]!=null){
                        // Update the 'items' table
                        $sql = "UPDATE items SET price = :purchasePrice WHERE item_name = :item_name";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(['purchasePrice' => $purchasePrice, 'item_name' => $item_name]);
                    }
                }
                    
            }
            // Display an alert and redirect to homepage.php using JavaScript
            echo '<script>alert("تم تعديل أسعار  المنتجات بنجاح "); window.location.href = "details.php";</script>';

        } catch (PDOException $e) {
            echo "Error: " ;
        }
    } else {
        echo "Invalid operation type.";
    }
?>
