<?php

session_start();
include("../db_connect.php");
$conn = OpenCon();

if(isset($_SESSION['mySession'])) {
    $user_id = $_SESSION['mySession'];

    $result = mysqli_query($conn, "SELECT * FROM supervisor WHERE supervisorID = '$user_id'");

    while ($row = mysqli_fetch_array($result)) {
        $username = $row['fullName'];
        // $studID = $row['studentID'];
        // $supervisorID = $row['supervisorID'];
    }
}
else {
    header('Location:../login.php');
    exit();
}

$sql = "SELECT * FROM supervisor WHERE supervisorID='$user_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="../../css/proposal-styles.css">
</head>

<body>
    <header>
        <h1>Final Year Project Management</h1>

        <form action="search.php" method="GET" class="search">
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
        <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>

    </nav>


    <main>
        <h2>Submit Your Final Year Project Proposal</h2>
        <p>Please fill out the form below to submit your Final Year Project details.</p>
        <form action="uploadProposal.php" method="POST" class="registration-form" enctype="multipart/form-data">

            <label for="supervisor">Supervisor Name:</label>
            <input type="text" id="supervisor" name="supervisor" value="<?php echo $row['fullName'];?>" readonly>

            <label for="supervisor-id">Supervisor ID:</label>
            <input type="text" id="supervisor-id" name="supervisor-id" value="<?php echo $row['supervisorID'];?>" readonly>

            <label for="specialisation">Course Specialisation:</label>
            <select id="specialisation" name="specialisation" required>
                <option value="" disabled selected>Select your course specialisation</option>
                <option value="data-science">Data Science</option>
                <option value="software-engineering">Software Engineering</option>
                <option value="cybersecurity">Cybersecurity</option>
                <option value="game-development">Game Development</option>
            </select>

            <label for="project-title">Project Title:</label>
            <input type="text" id="project-title" name="project-title" placeholder="Enter your project title" required>

            <label for="project-type">Project Type:</label>
            <input type="text" id="project-type" name="project-type" placeholder="Enter your project type" required>

            <label for="project-file">Upload Project Proposal (PDF only):</label>
            <input type="file" id="project-file" name="project-file" accept=".pdf" required>

            <button type="submit" name="submit">Submit</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>
    
</body>
</html>
