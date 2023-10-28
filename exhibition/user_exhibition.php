<!DOCTYPE html>
<html>
<head>
    <title>User Exhibition Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* 5 columns per row */
            gap: 20px; /* Gap between images */
            padding: 20px;
        }

        .artwork {
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .artwork img {
            max-width: 100%;
            height: auto;
        }

        .artwork h2 {
            margin: 10px 0;
        }

        .artwork p {
            font-size: 14px;
        }
    </style>
</head>
<body>

<h2>Exhibition Gallery</h2>

<div class="gallery">
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

    // Query to retrieve artworks from the exhibition table
    $query = "SELECT * FROM exhibition";
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
</div>

</body>
</html>
