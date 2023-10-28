<!DOCTYPE html>
<html>
<head>
    <title>ADMIN HOME</title>
    <style>
      /* Add CSS styles here */
      body {
          font-family: Arial, sans-serif;
          background-color: #f0f0f0;
          margin: 0;
          padding: 0;
      }

      .navbar {
          background-color: #333;
          overflow: hidden;
      }

      .navbar a {
          float: left;
          font-size: 16px;
          color: white;
          text-align: center;
          padding: 14px 16px;
          text-decoration: none;
          transition: background-color 0.3s, color 0.3s; /* Add smooth transition for hover effect */
      }

      /* Style for the "Home" link when active or hovered */
      .navbar a.active,
      .navbar a:hover {
          background-color: #007BFF; /* Change the background color to your desired color */
          color: white; /* Change the text color to your desired color */
      }

      .login-button {
          float: right;
          padding: 14px 16px;
          background-color: #007BFF;
          color: white;
          border: none;
          cursor: pointer;
      }

      /* Style for the logout button container */
      .logout-container {
          float: right;
          padding: 1px 10px;
      }

    </style>
</head>
<body>
<div class="navbar">
    <a href="admin_home.php" class="active">Home</a>
    <a href="../admin/admin_bookavisit.html">Book a Visit</a>
    <a href="#">Artworks</a>
    <a href="#">Exhibition</a>
    <a href="../bidding/admin_bidding.php">Bidding</a>
    <a href="../arscanner/admin_scanner.html">AR Scanner</a>
    <div class="logout-container">
        <a href="logout.php">Logout</a>
    </div>
</div>


<h1>WELCOME ADMIN!</h1>
<!--
<script>
    if (window.history && window.history.pushState) {
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function () {
            window.location.href = '../regularui/regularui_home.html'; // Redirect to regular UI home page
        };
    }
</script>
-->

<?php
session_start(); // Start the session

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Check if the admin is logged in (replace 'admin_username' with your actual admin session variable)
if (!isset($_SESSION['admin_username'])) {
    header("location: logout.php");
    exit();
}
?>

</body>
</html>
