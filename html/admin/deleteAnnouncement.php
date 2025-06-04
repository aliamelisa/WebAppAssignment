<?php
include("../db_connect.php");
$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $announcementID = intval($_GET['id']);

    $sql = "DELETE FROM announcement WHERE announcementID = $announcementID";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Announcement deleted successfully.'); window.location.href='adminMain.php';</script>";
    } else {
        echo "<script>alert('Error deleting announcement: " . mysqli_error($conn) . "'); window.location.href='adminMain.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='adminMain.php';</script>";
}

mysqli_close($conn);
?>