<?php
// Include the database configuration file
require_once 'config.php';

// Create a database connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Initialize variables to store user input
$username = $password = $phone_number = $first_name = $middle_name = $last_name = $email_address = $permanent_address = '';
$username_err = $password_err = $email_err = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate username
    if (empty(trim($_POST['username']))) {
        $username_err = 'Please enter a username.';
    } else {
        $sql = 'SELECT user_id FROM users WHERE username = ?';

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('s', $param_username);

            $param_username = trim($_POST['username']);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $username_err = 'This username is already taken.';
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo 'Oops! Something went wrong. Please try again later.';
            }

            $stmt->close();
        }
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter a password.';
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = 'Password must have at least 6 characters.';
    } else {
        $password = trim($_POST['password']);
    }

    // Check for input errors before inserting into the database
    if (empty($username_err) && empty($password_err)) {
        // Prepare an INSERT statement
        $sql = 'INSERT INTO users (username, password, phone_number, first_name, middle_name, last_name, email_address, permanent_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('ssssssss', $param_username, $param_password, $param_phone_number, $param_first_name, $param_middle_name, $param_last_name, $param_email_address, $param_permanent_address);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
            $param_phone_number = trim($_POST['phone_number']);
            $param_first_name = trim($_POST['first_name']);
            $param_middle_name = trim($_POST['middle_name']);
            $param_last_name = trim($_POST['last_name']);
            $param_email_address = trim($_POST['email_address']);
            $param_permanent_address = trim($_POST['permanent_address']);

            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                header('location: login.php');
            } else {
                echo 'Something went wrong. Please try again later.';
            }

            $stmt->close();
        }
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Style for the form container */
.form-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f5f5f5;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Style for labels */
label {
    display: block;
    margin-bottom: 5px;
    margin-left: 100px;
}

/* Style for input fields */
input[type="text"],
input[type="password"],
input[type="email"] {
    margin-left: 100px;
    width: 500px;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* Style for submit button */
input[type="submit"] {
    background-color: #007BFF;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
    margin-left: 100px;
}

/* Style for error messages */
span.error {
    color: red;
    font-weight: bold;
}

/* Style for the "Login here" link */
p.login-link {
    text-align: center;
    margin-top: 10px;
}

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

/* Add styling for other input fields (phone_number, first_name, etc.) as needed */

    </style>
    <title>Sign Up</title>
    <!-- Include your CSS styling here -->
</head>
<body>
<div class="navbar">
        <a href="../regularui/regularui_home.html">Home</a>
        <a href="../login_signup/regular_bookavisit.html" class="book-visit">Book a Visit</a>
        <a href="#">Artworks</a>
        <a href="#">Exhibition</a>
        <a href="../bidding/regular_bidding.php">Bidding</a>
        <a href="../arscanner/arscanner.html">AR Scanner</a>
       
    </div>
    <h2>Sign Up</h2>
    <p>Please fill this form to create an account.</p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
   
   
    <div>
        <label>First Name</label>
        <input type="text" name="first_name" value="<?php echo $first_name; ?>">
    </div>
    <div>
        <label>Middle Name</label>
        <input type="text" name="middle_name" value="<?php echo $middle_name; ?>">
    </div>
    <div>
        <label>Last Name</label>
        <input type="text" name="last_name" value="<?php echo $last_name; ?>">
    </div>

    <div>
        <label>Phone Number</label>
        <input type="text" name="phone_number" value="<?php echo $phone_number; ?>">
    </div>
    <div>
        <label>Email Address</label>
        <input type="email" name="email_address" value="<?php echo $email_address; ?>">
        <span><?php echo $email_err; ?></span>
    </div>
    <div>
        <label>Permanent Address</label>
        <input type="text" name="permanent_address" value="<?php echo $permanent_address; ?>">
    </div>
    <div>
        <label>Username</label>
        <input type="text" name="username" value="<?php echo $username; ?>">
        <span><?php echo $username_err; ?></span>
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" value="<?php echo $password; ?>">
        <span><?php echo $password_err; ?></span>
    </div>
    <div>
        <input type="submit" value="Sign Up">
    </div>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</form>
</body>
</html>
