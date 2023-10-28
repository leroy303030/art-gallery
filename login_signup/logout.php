<?php
session_start(); // Start the session

// Check which type of session was active before logout
if (isset($_SESSION['admin_username'])) {
    // Redirect to the admin login page
    header("location: admin_login.php");
} elseif (isset($_SESSION['username'])) {
    // Redirect to the user login page
    header("location: login.php");
} else {
    // Redirect to the regular UI home page
    header("location: ../regularui/regularui_home.html");
}

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

exit();
?>
