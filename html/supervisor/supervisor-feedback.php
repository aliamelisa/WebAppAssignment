<?php
session_start();
include("../db_connect.php");
$conn = OpenCon();

// Check if the user is logged in
if(isset($_SESSION['mySession'])) {
    $user_id = $_SESSION['mySession'];

    // Fetch supervisor details
    $result = mysqli_query($conn, "SELECT * FROM supervisor WHERE supervisorID = '$user_id'");
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $username = $row['fullName'];
        $supervisorID = $row['supervisorID'];
    } else {
        // Redirect if not a supervisor
        header('Location: ../login.php');
        exit();
    }
} else {
    header('Location: ../login.php');
    exit();
}

// Handle feedback submission
if(isset($_POST['submit'])) {
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);

    // Insert query (studentID is NULL)
    $query = "INSERT INTO feedback (studentID, supervisorID, rate, comments) 
              VALUES (NULL, '$supervisorID', '$rating', '$comments')";

    if(mysqli_query($conn, $query)) {
        $success_message = "Feedback submitted successfully!";
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Feedback</title>
    <link rel="stylesheet" href="../../css/feedback-styles.css">
</head>
<body>
    <header>
        <h1>Final Year Project Management</h1>

        <form action="search_sv.php" method="GET" class="search">
            <input type="text" name="query" placeholder="Search..." required>
            <button type="submit">Search</button>
        </form>
        
        <div class="user-actions">
            <img src="https://via.placeholder.com/40" alt="User Icon" title="User">
            <span>Hi, <?php echo $username; ?></span>
        </div>
    </header>

    <nav>
        <a href="supervisorMain.php">Home</a>
        <a href="resource.php">Resource</a>
        <a href="contributors.php">Contributors</a>
        <a href="supervisor-feedback.php">Feedback</a>
        <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </nav>

    <main>
        <div class="feedback-form-container">
            <h1>Supervisor Feedback</h1>
            <h2>We Value Your Feedback</h2>
            <p>Please fill out the form below to help us improve.</p>

            <?php if(isset($success_message)) { echo "<p style='color: green;'>$success_message</p>"; } ?>
            <?php if(isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>

            <form method="POST" action="">
                <input type="hidden" name="supervisorID" value="<?php echo $supervisorID; ?>">

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

                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
    </main>
</body>
</html>
