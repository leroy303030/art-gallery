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

// Retrieve the start datetime and end datetime from the database
$query = "SELECT start_datetime, end_datetime FROM timer ORDER BY id DESC LIMIT 1";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($connection));
}

// Fetch the current start and end datetime from the result
$row = mysqli_fetch_assoc($result);
$startDatetime = $row['start_datetime'];
$endDatetime = $row['end_datetime'];

// Close the database connection
mysqli_close($connection);

// Prepare the data to be sent as JSON
$response = array(
    'start_datetime' => $startDatetime,
    'end_datetime' => $endDatetime
);

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the JSON response
echo json_encode($response);
?>
