<!DOCTYPE html>
<html>
<head>
<title>User Artworks Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Adjust the number of columns as needed */
            gap: 20px;
            padding: 20px;
        }

        .artwork {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .artwork img {
            max-width: 100%;
            height: auto;
        }

        h2 {
            font-size: 1.5rem;
            margin: 10px 0;
        }

        p {
            font-size: 1rem;
            margin: 5px 0;
        }

        strong {
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>User Artworks</h2>

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

// Query to retrieve all artworks except the primary key
$query = "SELECT image_filename, painting_title, medium, description FROM artworks";
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

// Close the database connection
mysqli_close($conn);
?>

</body>
</html>
