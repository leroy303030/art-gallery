<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Create a database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the username already exists
    $checkUsername = "SELECT username FROM userlogin WHERE username = ?";
    $stmt = $conn->prepare($checkUsername);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo 'Username already exists';
    } else {
        // Insert user data into the database
        $insertUser = "INSERT INTO userlogin (username, password_hash) VALUES (?, ?)";
        $stmt = $conn->prepare($insertUser);
        $stmt->bind_param("ss", $username, $hashedPassword);
        if ($stmt->execute()) {
            echo 'Registration successful';
        } else {
            echo 'Registration failed';
        }
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
