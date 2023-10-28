<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
        <a href="../regularui/regularui_home.html">Home</a>
        <a href="../login_signup/regular_bookavisit.html" class="book-visit">Book a Visit</a>
        <a href="#">Artworks</a>
        <a href="#">Exhibition</a>
        <a href="../bidding/regular_bidding.php">Bidding</a>
        <a href="../arscanner/arscanner.html">AR Scanner</a>
       
    </div>
    <h2>Login</h2>
    <form action="user_home.html" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Login">
    </form>
    
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
</body>
</html>
