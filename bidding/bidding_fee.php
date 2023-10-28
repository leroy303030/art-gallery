<?php
session_start(); // Start or resume the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: before_bidding.php");
    exit(); // Stop further execution
}

// Fetch the user-specific data from the session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Database connection information
$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "art_gallery";

// Create a database connection
$conn = new mysqli($servername, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the latest admin uploaded photo from the database
$sql = "SELECT * FROM qr_code ORDER BY id DESC LIMIT 1"; // Assuming 'id' is the primary key column
$result = $conn->query($sql);

// Handle the Payment Proof Upload
$uploadMessage = ""; // Initialize the upload message

if (isset($_POST['submit'])) {
    $target_dir = "proof_of_payment/"; // Directory where uploaded payment proof files will be stored

    // Ensure the target directory exists or create it if it doesn't
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["payment_proof"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if a file with the same name already exists
    if (file_exists($target_file)) {
        $uploadMessage = "Sorry, a file with the same name already exists.";
        $uploadOk = 0;
    }

    // Check if the file size is too large (you can adjust the size limit as needed)
    if ($_FILES["payment_proof"]["size"] > 5000000) { // 5MB limit, you can adjust this
        $uploadMessage = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats (you can add more formats if needed)
    if ($fileType != "pdf" && $fileType != "jpg" && $fileType != "jpeg" && $fileType != "png") {
        $uploadMessage = "Sorry, only PDF, JPG, JPEG, and PNG files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $uploadMessage = "Sorry, your file was not uploaded.";
    } else {
       // If everything is fine, try to upload the file
if (move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file)) {
    // Insert the payment proof information into the database
    $file_path = $target_file; // Store the file path

    // Insert into the payment_proof table
    $sql_payment = "INSERT INTO payment_proof (user_id, file_path) VALUES (?, ?)";
    $stmt = $conn->prepare($sql_payment);
    $stmt->bind_param("is", $user_id, $file_path);

    if ($stmt->execute()) {
        $uploadMessage = "Your request to join the bid is now on manual review. Please wait for a moment.";

        // Now, insert a new row into the user_requests table
        $request_date = date('Y-m-d H:i:s'); // Get the current timestamp
        $status = 'Pending';

        $sql_insert_request = "INSERT INTO user_requests (user_id, request_date, status) VALUES (?, ?, ?)";
        $stmt_insert_request = $conn->prepare($sql_insert_request);
        $stmt_insert_request->bind_param("iss", $user_id, $request_date, $status);

        if ($stmt_insert_request->execute()) {
            // Insertion into user_requests successful
        } else {
            // Error inserting into user_requests
        }

        $stmt_insert_request->close();
    } else {
        $uploadMessage = "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $uploadMessage = "Sorry, there was an error uploading your file.";
}
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bidding Fee</title>
    <style>
        /* Add CSS styles here */
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
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .logout-container {
            float: right;
            padding: 1px 10px;
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="../login_signup/user_home.php">Home</a>
    <a href="../bookavisit.html">Book a Visit</a>
    <a href="#">Artworks</a>
    <a href="#">Exhibition</a>
    <a href="../bidding/before_bidding.php">Bidding</a>
    <a href="../arscanner/user_scanner.html">AR Scanner</a>
    <div class="logout-container">
        <a href="logout.php">Logout</a>
    </div>
</div>

    <h2>Welcome, <?php echo $username; ?>!</h2>

    <!-- Display Admin Uploaded Photos -->
    <h3>Scan QR code to pay through GCASH!</h3>
    <?php
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $photo_name = $row['photo_name'];
        $photo_description = $row['photo_description'];
        $photo_file = $row['photo_file']; // Assuming you have a column for the file name

        if (!empty($photo_file)) {
            echo '<img src="' . $photo_file . '" alt="Scan QR code to pay through GCASH!"><br><br>';
        } else {
            echo '<p>No photo available.</p>';
        }
    } else {
        echo '<p>No admin uploaded photos available.</p>';
    }
   // Fetch the user's request status
$sql = "SELECT status FROM user_requests WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($request_status);
$stmt->fetch();
$stmt->close();

// Display messages based on the request status
if ($request_status === 'Approved') {
    echo '<p>Your request is Approved!</p>';
    echo '<a href="user_bidding.php">Go to Bidding Page</a>';
} elseif ($request_status === 'Rejected') {
    echo '<p>Your request is Rejected!</p>';
} elseif ($request_status === 'Pending') {
    echo '<p>Your request is on manual review. Please wait for a moment...</p>';
}



    ?>

    <!-- Display the upload message -->
    <?php if (!empty($uploadMessage)) : ?>
        <p><?php echo $uploadMessage; ?></p>
    <?php endif; ?>

    <!-- Proof of Payment Upload -->
    <h3>Upload Proof of Payment:</h3>
    <?php if (empty($uploadMessage)) : ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="payment_proof">Upload Proof of Payment:</label>
            <input type="file" name="payment_proof" id="payment_proof" accept=".pdf, .jpg, .jpeg, .png" required><br><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    <?php endif; ?>

    <!-- Terms and Conditions Popup -->
    <p><a href="javascript:void(0);" onclick="openTermsPopup();">Terms and Conditions</a></p>

    <div id="terms_popup" style="display: none;">
        <h3>Terms and Conditions</h3>
        <!-- Add your terms and conditions content here -->
        <p>This is where you can provide your terms and conditions.</p>
        <button onclick="closeTermsPopup();">Close</button>
    </div>

    <script>
        function openTermsPopup() {
            document.getElementById("terms_popup").style.display = "block";
        }

        function closeTermsPopup() {
            document.getElementById("terms_popup").style.display = "none";
        }

        function joinBid() {
            alert("You have successfully joined the bid!");
            // Add code to perform the "Join Bid" action here
        }
    </script>
</body>
</html>
