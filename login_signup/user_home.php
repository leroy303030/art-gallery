<?php
session_start();

// Check if the user is logged in (replace 'username' with your actual user session variable)
if (!isset($_SESSION['username'])) {
    header("location: logout.php");
    exit();
}

// Include the HTML content with a preventCache parameter
header("Location: user_home.html?preventCache=" . time());
?>
