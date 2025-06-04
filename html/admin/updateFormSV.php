<?php
include("../db_connect.php");
include("../session.php");
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

$ID = $_GET['supervisorID'] ?? '';

$fullName = $password = $phoneNumber = $email = '';

if ($ID) {
    $sql = "SELECT * FROM supervisor WHERE supervisorID='$ID'";
    $result = mysqli_query($conn, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $fullName = $row["fullName"];
        $password = $row["password"];
        $phoneNumber = $row["phoneNumber"];
        $email = $row["email"];
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/adminAnnouncement.css">
    <title>Update Supervisor Information</title>
</head>
<body>
<header>
    <h1>Final Year Project Management</h1>
    <form action="search.php" method="GET" class="search">
            <input type="text" name="query" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
        <div class="user-actions">
        <span>Hi, <?php echo $username?></span>
        </div>
</header>
<nav>
    <a href="viewSupervisor.php">Back</a>
    <a href="adminMain.php">Home</a>
    <a href="https://clic.mmu.edu.my">CLIC</a>
    <a href="https://ebwise.mmu.edu.my">eBwise</a>
    <a href="contributors.php">Contributors</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </nav>

<div id="title">
    <h1>Update Supervisor Information</h1>
</div>

<form action="updateSV.php" method="post">
    <div class="rectangle">
        <div class="inputUser">
            <h2><label for="ID">ID</label></h2>
            <input type="text" id="ID" name="user_ID" value="<?= $ID ?>" required>

            <h2><label for="fullName">Full Name</label></h2>
            <input type="text" id="fullName" name="user_name" value="<?= $fullName ?>" required>

            <h2><label for="password">Password</label></h2>
            <input type="password" id="password" name="user_pass" value="<?= $password ?>" required>

            <h2><label for="phoneNum">Phone Number</label></h2>
            <input type="tel" id="phoneNum" name="phone_num" value="<?= $phoneNumber ?>" required>

            <h2><label for="email">Email</label></h2>
            <input type="email" id="email" name="user_email" value="<?= $email ?>" required>
        </div>

        <div class="button">
            <button type="reset">Reset</button>
            <button type="submit">Update</button>
        </div>
    </div>
</form>
</body>
</html>
