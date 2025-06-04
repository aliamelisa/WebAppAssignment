<?php

session_start();
include("../db_connect.php");
$conn = OpenCon();

if(isset($_SESSION['mySession'])) {
    $user_id = $_SESSION['mySession'];

    $result = mysqli_query($conn, "SELECT * FROM student WHERE studentID = '$user_id'");

    while ($row = mysqli_fetch_array($result)) {
        $username = $row['fullName'];
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
    <title>Main Page</title>
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
        <h2>Project Progress</h2> 

        <table id='student'>
            <thead>
            <tr>
                <th>Project ID</th>
                <th>Project Title</th>
                <th>Progress</th>
                <th>Milestone</th>
                <th>Comment</th>
                <th>Completion status</th>
                <th colspan='2'>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $sql = "SELECT * FROM project WHERE studentID = '$user_id'";

                $result = mysqli_query($conn, $sql);
                
                if ($result && mysqli_num_rows($result) > 0) { 
                    while ($row = mysqli_fetch_assoc($result)) {
                        $projectID = $row['projectID'];
                        $projectTitle = $row['projectTitle'];
                        $progress = $row['progress'];
                        $comment = $row['comment'];
                        $milestone = $row['milestone'];
                        $completionStatus = $row['completionStatus'];
                
                        echo "<tr>";
                        echo "<td>".$projectID."</td>";
                        echo "<td>".$projectTitle."</td>";
                        echo "<td>".$progress."</td>";
                        echo "<td>".$milestone."</td>";
                        echo "<td>".$comment."</td>";
                        echo "<td>".$completionStatus."</td>";
                        echo "<td>
                                <span id='updatebutton'>
                                <a href='updateProgress.php?id=".$row['studentID']."'>Update</a>
                                </span>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Proposal is not approved yet.</td></tr>";
                }
                
                CloseCon($conn);
                ?>
            </tbody>
            </table>
    </main>
    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>
</body>
</html>
