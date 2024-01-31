<?php
// Include your connection file
include('connection.php');

 //Get the client_name from the AJAX request
 $client_name = $_GET['client_name'];

    // Query to get the largest invoice_number for the given client_name
    $sql = "SELECT MAX(invoice_number) as max_invoice_number FROM invoice WHERE client_name = :client_name";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':client_name', $client_name, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        // Get the largest invoice_number
        $max_invoice_number = $row['max_invoice_number'];

        // Check if there are any invoice numbers
        if ($max_invoice_number !== null) {
            // Increment the largest invoice number by 1
            $next_invoice_number = $max_invoice_number + 1;
        } else {
            // If there are no invoice numbers for this client, set the next_invoice_number to 1
            $next_invoice_number = 1;
        }
    } else {
        // Handle the case where no rows were found, e.g., if there are no records for the client_name.
        $next_invoice_number = 1;
    }

// Return the next invoice number to the client as JSON
echo json_encode(['next_invoice_number' => $next_invoice_number]);

?>