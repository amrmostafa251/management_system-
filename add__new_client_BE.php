<?php
include 'connection.php'; // Include your connection file

// Get the client_name from user input (replace with your form input name)
$user_input_client_name = $_POST['client_name'];

// Prepare a SQL query to check if the client_name exists
$query = "SELECT client_name FROM clients WHERE client_name = :client_name";

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare($query);
$stmt->bindParam(':client_name', $user_input_client_name);
$stmt->execute();

// Check if the client_name already exists
if ($stmt->rowCount() > 0) {
    // Client name already exists, show an alert to the user
    echo '<script>alert("أسم الصيدلية موجود بالفعل ");window.location.href="add_new_clients.php";</script>';
} else {
    // Client name is unique, insert it into the clients table
    $insertQuery = "INSERT INTO clients (client_name) VALUES (:client_name)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bindParam(':client_name', $user_input_client_name);
    $insertStmt->execute();

    // Optionally, you can show a success message to the user
    echo '<script>alert("   تم إضاف أسم الصيدلية بنجاح ");window.location.href="add_new_clients.php";</script>';
}

// Close the prepared statements
$stmt->closeCursor();
$insertStmt->closeCursor();
?>

