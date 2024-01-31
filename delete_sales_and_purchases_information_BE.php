<?php
require_once 'connection.php';
session_start();

// Check if the user is logged in and is an admin
if ($_SESSION['user_name'] != 'alsafa') {
    // Redirect to the home page
    header("Location: homepage.php");
    exit();
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the "type" is set and not empty
        if (isset($_POST['type'])) {
            $type = $_POST['type'];

            if ($type == 'sales' || $type == 'purchases') {
                // Check if "year" and "month" are set and not empty
                if (isset($_POST['year']) && isset($_POST['month'])) {
                    $year = $_POST['year'];
                    $month = $_POST['month'];

                    // Define the table name based on the selected "type"
                    $table = ($type == 'sales') ? 'sales' : 'purchases';

                    // Prepare a SQL statement to delete data from the specified table with the same year and month
                    $deleteStmt = $conn->prepare("DELETE FROM $table WHERE year = :year AND month = :month");
                    $deleteStmt->bindParam(':year', $year);
                    $deleteStmt->bindParam(':month', $month);
                    $deleteStmt->execute();
                    if ($type == "sales"){
                        $stmt = $conn->prepare("DELETE FROM invoice WHERE year =? and month =?");
                        $stmt->execute([$year, $month]);
                    }
                    // Display an alert and redirect to homepage.php using JavaScript
                    echo '<script>alert("تم حذف بيانات الشهر بنجاح "); window.location.href = "delets.php";</script>';
                } else {
                    echo '<script>alert("Please select a year and month."); window.location.href = "delets.php";</script>';
                }
            } else {
                echo '<script>alert("Invalid data type selected."); window.location.href = "new_invoice.php";</script>';
            }
        } else {
            echo '<script>alert("Invalid request."); window.location.href = "delets.php";</script>';
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    echo '<script>alert("An error occurred!"); window.location.href = "delets.php";</script>';
}
?>
