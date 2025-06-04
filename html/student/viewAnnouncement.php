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
    <title>View Announcement</title>
    <link rel="stylesheet" href="../../css/adminAnnouncement.css" />
</head>
<body>
    <header>
        <h1>Final Year Project Management</h1>
        <div class="user-actions">
        <span>Hi, <?php echo $username?></span>
        </div>
    </header>
    <nav>
    <a href="studentMain.php">Home</a>
    <a href="https://clic.mmu.edu.my">CLIC</a>
    <a href="https://ebwise.mmu.edu.my">eBwise</a>
    <a href="contributors.php">Contributors</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </nav>

    <div class='announcement-details'>
        <?php

        if (isset($_GET['id'])) {
            $announcementID = intval($_GET['id']);
            $sql = "SELECT announcementID, title, target, announceBy, content, datePosted FROM announcement WHERE announcementID = $announcementID";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                echo "<h2>".$row['title']."</h2>
                        <p><strong>To:</strong> ".$row['target']."</p>
                        <p><strong>By:</strong> ".$row['announceBy']."</p>
                        <p><strong>Date Posted:</strong> ".$row['datePosted']."</p>
                        <p><strong>Content:</strong> ".$row['content']."</p>";
            } else {
                echo "<p>No announcement found.</p>";
            }
        } else {
            echo "<p>Invalid announcement ID.</p>";
        }

        mysqli_close($conn);
        ?>
    </div>
    <footer>© 2024 FCI FYP Management System. All rights reserved.</footer>
</body>
</html>
