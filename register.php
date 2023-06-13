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
    $email = $_POST['email'];
    $username = $_POST['username'];
    $fullName = $_POST['full_name'];
    $phoneNumber = $_POST['phone_number'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    // Insert user data into the database
    $query = "INSERT INTO users (email, username, full_name, phone_number, dob, gender) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $email, $username, $fullName, $phoneNumber, $dob, $gender);
    $stmt->execute();

    // Redirect to a success page or perform other actions
    header("Location: registration_success.php");
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register your Account</title>
</head>
<body>
    <h1>Register your Account</h1>
    <form method="post" action="register.php">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required><br><br>
        
        <label for="phone_number">Phone Number:</label>
        <input type="tel" id="phone_number" name="phone_number" required><br><br>
        
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br><br>
        
        <label for="gender">Gender:</label>
        <input type="radio" id="gender_male" name="gender" value="Male" required>
        <label for="gender_male">Male</label>
        <input type="radio" id="gender_female" name="gender" value="Female" required>
        <label for="gender_female">Female</label><br><br>
        
        <input type="checkbox" id="eula" name="eula" required>
        <label for="eula">Agree to EULA</label><br><br>
        
        <input type="submit" value="Register">
        <input type="reset" value="Reset">
    </form>
</body>
</html>
