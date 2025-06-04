<?php

session_start();
include("../db_connect.php");
$conn = OpenCon();

if(isset($_SESSION['mySession'])) {
    $user_id = $_SESSION['mySession'];

    $result = mysqli_query($conn, "SELECT * FROM student WHERE studentID = '$user_id'");

    while ($row = mysqli_fetch_array($result)) {
        $username = $row['fullName'];
        $studentID = $row['studentID'];
        $supervisorID = $row['supervisorID'];
    }
}
else {
    header('Location:../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Management</title>
    <link rel="stylesheet" href="../css/mtg-styles.css">
    <link rel="stylesheet" href="../../css/styles.css">

</head>
<body>
<header>
        <h1>FYP Management Portal</h1>
        <form action="search_student.php" method="GET" class="search">
          <input type="text" name="query" placeholder="Search..." required>
          <button type="submit">Search</button>
        </form>

        <div class="user-actions">
            <span>Hi, <?php echo $username?></span>
        </div>
    </header>
    <nav>
        <a href="studentMain.php">Home</a>
        <a href="resource.php">Resource</a>
        <a href="https://clic.mmu.edu.my">CLIC</a>
        <a href="https://ebwise.mmu.edu.my">eBwise</a>
        <a href="contributors.php">Contributors</a>
        <a href="student-feedback.php">Feedback</a>
        <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>

    </nav>

    <main>
        <h2>Meeting Management</h2>
        <p>Schedule, manage, and track meetings with your supervisor for your Final Year Project.</p>
        <form action="meetingInsert.php" method="POST" class="meeting-form">
            <label for="studentID">Student ID:</label>
            <input type="text" id="studentID" name="studentID" value="<?php echo $studentID; ?>" readonly>

            <label for="supervisorID">Supervisor ID:</label>
            <input type="text" id="supervisorID" name="supervisorID" value="<?php echo $supervisorID; ?>" readonly>

            <label for="meeting-title">Meeting Title:</label>
            <input type="text" id="meeting-title" name="meeting-title" placeholder="Enter the meeting title" required>

            <label for="meeting-date">Meeting Date:</label>
            <input type="date" id="meeting-date" name="meeting-date" required>

            <label for="meeting-time">Meeting Time:</label>
            <input type="time" id="meeting-time" name="meeting-time" required>

            <label for="meeting-platform">Meeting Platform:</label>
            <select id="meeting-platform" name="meeting-platform" required>
                <option value="" disabled selected>Select a platform</option>
                <option value="zoom">Zoom</option>
                <option value="google-meet">Google Meet</option>
                <option value="ms-teams">Microsoft Teams</option>
                <option value="other">Other</option>
            </select>

            <label for="meeting-description">Description:</label>
            <textarea id="meeting-description" name="meeting-description" placeholder="Provide details about the meeting" rows="5"></textarea>

            <button type="submit">Schedule Meeting</button>
        </form>

        <section class="meeting-list">
            <h3>Your Scheduled Meetings</h3>
            <ul>
            <?php            
                    $sql = "SELECT * FROM meeting WHERE studentID = $user_id" ;
                    $result = mysqli_query($conn, $sql);

                    if ($result->num_rows > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                        echo "<li><strong>{$row['meetingTitle']}</strong> - {$row['meetingDate']}, {$row['meetingTime']}, {$row['meetingPlatform']}</li>";
                    }
                    } else {
                        echo "No meeting scheduled";
                    }
                    mysqli_close($conn);
                ?>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>
</body>
</html>
