<?php
    include "connection.php"; 
    // Check if the invoiceNumber parameter is set
    if (isset($_POST['invoiceNumber'])&& isset($_POST["clientName"])) {
       try{ 
            $invoiceNumber =  $_POST['invoiceNumber'];
            $clientName = $_POST['clientName'];

            // Your SQL query to fetch invoice details data
            $query = "SELECT year, month, day, item_name, number, sale_price, total_price FROM invoice WHERE invoice_number = :invoiceNumber AND client_name= :clientName";

            // Prepare and execute the SQL query
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':invoiceNumber', $invoiceNumber);
            $stmt->bindParam(':clientName', $clientName);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch(PDOException $e){
            echo 'error'. $e->getMessage();
        }
        // Return the data as JSON
        echo json_encode($data);
    } else {
        // Handle the case where invoiceNumber parameter is missing
        echo json_encode(array('error' => 'Missing invoiceNumber parameter'));
    }
?>
