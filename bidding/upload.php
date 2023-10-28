<?php
// Database connection parameters
$servername = "localhost"; // Change this to your MySQL server hostname
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "art_gallery"; // Change this to your database name

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if (isset($_POST['upload'])) {
    $description = $_POST['description'];
    $filename = $_FILES['photo']['name'];

    // Move the uploaded file to a directory
    $uploadDirectory = "uploads/";
    $targetFilePath = $uploadDirectory . $filename;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
        // Insert data into the database
        $sql = "INSERT INTO photo_upload (filename, description) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$filename, $description]);

        echo "Upload successful.";
    } else {
        echo "Error uploading file.";
    }
}

// Redirect back to the admin page
header("Location: admin_bidding.php");
?>
