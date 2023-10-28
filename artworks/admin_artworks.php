<!DOCTYPE html>
<html>
<head>
    <title>Admin Artworks Upload</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<style>
    .artwork {
    display: inline-block;
    margin: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    text-align: center;
}

/* Style the artwork image */
.artwork img {
    max-width: 100%;
    height: auto;
}

/* Style the artwork title */
.artwork h2 {
    font-size: 18px;
    margin: 10px 0;
}

/* Style the artwork details (medium and description) */
.artwork p {
    font-size: 14px;
    margin: 5px 0;
}
</style>
<body>

<h2>Upload Artworks</h2>
<form method="post" enctype="multipart/form-data">
    <label for="image">Select Image:</label>
    <input type="file" name="image" required><br>
    <label for="painting_title">Painting Title:</label>
    <input type="text" name="painting_title" required><br>
    <label for="medium">Medium:</label>
    <input type="text" name="medium" required><br>
    <label for="description">Description:</label>
    <textarea name="description" rows="4" cols="50" required></textarea><br>
    <input type="submit" value="Upload">
</form>

<?php
// Database connection
$servername = "localhost"; // Replace with your actual database server hostname or IP address
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "art_gallery"; // Replace with your database name

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize $totalUploaded to 0
$totalUploaded = 0;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the maximum number of photos (6) has been reached
    $query = "SELECT COUNT(*) as total FROM artworks";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $totalUploaded = $row['total'];

    if ($totalUploaded >= 6) {
        echo "You have already uploaded the maximum allowed photos (6).";
    } else {
        $upload_dir = 'uploads/';
        $image_filename = $upload_dir . $_FILES['image']['name'];
        $painting_title = $_POST['painting_title'];
        $medium = $_POST['medium'];
        $description = $_POST['description'];

        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_filename)) {
            $query = "INSERT INTO artworks (image_filename, painting_title, medium, description) VALUES ('$image_filename', '$painting_title', '$medium', '$description')";
            if (mysqli_query($conn, $query)) {
                echo "Image uploaded successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Failed to upload image.";
        }
    }
}

// Display the reset button if the maximum limit is reached
if ($totalUploaded >= 6) {
    echo '<form method="post">
              <input type="submit" name="reset" value="Reset Uploaded Photos">
          </form>';
}

// Query to retrieve all artworks
$query = "SELECT * FROM artworks";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="artwork">
                  <img src="' . $row['image_filename'] . '" alt="' . $row['painting_title'] . '">
                  <h2>' . $row['painting_title'] . '</h2>
                  <p><strong>Medium:</strong> ' . $row['medium'] . '</p>
                  <p><strong>Description:</strong> ' . $row['description'] . '</p>
              </div>';
    }
} else {
    echo "No artworks found.";
}

// Handle the reset button click
if (isset($_POST['reset'])) {
    $query = "TRUNCATE TABLE artworks"; // This query will remove all records from the artworks table
    if (mysqli_query($conn, $query)) {
        echo "Uploaded photos reset successfully. You can now upload a new set of photos.";
    } else {
        echo "Error resetting uploaded photos: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

</body>
</html>
