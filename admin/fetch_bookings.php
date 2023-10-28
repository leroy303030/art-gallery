<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "art_gallery";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current date
$currentDate = date("Y-m-d");

// SQL query to fetch bookings for future dates
$sql = "SELECT * FROM bookings WHERE visitDate >= '$currentDate' ORDER BY visitDate ASC";

// Execute the query
$result = $conn->query($sql);

if (!$result) {
    // Handle database query error
    echo json_encode(['error' => $conn->error]);
} else {
    // Fetch and format the data as an array of objects
    $bookingData = [];
    while ($row = $result->fetch_assoc()) {
        $bookingData[] = [
            'id' => $row['id'],
            'contactName' => $row['contactName'],
            'visitDate' => $row['visitDate'],
            'numVisitors' => $row['numVisitors'],
        ];
    }

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($bookingData);
}

// Close the database connection
$conn->close();
?>
