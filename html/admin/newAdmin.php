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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/adminAnnouncement.css">
    <title>Add new user</title>
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
    <a href="viewAdmin.php">Back</a>
    <a href="adminMain.php">Home</a>
    <a href="https://clic.mmu.edu.my">CLIC</a>
    <a href="https://ebwise.mmu.edu.my">eBwise</a>
    <a href="contributors.php">Contributors</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </nav>

    <div id="title">
        <h1>Add admin</h1>
    </div>

    <form action="insertAdmin.php" name="newUserForm" id="newUserForm" method="post">
    <div class="rectangle">
        
        <div class="inputUser">
        <h2><label for="ID">ID</label></h2>
        <input type="text" placeholder="Insert ID" title="ID" id="ID" name="user_ID" required>
        <h2><label for="fullName">Full Name</label></h2>
        <input type="text" placeholder="Insert full name" title="fullName" id="fullName" name="user_name" required>
        <h2><label for="password">Password</label></h2>
        <input type="password" placeholder="Insert password" title="password" id="password" name="user_pass" required>
        <h2><label for="phoneNum">Phone Number</label></h2>
        <input type="tel" placeholder="Insert phone number" title="phoneNum" id="phoneNum" name="phone_num" required>
        <h2><label for="email">Email</label></h2>
        <input type="email" placeholder="Insert email" title="email" id="email" name="user_email" required>
        </div>

        <div class="button">
            <button title="Reset announcement" type="reset">Reset</button>
            <button title="Post announcement" type="submit">Submit</button>
        </div>
    </div>
    </form>
</body>
</html>