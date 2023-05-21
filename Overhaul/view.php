<?php
session_start();

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

// Retrieve the CV data from the database
$query = "SELECT * FROM cv_data ORDER BY id DESC LIMIT 1";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Extract the CV data
    $fullName = $row['full_name'];
    $dob = $row['dob'];
    $placeOfBirth = $row['place_of_birth'];
    $location = $row['location'];
    $email = $row['email'];
    $phoneNumber = $row['phone_number'];
    $lastSchool = $row['last_school'];
    $lastSchoolYear = $row['last_school_year'];
    $lastSchoolGraduated = $row['last_school_graduated'];
    $summary = $row['summary'];
    $skills = $row['skills'];
    // Retrieve the achievements from the database
    $achievementsQuery = "SELECT achievement, year FROM achievements WHERE cv_data_id = " . $row['id'];
    $achievementsResult = $conn->query($achievementsQuery);
    $achievements = array();
    while ($achievementRow = $achievementsResult->fetch_assoc()) {
        $achievements[] = $achievementRow;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>CV Preview</title>
    <style>
        /* CSS styles for CV layout */
        body {
            font-family: Arial, sans-serif;
        }
        .cv-section {
            margin-bottom: 20px;
        }
        .cv-section h2 {
            margin-bottom: 5px;
        }
        .cv-section p {
            margin: 0;
        }
        .cv-section ul {
            margin: 0;
            padding-left: 20px;
        }
        .cv-section ul li {
            list-style-type: disc;
        }
    </style>
</head>
<body>
    <div class="cv-section">
        <h2>Personal Information</h2>
        <p><strong>Full Name:</strong> <?php echo $fullName; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $dob; ?></p>
        <p><strong>Place of Birth:</strong> <?php echo $placeOfBirth; ?></p>
        <p><strong>Location:</strong> <?php echo $location; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Phone Number:</strong> <?php echo $phoneNumber; ?></p>
    </div>
    
    <div class="cv-section">
        <h2>Last School</h2>
        <p><strong>School Name:</strong> <?php echo $lastSchool; ?></p>
        <p><strong>Year:</strong> <?php echo $lastSchoolYear; ?></p>
        <p><strong>Graduated:</strong> <?php echo $lastSchoolGraduated; ?></p>
    </div>
    
    <div class="cv-section">
        <h2>Achievements & Certifications</h2>
          <ul>
            <?php foreach ($achievements as $achievement) : ?>
                <li><?php echo $achievement['achievement']; ?> (<?php echo $achievement['year']; ?>)</li>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <div class="cv-section">
        <h2>Summary</h2>
        <p><?php echo $summary; ?></p>
    </div>
    
    <div class="cv-section">
        <h2>Skills</h2>
        <p><?php echo $skills; ?></p>
    </div>

    <form method="post" action="save_cv.php">
        <input type="submit" name="save" value="Save">
    </form>

    <form method="post" action="download_cv.php">
        <input type="submit" name="download" value="Download">
    </form>
</body>
</html>

