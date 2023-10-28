<?php
// Establish a database connection (replace with your actual database connection code)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'art_gallery';

$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$start_datetime = $_POST['start_datetime'];
$end_datetime = $_POST['end_datetime'];

// Insert the start datetime and end datetime into the database
$query = "INSERT INTO timer (start_datetime, end_datetime) VALUES ('$start_datetime', '$end_datetime')";

if (mysqli_query($connection, $query)) {
    echo "Data added successfully.";
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Timer Data Added</title>
</head>
<body>
    
    <!-- Add a back button linking to admin_bidding.php -->
    <a href="admin_bidding.php">Back to Admin Bidding Page</a>
</body>
</html>