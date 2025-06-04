<?php

session_start();
include("../db_connect.php");
$conn = OpenCon();

if(isset($_SESSION['mySession'])) {
    $user_id = $_SESSION['mySession'];

    $result = mysqli_query($conn, "SELECT * FROM supervisor WHERE supervisorID = '$user_id'");

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
    <link rel="stylesheet" href="../../css/meetinglogsview.css">
    <link rel="stylesheet" href="../../css/styles.css">
    <title>View Meeting Log</title>
</head>
<body>
<header>
        <h1>Final Year Project Management</h1>

        <form action="search_sv.php" method="GET" class="search">
            <input type="text" name="query" placeholder="Search..." required>
            <button type="submit">Search</button>
        </form>

        <div class="user-actions">
        <span>Hi, <?php echo htmlspecialchars($username); ?>!</span>
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
    <h2 style="text-align:center;">Meeting Logs</h2>
<table>
        <thead>
            <tr>
                <th>#</th>
                <th>StudentID</th>
                <th>Meeting Log</th>
                <th>View</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM meetinglog WHERE supervisorID = '$user_id'");
            $i = 1;
            while($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $i++ . "</td>";
                echo "<td>" . $row['studentID'] . "</td>";
                echo "<td>" . $row['meetingLog'] . "</td>";
                echo "<td><a href='../../file/meetinglogfile/" . $row['meetingLog'] . "' target='_blank'>View</a></td>";
                echo "<td><a href='../../file/meetinglogfile/" . $row['meetingLog'] . "' download>Download</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
        </tbody>
    </table>
    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>
</body>
</html>
