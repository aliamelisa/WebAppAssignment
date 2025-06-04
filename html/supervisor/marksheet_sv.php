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

// Fetch students under the logged-in supervisor
$students = [];
$stmt = $conn->prepare("SELECT student.studentID, student.fullName FROM student 
                        JOIN project ON student.studentID = project.studentID 
                        WHERE project.supervisorID = ?");
$stmt->bind_param("i", $supervisorID);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}
$stmt->close();

$studentID = isset($_POST['student-id']) ? $_POST['student-id'] : '';
$studentName = "";

// Fetch student details if a student is selected
if (!empty($studentID)) {
    $stmt = $conn->prepare("SELECT fullName FROM student WHERE studentID = ?");
    $stmt->bind_param("i", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $studentName = $row['fullName'];
    }
    $stmt->close();
}

// Function to determine grade based on total marks
function calculateGrade($totalMarks) {
    if ($totalMarks >= 80) return 'A';
    if ($totalMarks >= 70) return 'B';
    if ($totalMarks >= 60) return 'C';
    if ($totalMarks >= 50) return 'D';
    return 'F';
}

// Handle marks submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($studentID)) {
    $proposalGrade = $_POST['grade-proposal'];
    $midtermGrade = $_POST['grade-midterm'];
    $finalReportGrade = $_POST['grade-final-report'];
    $totalMarks = $proposalGrade + $midtermGrade + $finalReportGrade;
    $finalGrade = calculateGrade($totalMarks);

    // Insert or update marks in the database
    $subjectCode = "FYP01"; // Set subject code

$stmt = $conn->prepare("INSERT INTO marksheet (supervisorID, studentID, subjectCode, projectProposal, presentation, report, grade) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiiis", 
    $supervisorID, $studentID, $subjectCode, $proposalGrade, $midtermGrade, $finalReportGrade, $finalGrade
);
$stmt->execute();
$stmt->close();


    $_SESSION['marksheet_saved'] = true;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FYP Assessment Marksheet</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <header>
        <h1>Final Year Project Management</h1>
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

    <section id="marksheet">
        <h2>Student Marksheet</h2>
        <form action="" method="POST">
            <fieldset>
                <legend>Student Information</legend>
                <label for="student-id">Student Name:</label>
                <select id="student-id" name="student-id" required>
                    <option value="">Select Student</option>
                    <?php foreach ($students as $student) : ?>
                        <option value="<?php echo $student['studentID']; ?>" <?php echo ($studentID == $student['studentID']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($student['fullName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>
            </fieldset>

            <fieldset>
                <legend>Grades</legend>
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Project Proposal (20%)</td>
                            <td><input type="number" name="grade-proposal" required min="0" max="20"></td>
                        </tr>
                        <tr>
                            <td>Oral Presentation (20%)</td>
                            <td><input type="number" name="grade-midterm" required min="0" max="20"></td>
                        </tr>
                        <tr>
                            <td>Final Report (60%)</td>
                            <td><input type="number" name="grade-final-report" required min="0" max="60"></td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
            <button type="submit">Submit Marksheet</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>

    <?php if (isset($_SESSION['marksheet_saved']) && $_SESSION['marksheet_saved'] === true): ?>
        <script type="text/javascript">
            alert("Marksheet saved successfully!");
        </script>
        <?php unset($_SESSION['marksheet_saved']); ?>
    <?php endif; ?>
</body>
</html>
