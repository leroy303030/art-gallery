<!DOCTYPE html>
<html>
<head>
    <title>User Bidding</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 500px;
            height: auto;
        }

        #countdown {
    font-size: 24px;
    font-weight: bold;
    color: #333; /* Text color */
    background-color: #f2f2f2; /* Background color */
    padding: 10px;
    border: 1px solid #ccc; /* Border */
    border-radius: 5px;
    margin-top: 20px; /* Add some margin at the top */
    text-align: center;
}

    </style>
</head>
<body>


    <h1>User Bidding</h1>
    
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

    // Retrieve the latest uploaded photo by the admin
    $sql = "SELECT * FROM photo_upload ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->query($sql);
    $latest_photo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($latest_photo) {
        echo "<img src='uploads/" . $latest_photo['filename'] . "' alt='" . $latest_photo['description'] . "'>";
        echo "<p>Description: " . $latest_photo['description'] . "</p>";
        echo "<hr>";
    } else {
        echo "<p>No photos uploaded by admin yet.</p>";
    }

    // Retrieve the admin's starting bid from the database
    $sql = "SELECT admin_starting_bid FROM bid_amount ORDER BY created_at DESC LIMIT 1";
    $stmt = $pdo->query($sql);
    $admin_starting_bid = $stmt->fetchColumn();

    echo '<h2>Admin Starting Bid: $' . $admin_starting_bid . '</h2>';

    // Retrieve the highest bid from the database
    $sql = "SELECT MAX(user_bid) FROM bid_amount";
    $stmt = $pdo->query($sql);
    $highest_bid = $stmt->fetchColumn();

    echo '<h2>Highest Bid: $' . $highest_bid . '</h2>';

    // Display a form for users to place their bids
    echo '<h2>Place Your Bid</h2>';
    echo '<form action="user_bidding.php" method="POST">';
    echo '  <label for="email">Email Address:</label>';
    echo '  <input type="email" name="email" id="email" required><br>';
    echo '  <label for="user_bid">Your Bid:</label>';
    echo '  <input type="number" name="user_bid" id="user_bid" required min="' . ($highest_bid + 1) . '">';
    echo '  <input type="submit" name="submit_user_bid" value="Submit Your Bid">';
    echo '</form>';

    // Process user email address and bid submission
    if (isset($_POST['submit_user_bid'])) {
        $email = $_POST['email'];
        $user_bid = $_POST['user_bid'];

        // Check if the user's bid is valid
        if (!empty($user_bid) && is_numeric($user_bid) && $user_bid >= $admin_starting_bid && $user_bid > $highest_bid) {
            // Insert data into the bid_amount table
            $sql = "INSERT INTO bid_amount (admin_starting_bid, user_bid, email_address) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$admin_starting_bid, $user_bid, $email]);

            echo 'Your bid of $' . $user_bid . ' has been recorded.';
        } else {
            echo 'Invalid bid amount. Please enter a valid bid greater than or equal to the admin starting bid and the current highest bid.';
        }
    }
    $connection = mysqli_connect($servername, $username, $password, $dbname);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set the PHP timezone to UTC
date_default_timezone_set('Asia/Manila');

// Retrieve the start datetime and end datetime from the database
$query = "SELECT start_datetime, end_datetime FROM timer";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($connection));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    $start_datetime = $row['start_datetime'];
    $end_datetime = $row['end_datetime'];

    // Calculate the remaining time for bidding based on the start and end datetime
    $start_timestamp = strtotime($start_datetime);
    $end_timestamp = strtotime($end_datetime);
    $current_timestamp = time();

    if ($current_timestamp >= $start_timestamp && $current_timestamp <= $end_timestamp) {
        // Bidding is active
        $remaining_time = $end_timestamp - $current_timestamp;
    } elseif ($current_timestamp < $start_timestamp) {
        // Bidding has not started yet
        $remaining_time = $start_timestamp - $current_timestamp;
    } else {
        // Bidding has ended
        $remaining_time = 0;
    }
} else {
    // No rows found in the database, handle this case as needed
    echo "No timer data found.";
}

// Close the database connection
mysqli_close($connection);
    ?>

<script>
          function updateCountdown(startDatetime, endDatetime) {
            var countdownElement = document.getElementById("countdown");

            if (countdownElement) {
                var currentTime = new Date().getTime();
                var endTimestamp = new Date(endDatetime).getTime();
                var remainingTime = endTimestamp - currentTime;

                if (remainingTime > 0) {
                    var days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                    remainingTime -= days * (1000 * 60 * 60 * 24);
                    var hours = Math.floor(remainingTime / (1000 * 60 * 60));
                    remainingTime -= hours * (1000 * 60 * 60);
                    var minutes = Math.floor(remainingTime / (1000 * 60));
                    remainingTime -= minutes * (1000 * 60);
                    var seconds = Math.floor(remainingTime / 1000);

                    // Pad single-digit values with a leading zero
                    hours = hours.toString().padStart(2, '0');
                    minutes = minutes.toString().padStart(2, '0');
                    seconds = seconds.toString().padStart(2, '0');

                    countdownElement.innerHTML = "Time left: " + days + "d " + hours + "h " + minutes + "m " + seconds + "s";
                } else {
                    countdownElement.innerHTML = "Bidding has ended.";
                }
            }
        }

        // Function to fetch timer data using AJAX
        function updateTimerData() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'update_bid_timer.php', true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var timerData = JSON.parse(xhr.responseText);

                    // Extract start_datetime and end_datetime from the response
                    var startDatetime = timerData.start_datetime;
                    var endDatetime = timerData.end_datetime;

                    // Update the countdown timer with the new start and end dates
                    updateCountdown(startDatetime, endDatetime);
                }
            };
            
            xhr.send();
        }

        // Call the updateTimerData function to start fetching the latest timer data
        updateTimerData();

        // Update the countdown every second
        setInterval(updateTimerData, 1000);


    </script>
    <div id="countdown"></div>
</body>
</html>
