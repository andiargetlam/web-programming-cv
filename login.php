<?php
// Database credentials
$hostname = 'your_hostname';
$username = 'your_username';
$password = 'your_password';
$database = 'your_database';

// Establish database connection
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailUsername = $_POST['user_email'];
    $password = $_POST['user_pass'];

    // Validate user credentials
    $query = "SELECT * FROM users WHERE (email = ? OR username = ?) AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $emailUsername, $emailUsername, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Credentials are valid, redirect to a different page or grant access
        header("Location: welcome.php");
        exit();
    } else {
        // Invalid credentials, display error message
        $error = "Invalid email/username or password.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login to your Account</title>
</head>
<body>
    <h1>Login to your Account</h1>
    <form method="post" action="login.php">
        <label for="email">Email / Username:</label>
        <input type="text" id="email" name="user_email" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="user_pass" required><br><br>
        
        <label for="remember">Remember me:</label>
        <input type="checkbox" id="remember" name="remember"><br><br>
        
        <input type="submit" value="Login">
        
        <?php if (isset($error)) { ?>
            <p><?php echo $error; ?></p>
        <?php } ?>
    </form>
    
    <br>
    <a href="forgot_password.php">Forgot Password?</a>
</body>
</html>
