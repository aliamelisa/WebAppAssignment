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

// Fetch projects supervised by the logged-in supervisor
$query_projects = "SELECT projectID, projectTitle, studentID, progress, milestone, comment, completionStatus 
                   FROM project 
                   WHERE supervisorID = ?";
$stmt = $conn->prepare($query_projects);
$stmt->bind_param("i", $supervisorID);
$stmt->execute();
$result_projects = $stmt->get_result();

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['project-id'], $_POST['comment'])) {
        $projectID = $_POST['project-id'];
        $comment = trim($_POST['comment']);

        if (!empty($comment)) {
            $update_query = "UPDATE project SET comment = ? WHERE projectID = ? AND supervisorID = ?";
            $stmt_update = $conn->prepare($update_query);
            $stmt_update->bind_param("sii", $comment, $projectID, $supervisorID);
            $stmt_update->execute();
            $stmt_update->close();
            echo "<script>alert('Comment updated successfully.'); window.location.href='supervisorProjectPlanning.php';</script>";
        } else {
            echo "<script>alert('Comment cannot be empty.');</script>";
        }
    }

    // Handle completion status update
    if (isset($_POST['project-id-status'], $_POST['completion-status'])) {
        $projectID = $_POST['project-id-status'];
        $completionStatus = $_POST['completion-status'];

        $update_status_query = "UPDATE project SET completionStatus = ? WHERE projectID = ? AND supervisorID = ?";
        $stmt_status = $conn->prepare($update_status_query);
        $stmt_status->bind_param("sii", $completionStatus, $projectID, $supervisorID);
        $stmt_status->execute();
        $stmt_status->close();

        echo "<script>alert('Completion status updated successfully.'); window.location.href='supervisorProjectPlanning.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Students Project Planning</title>
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
        <a href="supervisor-feedback.php">Feedback</a>
        <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </nav>

    <section id="view-projects">
        <h2>Supervised Projects</h2>
        <table>
            <thead>
                <tr>
                    <th>Project Title</th>
                    <th>Student ID</th>
                    <th>Progress</th>
                    <th>Milestone</th>
                    <th>Comment</th>
                    <th>Completion Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $result_projects->data_seek(0);
                while ($row = $result_projects->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['projectTitle']); ?></td>
                        <td><?php echo htmlspecialchars($row['studentID']); ?></td>
                        <td><?php echo htmlspecialchars($row['progress']) . "%"; ?></td>
                        <td><?php echo htmlspecialchars($row['milestone']); ?></td>
                        <td><?php echo htmlspecialchars($row['comment']); ?></td>
                        <td><?php echo htmlspecialchars($row['completionStatus']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>

    <section id="add-comment">
        <h2>Add Comment to Project</h2>
        <form action="supervisorProjectPlanning.php" method="POST">
            <label for="project-id">Select Project:</label>
            <select name="project-id" id="project-id" required>
                <option value="" disabled selected>Select Project</option>
                <?php
                $result_projects->data_seek(0);
                while ($row = $result_projects->fetch_assoc()) {
                ?>
                    <option value="<?= $row['projectID']; ?>"><?= htmlspecialchars($row['projectTitle']); ?></option>
                <?php } ?>
            </select><br><br>

            <label for="comment">Comment:</label><br>
            <textarea name="comment" id="comment" rows="4" cols="50" required></textarea><br><br>

            <button type="submit">Submit Comment</button>
        </form>
    </section>

    <section id="update-status">
        <h2>Update Completion Status</h2>
        <form action="supervisorProjectPlanning.php" method="POST">
            <label for="project-id-status">Select Project:</label>
            <select name="project-id-status" id="project-id-status" required>
                <option value="" disabled selected>Select Project</option>
                <?php
                $result_projects->data_seek(0);
                while ($row = $result_projects->fetch_assoc()) {
                ?>
                    <option value="<?= $row['projectID']; ?>"><?= htmlspecialchars($row['projectTitle']); ?></option>
                <?php } ?>
            </select><br><br>

            <label for="completion-status">Completion Status:</label>
            <select name="completion-status" id="completion-status" required>
                <option value="Not Started">Not Started</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select><br><br>

            <button type="submit">Update Status</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>

</body>

</html>
