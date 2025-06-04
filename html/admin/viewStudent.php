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
<html>
    <head>
        <title>Student Information</title>
        <link rel="stylesheet" href="../../css/viewStudent.css" />
    </head>

    <body>
    <header>
        <h1>Final Year Project Management</h1>
        <form action="search_admin.php" method="GET" class="search">
            <input type="text" name="query" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
  
        <div class="user-actions">
            <span>Hi, <?php echo $username?></span>
        </div>
    </header>
  
    <nav>
    <a href="adminUserManagement.php">Back</a>
    <a href="adminMain.php">Home</a>
    <a href="https://clic.mmu.edu.my">CLIC</a>
    <a href="https://ebwise.mmu.edu.my">eBwise</a>
    <a href="contributors.php">Contributors</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </nav>
    <div id="table-place">
    <h2 style="text-align:center;">Student Information</h2>
    <form action="deleteStudent.php" method="POST">
        <table id='infotable'>
            <th></th>
            <th>Student ID</th>
            <th>Supervisor ID</th>
            <th>Name</th>
            <th>Password</th>
            <th>Phone Number</th>
            <th>Email</th>
        <?php

        $sql = "SELECT studentID, supervisorID, fullName, password, phoneNumber, email FROM student";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td><input type='checkbox' name='selectUser[]' value='" . $row["studentID"] . "'></td>
                        <td>" . $row["studentID"]. "</td>
                        <td>" . $row["supervisorID"]. "</td>
                        <td>" . $row["fullName"]. "</td>
                        <td>" . $row["password"]. "</td>
                        <td>" . $row["phoneNumber"]. "</td>
                        <td>" . $row["email"]. "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No data recorded</td></tr>";
        }

        mysqli_close($conn);
        ?>
        </table>
        <p></p>
        <button type='button' onclick="updateStudent();">Update Information</button>
        <p></p>
    <button type="submit" id="delete-user">Delete Users</button>
        </form>

        <script src="../../js/viewUser.js"></script>
    </div>
    </body>
</html>
