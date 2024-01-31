<?php
// Include the connection file
require_once 'connection.php';

// Start the session
session_start();

// User-provided credentials
$user_Name = $_POST['username'];
$password = $_POST['password'];

// SQL query to check user credentials
$query = "SELECT * FROM users WHERE user_name = :user_name AND password = :password";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_name', $user_Name, PDO::PARAM_STR);
$stmt->bindParam(':password', $password, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    if ($user['user_name'] == $user_Name && $user['password'] == $password) {
        // Store user information in the session
        $_SESSION['user_name'] = $user['user_name'];
        
        // Redirect to the main page
        header("Location: main_page.php");
        exit();
    } elseif ($user['user_name'] == "abdo" && $user['password'] == "111111") {
        // Store user information in the session
        $_SESSION['user_name'] = $user['user_name'];
        
        // Redirect to the helper page
        header("Location: helper.php");
        exit();
    } else {
        // Display an alert and redirect to homepage.php using JavaScript
        echo '<script>alert("Invalid credentials"); window.location.href = "homepage.php";</script>';
    }
    
} else {
    // Display an alert and redirect to homepage.php using JavaScript
    echo '<script>alert("Invalid credentials"); window.location.href = "homepage.php";</script>';
}

?>
