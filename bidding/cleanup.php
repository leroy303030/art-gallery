<?php
// Database connection parameters (similar to your existing code)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "art_gallery";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get a list of filenames from the database
$sql = "SELECT filename FROM photo_upload";
$stmt = $pdo->query($sql);
$databaseFilenames = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Get a list of filenames from the directory
$uploadDirectory = "uploads/";
$directoryFilenames = scandir($uploadDirectory);

// Identify orphaned files and delete corresponding database records
foreach ($databaseFilenames as $filename) {
    if (!in_array($filename, $directoryFilenames)) {
        // This filename exists in the database but not in the directory, it's orphaned
        // Delete the record from the database
        $deleteSql = "DELETE FROM photo_upload WHERE filename = ?";
        $deleteStmt = $pdo->prepare($deleteSql);
        $deleteStmt->execute([$filename]);
        echo "Deleted orphaned record for file: $filename<br>";
    }
}

echo "Cleanup completed.";

// Close the database connection
$pdo = null;
?>
