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

    // Check if 'type' is set in the POST data
    if (isset($_POST['type'])) {
        $type = $_POST['type'];

        if ($type === 'edit') {
            // Handle edit operation
            $countnumber = $_POST['countnumber'];

            for ($i = 1; $i <= $countnumber; $i++) {
                if (isset($_POST['edittedName'][$i - 1])) {
                    $item_name = $_POST['item_name'][$i - 1];
                    $edittedName = $_POST['edittedName'][$i - 1];

                    // Update the 'sales' table
                    $sql = "UPDATE sales SET item_name = :edittedName WHERE item_name = :item_name";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(['edittedName' => $edittedName, 'item_name' => $item_name]);
                    // Update the 'purchases' table
                    $sql = "UPDATE purchases SET item_name = :edittedName WHERE item_name = :item_name";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(['edittedName' => $edittedName, 'item_name' => $item_name]);
                    // Update the 'items' table
                    $sql = "UPDATE items SET item_name = :edittedName WHERE item_name = :item_name";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(['edittedName' => $edittedName, 'item_name' => $item_name]);
                    // Update the 'exist' table
                    $sql = "UPDATE exist SET item_name = :edittedName WHERE item_name = :item_name";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(['edittedName' => $edittedName, 'item_name' => $item_name]);
                    // Update the 'client_sales' table
                    $sql = "UPDATE client_sales SET item_name = :edittedName WHERE item_name = :item_name";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(['edittedName' => $edittedName, 'item_name' => $item_name]);

                }
            }
            echo '<script>alert("تم تعديل أسم المنتج بنجاح  "); window.location.href = "details.php";</script>';
        } elseif ($type === 'delete') {
            // Handle delete operation
            $countnumber = $_POST['countnumber'];

            for ($i = 1; $i <= $countnumber; $i++) {
                if (isset($_POST['item_name'][$i - 1])) {
                    $item_name = $_POST['item_name'][$i - 1];

                    // Delete the item from the 'items' table
                    $sql = "DELETE FROM items WHERE item_name = :item_name LIMIT 1";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);
                    $stmt->execute();
                    // Delete the item from the 'exist' table
                    $sql = "DELETE FROM exist WHERE item_name = :item_name LIMIT 1";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);
                    $stmt->execute();
                    // Delete the item from the 'client_sales' table
                    $sql = "DELETE FROM client_sales WHERE item_name = :item_name LIMIT 1";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);
                    $stmt->execute();                }
            }
            echo '<script>alert("تم حذف   المنتج بنجاح  "); window.location.href = "details.php";</script>';
        }
    } else {
        echo '<script>alert("حدث خطأ ما "); window.location.href = "details.php";</script>';
    }

}
?>
