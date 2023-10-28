<?php
session_start(); // Start or resume the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login_process.php");
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Success Page</title>
</head>
<body>
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

// Check if the user has submitted payment proof
$sql_payment_check = "SELECT COUNT(*) FROM payment_proof WHERE user_id = ?";
$stmt_payment_check = $conn->prepare($sql_payment_check);
$stmt_payment_check->bind_param("i", $user_id);
$stmt_payment_check->execute();
$stmt_payment_check->bind_result($payment_proof_count);
$stmt_payment_check->fetch();
$stmt_payment_check->close();

// Display messages based on the request status and payment proof
if ($request_status === 'Approved') {
    echo '<p>Your request is Approved!</p>';
    echo '<a href="user_bidding.php">Go to Bidding Page</a>';
} elseif ($request_status === 'Rejected') {
    echo '<p>Your request is Rejected!</p>';
} elseif ($payment_proof_count > 0) {
    echo '<p>Your request is on manual review. Please wait for a moment...</p>';
} else {
    echo '<p>Please submit your payment proof to proceed.</p>';
}
    ?>

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
