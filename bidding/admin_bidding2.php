<!DOCTYPE html>
<html>
<head>
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
    <title>Admin Bidding</title>
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
    <a href="../bidding/admin_bidding.php" >BIDDING</a>
    <a href="../bidding/admin_bidding2.php">BIDDING FEE</a>

    </div>
    <h2>Proof of Payment</h2>

    <!-- Display Admin Uploaded Photos -->
    <h3>LIST OF PENDING REQUEST TO JOIN BID</h3>
    <?php
    // Database connection information
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "art_gallery"; // Corrected database name

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch admin uploaded photos from the payment_proof table and join with users table to get usernames
    $sql = "SELECT pp.file_path, pp.upload_date, u.username, ur.request_id, ur.status
            FROM payment_proof pp
            JOIN users u ON pp.user_id = u.user_id
            JOIN user_requests ur ON pp.user_id = ur.user_id
            ORDER BY pp.upload_date DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table border="1">';
        echo '<tr><th>File Path</th><th>Upload Date</th><th>Username</th><th>Action</th><th>Status</th></tr>';
        while ($row = $result->fetch_assoc()) {
            $file_path = $row['file_path'];
            $upload_date = $row['upload_date'];
            $username = $row['username'];
            $request_id = $row['request_id'];
            $status = $row['status'];

            echo '<tr>';
            echo '<td><a href="' . $file_path . '" target="_blank">View Photo</a></td>';
            echo '<td>' . $upload_date . '</td>';
            echo '<td>' . $username . '</td>';
            echo '<td>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="accept_request_id" value="' . $request_id . '">';
            echo '<input type="submit" value="Accept">';
            echo '</form>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="reject_request_id" value="' . $request_id . '">';
            echo '<input type="submit" value="Reject">';
            echo '</form>';
            echo '</td>';
            echo '<td>';
            if ($status == 'Approved' || $status == 'Rejected') {
                echo 'VERIFIED';
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No Proof of Payment Currently Uploaded</p>';
    }
    ?>
    <h3>LIST OF ACCEPTED REQUESTS</h3>
    <?php
    // Fetch and display the table of accepted requests
    $sqlAccepted = "SELECT pp.file_path, pp.upload_date, u.username, ur.request_id
        FROM payment_proof pp
        JOIN users u ON pp.user_id = u.user_id
        JOIN user_requests ur ON pp.user_id = ur.user_id
        WHERE ur.status = 'Approved'
        ORDER BY pp.upload_date DESC";
    $resultAccepted = $conn->query($sqlAccepted);

    if ($resultAccepted->num_rows > 0) {
        echo '<table border="1">';
        echo '<tr><th>File Path</th><th>Upload Date</th><th>Username</th><th>Action</th></tr>';
        while ($row = $resultAccepted->fetch_assoc()) {
            $file_path = $row['file_path'];
            $upload_date = $row['upload_date'];
            $username = $row['username'];
            $request_id = $row['request_id'];

            echo '<tr>';
            echo '<td><a href="' . $file_path . '" target="_blank">View Photo</a></td>';
            echo '<td>' . $upload_date . '</td>';
            echo '<td>' . $username . '</td>';
            echo '<td>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No Accepted Requests</p>';
    }
    ?>
    <h3>LIST OF REJECTED REQUESTS</h3>
    <?php
    // Fetch and display the table of rejected requests
    $sqlRejected = "SELECT pp.file_path, pp.upload_date, u.username, ur.request_id
        FROM payment_proof pp
        JOIN users u ON pp.user_id = u.user_id
        JOIN user_requests ur ON pp.user_id = ur.user_id
        WHERE ur.status = 'Rejected'
        ORDER BY pp.upload_date DESC";
    $resultRejected = $conn->query($sqlRejected);

    if ($resultRejected->num_rows > 0) {
        echo '<table border="1">';
        echo '<tr><th>File Path</th><th>Upload Date</th><th>Username</th><th>Action</th></tr>';
        while ($row = $resultRejected->fetch_assoc()) {
            $file_path = $row['file_path'];
            $upload_date = $row['upload_date'];
            $username = $row['username'];
            $request_id = $row['request_id'];

            echo '<tr>';
            echo '<td><a href="' . $file_path . '" target="_blank">View Photo</a></td>';
            echo '<td>' . $upload_date . '</td>';
            echo '<td>' . $username . '</td>';
            echo '<td>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No Rejected Requests</p>';
    }

    // ... Previous code for handling the image upload ...

    // When admin approves a request
    if (isset($_POST['accept_request_id'])) {
        $request_id = $_POST['accept_request_id']; // Assuming you have a way to get the request ID
        $sql = "UPDATE user_requests SET status = 'Approved' WHERE request_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $stmt->close();
    }

    // When admin rejects a request
    if (isset($_POST['reject_request_id'])) {
        $request_id = $_POST['reject_request_id']; // Assuming you have a way to get the request ID
        $sql = "UPDATE user_requests SET status = 'Rejected' WHERE request_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $stmt->close();

        // Set the rejection message in the session
        $_SESSION['rejection_message'] = "Your request has been rejected!";
    }
    ?>
    <h3>POST GCASH QR CODE HERE!</h3>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="photo">Select Image to Upload:</label>
        <input type="file" name="photo" id="photo" accept=".jpg, .jpeg, .png, .gif" required><br><br>
        <input type="submit" name="submit" value="Upload Photo">
    </form>
</body>
<script>
    function acceptRequest(requestId) {
        // Make an AJAX request to update the request status to 'Approved'
        fetch('update_request_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ requestId, status: 'Approved' }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add a label to indicate that the request is "VERIFIED"
                var button = document.querySelector('input[name="accept_request_id"][value="' + requestId + '"]');
                var label = document.createElement('span');
                label.textContent = 'VERIFIED';
                button.parentNode.appendChild(label);
            } else {
                alert('Failed to accept the request.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function rejectRequest(requestId) {
        // Make an AJAX request to update the request status to 'Rejected'
        fetch('update_request_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application.json',
            },
            body: JSON.stringify({ requestId, status: 'Rejected' }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add a label to indicate that the request is "VERIFIED"
                var button = document.querySelector('input[name="reject_request_id"][value="' + requestId + '"]');
                var label = document.createElement('span');
                label.textContent = 'VERIFIED';
                button.parentNode.appendChild(label);
            } else {
                alert('Failed to reject the request.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
</html>
