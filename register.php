<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('db_connect.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if (mysqli_query($conn, $query)) {
        header("Location: login.php");
    } else {
        $error = "Error registering user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Link to register-specific CSS -->
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        
        <form method="post" action="register.php">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br><br>
            
            <input type="submit" value="Register"><br><br>
        </form>

        <!-- Display error message if registration fails -->
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

        <!-- Link to login page -->
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
