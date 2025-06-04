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

error_reporting(0);

$id = $_GET['id'];

if(count($_POST)>0){
    $fullName = $_POST['fullName'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    mysqli_query($conn, "UPDATE supervisor set fullName='$fullName', phoneNumber='$phoneNumber', email='$email' WHERE supervisorID=$id");
    header("location:supervisorDetail.php");
}
$sql = "SELECT * FROM supervisor WHERE supervisorID=$id";
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
        <form action="search_sv.php" method="GET" class="search">
            <input type="text" name="query" placeholder="Search..." required>
            <button type="submit">Search</button>
        </form>

        <div class="user-actions">
            <span>Hi, <?php echo $username?></span>
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
    <main>
        <h2>Update Student Details</h2> 

        <form action="" method="post">
            <p class="col-25">
                <label for="supervisorid">Supervisor ID:</label>
            </p>
            <p class="col-75">
                <input type="text" name="supervisorid" value="<?php echo $row["supervisorID"];?>" readonly />
            </p>
            <p class="col-25">
                <label for="name">Full Name:</label>
            </p>
            <p class="col-75">
                <input type="text" name="fullName" value="<?php echo $row["fullName"];?>" />
            </p>
            <p class="col-25">
                <label for="phoneNumber">Phone Number:</label>
            </p>
            <p class="col-75">
                <input type="text" name="phoneNumber" value="<?php echo $row["phoneNumber"];?>" />
            </p>
            <p class="col-25">
                <label for="email">Email:</label>
            </p>
            <p class="col-75">
                <input type="email" name="email" value="<?php echo $row["email"];?>" />
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
