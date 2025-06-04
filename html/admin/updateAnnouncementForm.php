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

$ID = $_GET['announcementID'] ?? '';

$title = $target = $from = $announcement ='';

if ($ID) {
    $sql = "SELECT * FROM announcement WHERE announcementID='$ID'";
    $result = mysqli_query($conn, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $target = $row['target'];
        $from = $row['announceBy'];
        $announcement = $row['content'];
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make an announcement</title>
    <link rel="stylesheet" href="../../css/adminAnnouncement.css">
    <script src="../../js/adminAnnouncement.js"></script>
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
    <a href="adminMain.php">Home</a>
    <a href="https://clic.mmu.edu.my">CLIC</a>
    <a href="https://ebwise.mmu.edu.my">eBwise</a>
    <a href="contributors.php">Contributors</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </nav>
  
    <div id="title">
        <h1>Update Announcement</h1>
    </div>

    <div class="rectangle">
    
        <form action="updateAnnouncement.php" name="announcementForm" id="announcementForm" method="post">    
        <div id="announcementFields">

            <div class="announceTitle">
                <h2><label for="">Announcement ID</label></h2>
                <input type="text" title="Announcement title" name="announceID" value="<?= $ID ?>" readonly>
                <h2><label for="">Title</label></h2>
                <input type="text" placeholder="Insert title" title="Announcement title" name="announceTitle"required>
            </div>
            
            <div>
                <h2><label for="">Announce to</label></h2>
                <select name="target" id="target" title="Target announcement">
                    <option value="admin">Admins</option>
                    <option value="lecturer">Lecturers</option>
                    <option value="student">Students</option>
                    <option value="all">All</option>
                </select>
            </div>

            <div>
                <h2><label for="">Announcement from</label></h2>
                <select name="from" id="from">
                    <option value="security">Security</option>
                    <option value="fmd">FMD</option>
                    <option value="nice">NICE</option>
                    <option value="registrar">Academic Registrar</option>
                    <option value="oshe">OSHE</option>
                    <option value="foe">Faculty of Engineering</option>
                    <option value="fci">Faculty of Computing & Informatics</option>
                    <option value="fom">Faculty of Management</option>
                    <option value="fcm">Faculty of Creative Multimedia</option>
                    <option value="fol">Faculty of Law</option>
                </select>
            </div>

            <div>
                <h2><label for="">Announcement</label></h2>
                <textarea id="announcement" name="announcement" rows="4" cols="50" placeholder="Make an announcement." title="Type announcement here" required></textarea>
            </div>

            <div class="button">
                <button title="Reset announcement" type="reset">Reset</button>
                <button title="Post announcement" type="submit">Update</button>
            </div>
        </div>
    </div>
    </form>
    <footer>© 2024 FCI FYP Management System. All rights reserved.</footer>
</body>
</html>