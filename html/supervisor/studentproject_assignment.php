<?php
session_start();
include("../db_connect.php");
$conn = OpenCon();

// Check if the user is logged in
if (!isset($_SESSION['mySession'])) {
    header('Location: ../login.php');
    exit();
}

$supervisorID = $_SESSION['mySession'];

// Fetch supervisor's full name
$result = mysqli_query($conn, "SELECT fullName FROM supervisor WHERE supervisorID = '$supervisorID'");
$row = mysqli_fetch_array($result);
$supervisorName = $row['fullName'];

// Fetch students who are not assigned to any project and whose supervisor is the logged-in supervisor
$query_student = "SELECT studentID, fullName FROM student 
                  WHERE supervisorID is NULL";
$result_student = mysqli_query($conn, $query_student);

// Fetch projects where studentID is NULL (unassigned) and the supervisor is the logged-in supervisor
$query_project = "SELECT projectID, projectTitle FROM project WHERE studentID IS NULL AND supervisorID = '$supervisorID'";
$result_project = mysqli_query($conn, $query_project);

// Handle the project assignment logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentID = $_POST['student-id'];
    $projectID = $_POST['project-id'];

    // Assign the student to the project
    $assign_query = "UPDATE project SET studentID = ?, progress = 0, milestone = 'Not Started', completionStatus = 'In Progress' WHERE projectID = ?";
    $stmt = $conn->prepare($assign_query);
    $stmt->bind_param("ii", $studentID, $projectID);

    if ($stmt->execute()) {
        // Update the proposal table with studentID
        $update_proposal_query = "UPDATE proposal SET studentID = ? WHERE projectTitle = (SELECT projectTitle FROM project WHERE projectID = ?)";
        $stmt_proposal = $conn->prepare($update_proposal_query);
        $stmt_proposal->bind_param("ii", $studentID, $projectID);
        $stmt_proposal->execute();
        $stmt_proposal->close();

        // Update the student table with supervisorID
        $update_student_query = "UPDATE student SET supervisorID = ? WHERE studentID = ?";
        $stmt_student = $conn->prepare($update_student_query);
        $stmt_student->bind_param("si", $supervisorID, $studentID);
        $stmt_student->execute();
        $stmt_student->close();

        echo "<script>alert('Student assigned to project successfully.'); window.location.href='studentproject_assignment.php';</script>";
    } else {
        echo "<script>alert('Error assigning student to project.');</script>";
    }
    $stmt->close();
}

// Fetch assigned projects for the logged-in supervisor
$query_assigned = "SELECT s.fullName, p.projectTitle, p.progress, p.milestone, p.completionStatus 
                   FROM project p 
                   LEFT JOIN student s ON p.studentID = s.studentID 
                   WHERE p.supervisorID = '$supervisorID' AND p.studentID IS NOT NULL";
$result_assigned = mysqli_query($conn, $query_assigned);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student-to-Project Assignment</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <header>
        <h1>Final Year Project Management</h1>
        <form action="search_sv.php" method="GET" class="search">
            <input type="text" name="query" placeholder="Search..." required>
            <button type="submit">Search</button>
        </form>
        <div class="user-actions">
            <span>Hi, <?php echo htmlspecialchars($supervisorName); ?>!</span>
        </div>
    </header>
    <nav>
    <a href="supervisorMain.php">Home</a>
        <a href="resource.php">Resource</a>
        <a href="https://clic.mmu.edu.my">CLIC</a>
        <a href="https://ebwise.mmu.edu.my">eBwise</a>
        <a href="contributors.php">Contributors</a>
        <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </nav>

    <section id="assign">
        <h2>Assign a Student to a Project</h2>
        <form action="studentproject_assignment.php" method="POST">
            <label for="student-id">Select Student:</label>
            <select name="student-id" id="student-id" required>
                <option value="" disabled selected>Select Student</option>
                <?php while ($row = mysqli_fetch_assoc($result_student)) { ?>
                    <option value="<?= $row['studentID']; ?>"><?= $row['fullName']; ?></option>
                <?php } ?>
            </select><br><br>

            <label for="project-id">Select Project:</label>
            <select name="project-id" id="project-id" required>
                <option value="" disabled selected>Select Project</option>
                <?php while ($row = mysqli_fetch_assoc($result_project)) { ?>
                    <option value="<?= $row['projectID']; ?>"><?= $row['projectTitle']; ?></option>
                <?php } ?>
            </select><br><br>

            <button type="submit">Assign Student to Project</button>
        </form>
    </section>

    <section id="view-assignments">
        <h2>Assigned Projects</h2>
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Project</th>
                    <th>Progress</th>
                    <th>Milestone</th>
                    <th>Completion Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display the assigned projects for the logged-in supervisor
                while ($row = mysqli_fetch_assoc($result_assigned)) {
                    echo "<tr>
                            <td>{$row['fullName']}</td>
                            <td>{$row['projectTitle']}</td>
                            <td>{$row['progress']}%</td>
                            <td>{$row['milestone']}</td>
                            <td>{$row['completionStatus']}</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>
</body>
</html>
