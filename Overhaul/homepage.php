<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $isLoggedIn = true; // User is logged in
} else {
    $isLoggedIn = false; // User is not logged in
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CV Generator</title>
</head>
<body>
    <h1>CV Generator</h1>
    
    <?php if (!$isLoggedIn) { ?>
        <!-- Display login and register buttons if the user is not logged in -->
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php } else { ?>
        <!-- Display create and view CV buttons if the user is logged in -->
        <a href="create_cv.php">Create</a>
        <a href="view_cv.php">View CV</a>
    <?php } ?>
</body>
</html>
