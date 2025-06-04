<?php
session_start();
include("../db_connect.php");
$conn = OpenCon();

// Variable to store the success message
$successMessage = '';
$errorMessage = '';

if (isset($_SESSION['mySession'])) {
    $user_id = $_SESSION['mySession'];

    // Fetch the student's full name from the database
    $result = mysqli_query($conn, "SELECT * FROM student WHERE studentID = '$user_id'");

    while ($row = mysqli_fetch_array($result)) {
        $username = $row['fullName'];
    }

    // Check if the form is submitted via POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and assign form inputs to variables
        $studentID = $user_id; // Assuming the session contains the logged-in student's ID
        $rating = mysqli_real_escape_string($conn, $_POST['rating']);
        $comments = mysqli_real_escape_string($conn, $_POST['comments']);

        // Ensure that none of the fields are empty before inserting
        if (!empty($rating) && !empty($comments)) {
            // Check if the supervisorID exists in the session, otherwise set it to NULL
            $supervisorID = isset($_SESSION['supervisorID']) ? $_SESSION['supervisorID'] : NULL;

            // Insert data into the feedback table (exclude feedbackID as it auto-increments)
            $sql = "INSERT INTO feedback (studentID, supervisorID, comments, rate) 
                    VALUES ('$studentID', " . ($supervisorID === NULL ? 'NULL' : "'$supervisorID'") . ", '$comments', '$rating')";

            if (mysqli_query($conn, $sql)) {
                // Feedback successfully saved
                $successMessage = "Thank you for your feedback! It has been successfully submitted.";
            } else {
                // Error inserting data
                $errorMessage = "There was an error while submitting your feedback. Please try again.";
            }
        } else {
            $errorMessage = "All fields are required. Please fill out all fields.";
        }
    }
} else {
    header('Location:../login.php');
    exit();
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="../../css/feedback-styles.css"> 
</head>
<body>
    <header>
        <h1>Final Year Project Management</h1>
    
        <form action="search_student.php" method="GET" class="search">
            <input type="text" name="query" placeholder="Search..." required>
            <button type="submit">Search</button>
        </form>
    
        <div class="user-actions">
            <span>Hi, <?php echo $username; ?></span>
        </div>
    </header>

    <nav>
        <a href="studentMain.php">Home</a>
        <a href="resource.php">Resource</a>
        <a href="contributors.php">Contributors</a>
        <a href="student-feedback.php">Feedback</a>
        <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </nav>
    
    <main>
        <div class="feedback-form-container">
            <h1>Feedback Form</h1>
            <h2>We Value Your Feedback</h2>
            <p>Please fill out the form below to help us improve.</p>
            
            <?php
            // Display the success message if set
            if (!empty($successMessage)) {
                echo "<div class='success-message'>$successMessage</div>";
            }

            // Display the error message if set
            if (!empty($errorMessage)) {
                echo "<div class='error-message'>$errorMessage</div>";
            }
            ?>

            <form id="feedback-form" method="POST">
                <div class="form-group">
                    <label for="rating">Rate your experience:</label>
                    <select id="rating" name="rating" required>
    <option value="">Select an option</option>
    <option value="4">Excellent</option>
    <option value="3">Good</option>
    <option value="2">Average</option>
    <option value="1">Poor</option>
</select>
                </div>
                <div class="form-group">
                    <label for="comments">Comments:</label>
                    <textarea id="comments" name="comments" rows="4" placeholder="Write your comment here..." required></textarea>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </main>
</body>
</html>
