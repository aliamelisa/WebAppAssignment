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

<!-- Admin Main Page -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Main Page</title>
    <link rel="stylesheet" href="../../css/adminMain.css" />
    <script src="../../js/adminMain.js"></script>
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

    <!-- Admin Menu -->
    <main id="mainContent">
      <h1>Admin Main Page</h1>
      <div class="options-container">
        <div class="option">
            <img src="../../images/register.png" alt="Registration Icon">
            <p><a href="adminUserManagement.php" title="Manage user">User Management</a></p>
            <p>Manage admins or lecturers.</p>
        </div>
        <div class="option">
            <img src="../../images/progress.png" alt="Proposal Icon">
            <p><a href="adminAnnouncement.html" title="Make announcement">Announcements</a></p>
            <p>Announcements management</p>
        </div>
        <div class="option">
            <img src="../../images/progress.png" alt="Proposal Icon">
            <p><a href="adminUpdateProposal.php" title="Make announcement">Proposal</a></p>
            <p>Approve proposal</p>
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

    <footer>© 2024 FCI FYP Management System. All rights reserved.</footer>
  </body>
</html>
