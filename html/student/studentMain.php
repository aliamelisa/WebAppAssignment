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
    <script src="../../js/adminMain.js"></script>
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
        <h1>Welcome to the FCI Final Year Project Management portal!</h1> 
        <h3>Here, you can register your project, submit your proposal, schedule meetings, and track your progress.<br>
            Follow the steps to ensure a smooth and successful project journey.</h3> 
        <div class="options-container">    
            <div class="option">
                <img src="../../images/proposal.png" alt="Proposal Icon">
                <p><a href="proposal.php">Project Planning Proposal</a></p>
                <p>Upload and submit your project proposal for review and approval.</p>
            </div>
            <div class="option">
                <img src="../../images/meeting.png" alt="Meeting Icon">
                <p><a href="meeting.php">Meeting Management</a></p>
                <p>Schedule and manage meetings with your supervisor seamlessly.</p>
            </div>
            <div class="option">
                <img src="../../images/meeting.png" alt="Meeting Icon">
                <p><a href="meetinglogs.php">Meeting Logs Submission</a></p>
                <p>Submit your meeting logs to your supervisor.</p>
            </div>
            <div class="option">
                <img src="../../images/progress.png" alt="Progress Icon">
                <p><a href="studentProgress.php">Progress Tracking</a></p>
                <p>Monitor your project milestones and overall progress in real time.</p>
            </div>
            <div class="option">
                <img src="../../images/marksheet.png" alt="Marksheet Icon">
                <p><a href="studentMarksheet.php">Marksheet</a></p>
                <p>View and track your performance and evaluation results.</p>
            </div>
            <div class="option">
                <img src="../../images/status_update.png" alt="Status Update Icon">
                <p><a href="studentDetail.php">Update User Details</a></p>
                <p>Update your details.</p>
            </div>
        </div>
        <!-- Slideshow -->
    <section class="slideshow-container">
      <div class="slidefade" style="display: block;">
        <div class="slidenumber">1 / 3</div>
        <img src="../../images/sample.png" alt="Announcement" title="Announcement" class="slideshow" style="width: 100%;">
        <div class="slidetext">Image 1</div>
      </div>
      <div class="slidefade" style="display: none;">
        <div class="slidenumber">2 / 3</div>
        <img src="../../images/wallpaperflare.com_wallpaper (1).jpg" alt="Announcement" title="Announcement" class="slideshow" style="width: 100%;">
        <div class="slidetext">Image 2</div>
      </div>
      <div class="slidefade" style="display: none;">
        <div class="slidenumber">3 / 3</div>
        <img src="../../images/wallpaperflare.com_wallpaper (2).jpg" alt="Announcement" title="Announcement" class="slideshow" style="width: 100%;">
        <div class="slidetext">Image 3</div>
      </div>
      <a class="prev" onclick="plusSlides(-1)"><</a>
      <a class="next" onclick="plusSlides(1)">></a>
    </section>

        <!-- Announcement -->
    <div class="rectangle">
      <section class="announcement">
        <h1>Announcements</h1>
        <table>
        <?php
        $sql = "SELECT announcementID, title, target, announceBy, content, datePosted FROM announcement";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
            <td><a href='viewAnnouncement.php?id=".$row['announcementID']."' title='View announcement' target='_blank'>".$row['title']."</a></td>
        </tr>";
            }
        } else {
              echo "<tr><td colspan='1'>No announcements</td></tr>";
          }
        mysqli_close($conn);
        ?>
        </table>
        </section>
      </div>
    </main>
    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>
</body>
</html>
