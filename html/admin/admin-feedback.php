<?php

session_start();
include("../db_connect.php");
$conn = OpenCon();

if(isset($_SESSION['mySession'])) {
    $user_id = $_SESSION['mySession'];

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE adminID = '$user_id'");

    while ($row = mysqli_fetch_array($result)) {
        $username = $row['fullName'];
    }
}
else {
    header('Location:../login.php');
    exit();
}

// Fetch feedback data from the database
$query = "SELECT studentID, supervisorID, comments, rate FROM feedback";
$result = mysqli_query($conn, $query);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Feedback</title>
    <link rel="stylesheet" href="../../css/admin-feedback.css"> 
</head>
<body>
    <header>
        <h1>Final Year Project Management</h1>
        <form action="search_admin.php" method="GET" class="search">
          <input type="text" name="query" placeholder="Search..." required>
          <button type="submit">Search</button>
      </form>

      <div class="user-actions">
        <span>Hi, <?php echo $username?></span>
        </div>
    </header>

    <nav>
        <a href="adminMain.php">Home</a>
        <a href="contributors.php">Contributors</a>
        <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </nav>
    
    <main>
        <div class="feedback-table-container">
            <h1>Feedback Records</h1>
            <h2>All Submitted Feedback</h2>
            <p>Here is the feedback submitted by all users.</p>
            
            <table border="1">
                <tr>
                    <th>Student ID</th>
                    <th>Supervisor ID</th>
                    <th>Comments</th>
                    <th>Rating</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['studentID']; ?></td>
                        <td><?php echo ($row['supervisorID']) ? $row['supervisorID'] : 'N/A'; ?></td>
                        <td><?php echo $row['comments']; ?></td>
                        <td><?php echo ucfirst($row['rate']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </main>
</body>
</html>
