<?php
// Start the session
session_start();

// Check if the user is logged in (i.e., the user_name session variable is set)
if (isset($_SESSION['user_name'])) {
    // Unset the user_name session variable
    unset($_SESSION['user_name']);
    
    // Destroy the session
    session_destroy();
    
    // Redirect to a login page or any other destination
    header("Location: homepage.php");
    exit();
} else {
    // Handle cases where the user is not logged in
    echo "You are not logged in.";
}
?>
