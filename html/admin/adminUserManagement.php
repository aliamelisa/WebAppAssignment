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
<!-- Admin User Management Page -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Management</title>
    <link rel="stylesheet" href="../../css/adminUserManagement.css" />
  </head>
  
  <body>
    <!-- Header & navigation bar -->
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
    <a href="https://clic.mmu.edu.my">CLIC</a>
    <a href="https://ebwise.mmu.edu.my">eBwise</a>
    <a href="contributors.php">Contributors</a>
      <a href="admin-feedback.php">Feedback</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
  </nav>

  <div>
    <div id="title">
      <h1>User Management System</h1>
    </div>

    <div class="rectangle">
    <!-- Total User Count -->
      <?php

        $positions = ['admin', 'student', 'supervisor'];
        $count = 0;

        foreach ($positions as $position) {
          $sql = "SELECT COUNT(*) AS total FROM $position";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);
          $count += $row['total'];
        }
            
        echo "<label for=''><h2>Total person: ".$count."</h2></label>";
        mysqli_close($conn);
      ?>
      
      <!-- User Menu (Admin, Supervisor, Student) -->
      <div class="options-container">
        <div class="option">
          <p><a title="Check admin" href="viewAdmin.php">Admin</a></p>
          <p style="color: black;">Manage admin's informations</p>
        </div>
          
        <div class="option">
            <p><a title="Check lecturer" href="viewSupervisor.php">Supervisor</a></p>
            <p style="color: black;">Manage supervisor's informations</p>
        </div>
          
        <div class="option">
          <p><a title="Check student" href="viewStudent.php">Student</a></p>
          <p style="color: black;">Manage student's informations</p>
        </div>
      </div>
    </div>
  </div>

  <footer>© 2024 FCI FYP Management System. All rights reserved.</footer>
  </body>
</html>
