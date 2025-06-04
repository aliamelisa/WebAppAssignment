<?php

session_start();
include("../db_connect.php");
$conn = OpenCon();

if(isset($_SESSION['mySession'])) {
    $user_id = $_SESSION['mySession'];

    $result = mysqli_query($conn, "SELECT * FROM student WHERE studentID = '$user_id'");

    while ($row = mysqli_fetch_array($result)) {
        $username = $row['fullName'];
        $studID = $row['studentID'];
        $supervisorID = $row['supervisorID'];
    }
}
else {
    header('Location:../login.php');
    exit();
}

$sql = "SELECT * FROM meeting WHERE supervisorID= '$supervisorID' AND studentID='$studID' ORDER BY meetingDate DESC LIMIT 1";
$result = $conn->query($sql);
$meeting = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Logs</title>
    <link rel="stylesheet" href="../../css/mtg-styles.css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector(".meeting-form");
        const fileInput = document.getElementById("meeting-log");

        form.addEventListener("submit", function (event) {
            const file = fileInput.files[0];

        if (!file || file.type !== "application/pdf") {
            alert("Only PDF files are allowed.");
            event.preventDefault();
        }
    });
});
    </script>
</head>
<body>
    <header>
        <h1>Final Year Project Management</h1>

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
        <h2>Meeting Logs</h2>
        <p>Insert details of the meeting with your supervisor.</p>
        <form action="meetinglogsInsert.php" method="POST" class="meeting-form">

            <label for="meetingID">Meeting ID:</label>
            <input type="text" id="meetingID" name="meetingID" value="<?php echo htmlspecialchars($meeting['meetingID']); ?>" readonly>

            <label for="superviorID">Supervisor ID:</label>
            <input type="text" id="supervisorID" name="supervisorID" value="<?php echo htmlspecialchars($supervisorID); ?>" readonly>

            <label for="studentID">Student ID:</label>
            <input type="text" id="studentID" name="studentID" value="<?php echo htmlspecialchars($studID); ?>" readonly>

            <label for="meeting-log">Meeting Log:</label>
            <input type="file" id="meeting-log" name="meeting-log" accept=".pdf" required>

            <button type="submit">Submit Form</button>
        </form>

    </main>

    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>
</body>
</html>
