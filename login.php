<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('db_connect.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        header("Location: create_quiz.php");
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link to login-specific CSS -->
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        
        <form method="post" action="login.php">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br><br>
            
            <input type="submit" value="Login"><br><br>
        </form>

        <!-- Display error message if login fails -->
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

        <!-- Link to registration page -->
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>