<?php
session_start();
include("../db_connect.php");
$conn = OpenCon();

if (!isset($_SESSION['mySession'])) {
    header('Location: ../login.php');
    exit();
}

$studentID = $_SESSION['mySession'];

// Fetch student details
$query_student = "SELECT fullName FROM student WHERE studentID = ?";
$stmt_student = $conn->prepare($query_student);
$stmt_student->bind_param("i", $studentID);
$stmt_student->execute();
$result_student = $stmt_student->get_result();
if ($row = $result_student->fetch_assoc()) {
    $username = $row['fullName'];
}
$stmt_student->close();

// Fetch detailed marks for the respective student
$query_marksheet = "SELECT projectProposal, presentation, report, grade FROM marksheet WHERE studentID = ?";
$stmt_marksheet = $conn->prepare($query_marksheet);
$stmt_marksheet->bind_param("i", $studentID);
$stmt_marksheet->execute();
$result_marksheet = $stmt_marksheet->get_result();
$marks = $result_marksheet->fetch_assoc(); // Fetch only one row since it's for a single student
$stmt_marksheet->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Marksheet</title>
    <link rel="stylesheet" href="../../css/mark-styles.css">
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
        <div class="marksheet-container">
            <h2>Project Marksheet</h2>
            <p>Below is the breakdown of your project evaluation.</p>
            <table class="marks-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($marks) { ?>
                        <tr>
                            <td>Project Proposal (20 marks)</td>
                            <td><?php echo htmlspecialchars($marks['projectProposal']); ?></td>
                        </tr>
                        <tr>
                            <td>Oral Presentation (20 marks)</td>
                            <td><?php echo htmlspecialchars($marks['presentation']); ?></td>
                        </tr>
                        <tr>
                            <td>Final Report (60 marks)</td>
                            <td><?php echo htmlspecialchars($marks['report']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Final Grade</strong></td>
                            <td><strong><?php echo htmlspecialchars($marks['grade']); ?></strong></td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td colspan="2">No marks available yet.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
