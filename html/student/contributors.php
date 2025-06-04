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
    <link rel="stylesheet" href="../../css/contributors.css">
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
        <h1>Contributors</h1> 
        <div id="contributors-container">
            <section class="contributors">
                <img src="../../images/contributors/ikhwan.jpg">
                <p class="detail-label">Name</p>
                <p class="detail-desc">AHMAD NUR IKHWAN BIN HAMID</p>
                <p class="detail-label">Student ID</p>
                <p class="detail-desc">1211103140</p>
                <p class="detail-label">Section</p>
                <p class="detail-desc">TC1L</p>
                <p class="detail-label">Contact</p>
                <p class="detail-desc"><a href="mailto:">1211103140@student.mmu.edu.my</a></p>
            </section>
            <section class="contributors">
                <img src="../../images/contributors/adam.jpg">
                <p class="detail-label">Name</p>
                <p class="detail-desc">MUHAMMAD ADAM BIN MAZLI ZAKUAN</p>
                <p class="detail-label">Student ID</p>
                <p class="detail-desc">1211101073</p>
                <p class="detail-label">Section</p>
                <p class="detail-desc">TC1L</p>
                <p class="detail-label">Contact</p>
                <p class="detail-desc"><a href="mailto:">1211101073@student.mmu.edu.my</a></p>
            </section>
            <section class="contributors">
                <img src="../../images/contributors/adriana.jpg">
                <p class="detail-label">Name</p>
                <p class="detail-desc">ADRIANA IMAN BINTI NOOR AZRAI</p>
                <p class="detail-label">Student ID</p>
                <p class="detail-desc">1211103196</p>
                <p class="detail-label">Section</p>
                <p class="detail-desc">TC1L</p>
                <p class="detail-label">Contact</p>
                <p class="detail-desc"><a href="mailto:">1211103196@student.mmu.edu.my</a></p>
            </section>
            <section class="contributors">
                <img src="../../images/contributors/amelisa.jpg">
                <p class="detail-label">Name</p>
                <p class="detail-desc">NUR ALIA AMELISA SYAZREEN BINTI MOHD SULEI</p>
                <p class="detail-label">Student ID</p>
                <p class="detail-desc">1211103602</p>
                <p class="detail-label">Section</p>
                <p class="detail-desc">TC1L</p>
                <p class="detail-label">Contact</p>
                <p class="detail-desc"><a href="mailto:">1211103602@student.mmu.edu.my</a></p>
            </section>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>
</body>
</html>
