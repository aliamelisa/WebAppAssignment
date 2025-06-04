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

$sql = "SELECT * FROM supervisor WHERE supervisorID= '$supervisorID' ";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Retrieve proposal details
$proposal_sql = "SELECT supervisorID, studentID, specialization, projectTitle, projectType, 
filename, proposalStatus FROM proposal WHERE studentID = '$studID'";
$proposal_result = mysqli_query($conn, $proposal_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal Submission</title>
    <link rel="stylesheet" href="../../css/proposal-style.css">    
    <link rel="stylesheet" href="../../css/styles.css">
</head>

<body>
    <header>
        <h1>Final Year Project Management</h1>

        <form action="search_student.php" method="GET" class="search">
            <input type="text" name="query" placeholder="Search..." required>
            <button type="submit">Search</button>
        </form>

        <div class="user-actions">
            <span>Hi, <?php echo htmlspecialchars($username); ?>!</span>
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
        <h2>Your Proposal Status</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Supervisor ID</th>
                    <th>Student ID</th>
                    <th>Specialization</th>
                    <th>Project Title</th>
                    <th>Project Type</th>
                    <th>Filename</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                if (mysqli_num_rows($proposal_result) > 0) {
                    while ($proposal = mysqli_fetch_assoc($proposal_result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($proposal['supervisorID']) . "</td>";
                        echo "<td>" . htmlspecialchars($proposal['studentID']) . "</td>";
                        echo "<td>" . htmlspecialchars($proposal['specialization']) . "</td>";
                        echo "<td>" . htmlspecialchars($proposal['projectTitle']) . "</td>";
                        echo "<td>" . htmlspecialchars($proposal['projectType']) . "</td>";
                        echo "<td>" . htmlspecialchars($proposal['filename']) . "</td>";
                        echo "<td>" . htmlspecialchars($proposal['proposalStatus']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No proposal submitted yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Submit Your Final Year Project Proposal</h2>
        <p>Please fill out the form below to submit your Final Year Project details.</p>

        <form action="upload.php" method="POST" class="registration-form" enctype="multipart/form-data">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($username); ?>" readonly />

            <label for="student-id">Student ID:</label>
            <input type="text" id="student-id" name="student-id" value="<?php echo htmlspecialchars($studID); ?>" readonly>

            <label for="specialisation">Course Specialisation:</label>
            <select id="specialisation" name="specialisation" required>
                <option value="" disabled selected>Select your course specialisation</option>
                <option value="data-science">Data Science</option>
                <option value="software-engineering">Software Engineering</option>
                <option value="cybersecurity">Cybersecurity</option>
                <option value="game-development">Game Development</option>
            </select>

            <label for="supervisor">Supervisor Name:</label>
            <input type="text" id="supervisor" name="supervisor" value="<?php echo htmlspecialchars($row['fullName']); ?>" readonly>

            <label for="supervisor-id">Supervisor ID:</label>
            <input type="text" id="supervisor-id" name="supervisor-id" value="<?php echo htmlspecialchars($supervisorID); ?>" readonly>

            <label for="project-title">Project Title:</label>
            <input type="text" id="project-title" name="project-title" placeholder="Enter your project title" required>

            <label for="project-type">Project Type:</label>
            <input type="text" id="project-type" name="project-type" placeholder="Enter your project type" required>

            <label for="project-file">Upload Project Proposal (PDF only):</label>
            <input type="file" id="project-file" name="project-file" accept=".pdf" required>

            <button type="reset">Reset</button> 
            <button type="submit" name="submit">Submit</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>
</body>
</html>
