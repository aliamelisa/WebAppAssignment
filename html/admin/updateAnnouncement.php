<?php
include("../db_connect.php");
$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST['announceID'];
    $title = $_POST['announceTitle'];
    $target = $_POST['target'];
    $from = $_POST['from'];
    $announcement = $_POST['announcement'];
    $date = new DateTime();
    $formattedDate = $date->format('Y-m-d');

    $sql = "UPDATE announcement SET title='$title', target='$target', announceBy='$from', content='$announcement', datePosted='$formattedDate' 
            WHERE announcementID='$ID'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Announcement posted successfully!'); window.location.href='adminMain.php';</script>";
    } else {
        echo "Error posting announcement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
