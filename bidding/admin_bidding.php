<!DOCTYPE html>
<html>
<head>
    <title>Admin Bidding</title>
    <style>
          body {
          font-family: Arial, sans-serif;
          background-color: #f0f0f0;
          margin: 0;
          padding: 0;
      }

      .navbar {
          background-color: #333;
          overflow: hidden;
      }

      .navbar a {
          float: left;
          font-size: 16px;
          color: white;
          text-align: center;
          padding: 14px 16px;
          text-decoration: none;
          transition: background-color 0.3s, color 0.3s; /* Add smooth transition for hover effect */
      }

      /* Style for the "Home" link when active or hovered */
      .navbar a.active,
      .navbar a:hover {
          background-color: #007BFF; /* Change the background color to your desired color */
          color: white; /* Change the text color to your desired color */
      }

      .login-button {
          float: right;
          padding: 14px 16px;
          background-color: #007BFF;
          color: white;
          border: none;
          cursor: pointer;
      }

      /* Style for the logout button container */
      .logout-container {
          float: right;
          padding: 1px 10px;
      }

    </style>
</head>
<body>
<div class="navbar">
    <a href="../login_signup/admin_home.php" >Home</a>
    <a href="../admin/admin_bookavisit.html">Book a Visit</a>
    <a href="#">Artworks</a>
    <a href="#">Exhibition</a>
    <a href="../bidding/admin_bidding.php" class="active">Bidding</a>
    <a href="../arscanner/admin_scanner.html">AR Scanner</a>
    <div class="logout-container">
        <a href="../login_signup/logout.php">Logout</a>
    </div>
</div>
<div class="navbar">
    <a href="../bidding/admin_bidding.php " class="active" >BIDDING</a>
    <a href="../bidding/admin_bidding2.php">BIDDING FEE</a>

    </div>
    <h1>Admin Bidding - Upload Photo and Set Starting Bid</h1>
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

    // Handle photo upload
    if (isset($_POST['submit_photo'])) {
        $description = $_POST['photo_description'];

        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES["admin_photo"]["name"]);

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["admin_photo"]["tmp_name"]);
        if ($check !== false) {
            // Check if file already exists
            if (file_exists($targetFile)) {
                echo "Sorry, this file already exists.";
            } else {
                if (move_uploaded_file($_FILES["admin_photo"]["tmp_name"], $targetFile)) {
                    // Insert data into the database
                    $sql = "INSERT INTO photo_upload (filename, description) VALUES (?, ?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$_FILES["admin_photo"]["name"], $description]);

                    echo "The file " . htmlspecialchars(basename($_FILES["admin_photo"]["name"])) . " has been uploaded and added to the gallery.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            echo "File is not an image.";
        }
    }

   // Set the admin starting bid and reset highest bid to zero
   if (isset($_POST['set_starting_bid'])) {
    $admin_starting_bid = $_POST['starting_bid'];

    // Update the admin starting bid in the database
    $sql = "INSERT INTO bid_amount (admin_starting_bid, user_bid) VALUES (?, 0)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$admin_starting_bid]);

    // Reset the highest bid to zero
    $sql_reset_highest_bid = "UPDATE bid_amount SET user_bid = 0";
    $stmt_reset_highest_bid = $pdo->prepare($sql_reset_highest_bid);
    $stmt_reset_highest_bid->execute();

    echo "Admin starting bid has been set to $" . $admin_starting_bid . " and the highest bid has been reset to zero.";
}
    ?>

    <h2>Upload New Photo</h2>
    <form action="admin_bidding.php" method="POST" enctype="multipart/form-data">
        <label for="admin_photo">Select image to upload:</label>
        <input type="file" name="admin_photo" id="admin_photo" accept="image/*" required>
        <label for="photo_description">Photo Description:</label>
        <input type="text" name="photo_description" id="photo_description" required>
        <input type="submit" name="submit_photo" value="Upload Photo">
    </form>

    <h2>Set Admin Starting Bid and Reset Highest Bid</h2>
    <form action="admin_bidding.php" method="POST">
        <label for="starting_bid">Starting Bid:</label>
        <input type="text" name="starting_bid" id="starting_bid" required>
        <input type="submit" name="set_starting_bid" value="Set Starting Bid">
    </form>

    <h1>Admin - Set Bidding Start and End</h1>
    <form method="post" action="save_datetime_range.php">
        <label for="start_datetime">Start Date and Time:</label>
        <input type="datetime-local" name="start_datetime" id="start_datetime" required><br>

        <label for="end_datetime">End Date and Time:</label>
        <input type="datetime-local" name="end_datetime" id="end_datetime" required><br>

        <input type="submit" value="Set Bidding Start and End">
    </form>

    <h2>Table of User Bids with Usernames</h2>

<?php
// Fetch the user_bid and user_id columns from the bid_amount table where user_bid is greater than zero
try {
    $sql = "SELECT user_bid, email_address FROM bid_amount WHERE user_bid > 0";
    
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>BID AMOUNT</th>';
        echo '<th>BIDDER EMAIL</th>';
        echo '</tr>';

        foreach ($result as $row) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['user_bid']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email_address']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No user bids with a value greater than zero in the bid_amount table.</p>';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


?>




    
</body>
</html>
