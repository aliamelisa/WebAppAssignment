<?php
include("../db_connect.php");
$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['selectUser'])) {

        $IDs = implode(",", array_map('intval', $_POST['selectUser']));

        // Delete related proposals first to prevent foreign key constraint issues
        $sql_proposal = "DELETE FROM proposal WHERE studentID IN ($IDs)";
        if (!mysqli_query($conn, $sql_proposal)) {
            echo "<script>alert('Error deleting related proposals: " . mysqli_error($conn) . "'); window.location.href='viewStudent.php';</script>";
            exit();
        }

        // Now delete students
        $sql_student = "DELETE FROM student WHERE studentID IN ($IDs)";
        if (mysqli_query($conn, $sql_student)) {
            echo "<script>alert('Selected users deleted successfully.'); window.location.href='viewStudent.php';</script>";
        } else {
            echo "<script>alert('Error deleting users: " . mysqli_error($conn) . "'); window.location.href='viewStudent.php';</script>";
        }
    } else {
        echo "<script>alert('No users selected.'); window.location.href='viewStudent.php';</script>";
    }
}

mysqli_close($conn);
?>
