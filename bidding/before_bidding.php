<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
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
<body>
<div class="navbar">
        <a href="../login_signup/user_home.html">Home</a>
        <a href="../bookavisit.html">Book a Visit</a>
        <a href="#">Artworks</a>
        <a href="#">Exhibition</a>
        <a href="../bidding/user_bidding.php">Bidding</a>
        <a href="../arscanner/user_scanner.html">AR Scanner</a>

        <div class="logout-container">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>
    <h2>Login Verification for Bidding</h2>
    <form action="login_process.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        
        <input type="submit" value="Login">
    </form>
</body>
</html>
