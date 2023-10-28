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

// Get form data
$contactName = $_POST['contactName'];
$visitDate = $_POST['visitDate'];
$numVisitors = $_POST['numVisitors'];

// Insert data into the database
$sql = "INSERT INTO bookings (contactName, visitDate, numVisitors) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $contactName, $visitDate, $numVisitors);

if ($stmt->execute()) {
    // Data inserted successfully, you can generate a QR code here
    $bookingId = $stmt->insert_id;
    $qrCodeText = "Booking ID: $bookingId\nContact Person: $contactName\nVisit Date: $visitDate\nNumber of Visitors: $numVisitors";

    // Generate the QR code using a library like QRCode.js or phpqrcode

    // For demonstration purposes, we'll just display the QR code text
    echo "<h2>QR Code</h2>";
    echo "<div>$qrCodeText</div>";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();

// Close the database connection
$conn->close();
?>