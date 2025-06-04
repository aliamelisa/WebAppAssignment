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
        <h2>Student Details</h2> 

        <?php
        $sql = "SELECT * FROM student WHERE studentID = '$user_id'";
        
        if ($result = mysqli_query($conn, $sql)){
            echo "<table id='student'>
                    <tr>
                        <th>Student ID</th>
                        <th>Full Name</th>
                        <th>Phone Number</th>
                        <th>Student Email</th>
                        <th>Supervisor ID</th>
                        <th colspan='2'>Actions</th>
                    </tr>";
            while ($row = mysqli_fetch_assoc($result)){
                $id = $row['studentID'];
                $name = $row['fullName'];
                $phoneNumber = $row['phoneNumber'];
                $email = $row['email'];
                $supervisorID = $row['supervisorID'];

                echo "<tr>";
                echo "<td>".$id."</td>";
                echo "<td>".$name."</td>";
                echo "<td>".$phoneNumber."</td>";
                echo "<td>".$email."</td>";
                echo "<td>".$supervisorID."</td>";
                echo "<td>
                        <span id='updatebutton'>
                        <a href='update.php?id=$row[studentID]'>Update</a>
                        </span>
                        </td>";
                echo "</tr>";
            }
            echo "</table>";
            mysqli_free_result($result);
        }
        else{
            echo "Error:".mysqli_error($conn);
        }
        CloseCon($conn);
        
        ?>
    </main>
    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>
</body>
</html>
