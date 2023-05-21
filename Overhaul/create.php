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

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'];
    $dob = $_POST['dob'];
    $placeOfBirth = $_POST['place_of_birth'];
    $location = $_POST['location'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $lastSchool = $_POST['last_school'];
    $lastSchoolYear = $_POST['last_school_year'];
    $lastSchoolGraduated = $_POST['last_school_graduated'];
    $achievements = $_POST['achievement'];
    $achievementYears = $_POST['achievement_year'];
    $summary = $_POST['summary'];
    $skills = $_POST['skills'];

    // Insert CV data into the database
    $query = "INSERT INTO cv_data (full_name, dob, place_of_birth, location, email, phone_number, last_school, last_school_year, last_school_graduated, summary, skills) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssss", $fullName, $dob, $placeOfBirth, $location, $email, $phoneNumber, $lastSchool, $lastSchoolYear, $lastSchoolGraduated, $summary, $skills);
    $stmt->execute();
    $cvDataId = $stmt->insert_id; // Get the inserted CV data ID

    // Insert achievements into the database
    if (!empty($achievements)) {
        $achievementsCount = count($achievements);
        $achievementYearsCount = count($achievementYears);
        $count = min($achievementsCount, $achievementYearsCount);

        for ($i = 0; $i < $count; $i++) {
            $achievement = $achievements[$i];
            $achievementYear = $achievementYears[$i];

            $query = "INSERT INTO achievements (cv_data_id, achievement, year) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iss", $cvDataId, $achievement, $achievementYear);
            $stmt->execute();
        }
    }

    // Redirect to a success page or perform other actions
    header("Location: create_success.php");
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input your data to make your CV</title>
</head>
<body>
    <h1>Input your data to make your CV</h1>
    
    <form method="post" action="create.php">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required><br><br>
        
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br><br>
        
        <label for="place_of_birth">Place of Birth:</label>
        <input type="text" id="place_of_birth" name="place_of_birth" required><br><br>
        
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="phone_number">Phone Number:</label>
        <input type="tel" id="phone_number" name="phone_number" pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}" required><br><br>
        
        <label for="last_school">Last School:</label>
        <input type="text" id="last_school" name="last_school" required><br><br>
        
        <label for="last_school_year">Year of Last School:</label>
        <input type="text" id="last_school_year" name="last_school_year" required><br><br>
        
        <label for="last_school_graduated">Did you graduate from the last school?</label><br>
        <label for="graduated_yes">Yes</label>
        <input type="radio" id="graduated_yes" name="last_school_graduated" value="Yes" required>
        <label for="graduated_no">No</label>
        <input type="radio" id="graduated_no" name="last_school_graduated" value="No" required><br><br>
        
        <label>Achievement / Certification:</label>
        <input type="text" name="achievement[]" required>
        <label>Year:</label>
        <input type="text" name="achievement_year[]" required><br>
        
        <div id="additional_achievements"></div>
        <button type="button" onclick="addAchievement()">Add more</button><br><br>
        
        <label for="summary">Summary:</label><br>
        <textarea id="summary" name="summary" rows="4" cols="50" required></textarea><br><br>
        
        <label for="skills">Skills:</label><br>
        <textarea id="skills" name="skills" rows="4" cols="50" required></textarea><br><br>
        
        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
    </form>

    <script>
        // Function to add more achievement/certification fields
        function addAchievement() {
            var additionalAchievementDiv = document.getElementById('additional_achievements');
            var newAchievementInput = document.createElement('input');
            newAchievementInput.type = 'text';
            newAchievementInput.name = 'achievement[]';
            newAchievementInput.required = true;
            additionalAchievementDiv.appendChild(newAchievementInput);
            
            var newYearInput = document.createElement('input');
            newYearInput.type = 'text';
            newYearInput.name = 'achievement_year[]';
            newYearInput.required = true;
            additionalAchievementDiv.appendChild(newYearInput);
            
            additionalAchievementDiv.appendChild(document.createElement('br'));
        }
    </script>
</body>
</html>

