<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Database connection details
    $servername = "localhost"; // Replace with your database server name or IP address
    $db_username = "root"; // Replace with your database username
    $db_password = ""; // Replace with your database password
    $db_name = "art_gallery"; // Replace with your database name

    // Create a database connection
    $conn = new mysqli($servername, $db_username, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM admin_user WHERE username = ?");

    $stmt->bind_param("s", $username);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if an admin with the provided username exists
    if ($result->num_rows == 1) {
        // Authentication successful
        $_SESSION["admin_username"] = $username;
        header("Location: admin_home.php"); // Redirect to admin dashboard
        exit();
    } else {
        echo "Invalid username.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
