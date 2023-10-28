<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create a database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the username exists
    $checkUsername = "SELECT username, password_hash FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkUsername);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($dbUsername, $dbPassword);
        $stmt->fetch();

        // Verify the hashed password
        if (password_verify($password, $dbPassword)) {
            // Password is correct, login successful
            session_start();
            $_SESSION['username'] = $username;
            header("Location: user_home.php"); // Redirect to the user's home page
        } else {
            // Password is incorrect
            echo 'Login failed';
        }
    } else {
        // Username doesn't exist
        echo 'Username not found';
    }

    ini_set('display_errors', 1);
error_reporting(E_ALL);


    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
