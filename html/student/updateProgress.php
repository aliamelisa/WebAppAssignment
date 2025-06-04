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

error_reporting(0);

$id = $_GET['id'];

if(count($_POST)>0){
    $progress = $_POST['progress'];
    $milestone = $_POST['milestone'];
    mysqli_query($conn, "UPDATE project set progress='$progress', milestone='$milestone' WHERE studentID=$id");
    header("location:studentProgress.php");
}
$sql = "SELECT * FROM project WHERE studentID=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student Information</title>
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
        <h2>Update Project Progress</h2> 

        <form action="" method="post">
            <p class="col-25">
                <label for="projectid">Project ID:</label>
            </p>
            <p class="col-75">
                <input type="text" name="projectid" value="<?php echo $row["projectID"];?>" readonly />
            </p>
            <p class="col-25">
                <label for="progress">Progress:</label>
            </p>
            <p class="col-75">
                <input type="text" name="progress" value="<?php echo $row["progress"];?>" />
            </p>
            <p class="col-25">
                <label for="milestone">Milestone:</label>
            </p>
            <p class="col-75">
                <input type="text" name="milestone" value="<?php echo $row["milestone"];?>" />
            </p>
            <p>
                <input type="submit" name="update" value="Update" />
            </p>
            
        </form>
    </main>
    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>
</body>
</html>
