<?php
// Database connection information
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "art_gallery";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve username and password from the form
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate user input (you can add more validation)
    if (empty($username) || empty($password)) {
        header("Location: login_form.html?error=empty");
        exit();
    }

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, login successful, redirect to user_bidding.php
            session_start();
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            header("Location: bidding_fee.php");
            exit();
        }
    }
}

// Login failed, redirect back to the login page with an error message
header("Location: login_form.html?error=1");
exit();

// Close the database connection
$stmt->close();
$conn->close();
?>
