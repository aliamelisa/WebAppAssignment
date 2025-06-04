<?php
include("../db_connect.php");
$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['selectUser'])) {

        $IDs = implode(",", array_map('intval', $_POST['selectUser']));

        $sql = "DELETE FROM admin WHERE adminID IN ($IDs)";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Selected users deleted successfully.'); window.location.href='viewAdmin.php';</script>";
        } else {
            echo "<script>alert('Error deleting users: " . mysqli_error($conn) . "'); window.location.href='viewAdmin.php';</script>";
        }
    } else {
        echo "<script>alert('No users selected.'); window.location.href='viewAdmin.php';</script>";
    }
}

mysqli_close($conn);
?>
