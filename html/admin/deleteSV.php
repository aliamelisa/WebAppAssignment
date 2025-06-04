<?php
include("../db_connect.php");
$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['selectUser'])) {

        $IDs = implode(",", array_map('intval', $_POST['selectUser']));

        // Delete ID in student first to prevent foreign key constraint issues
        $sql_proposal = "DELETE FROM student WHERE supervisorID IN ($IDs)";
        if (!mysqli_query($conn, $sql_proposal)) {
            echo "<script>alert('Error deleting related proposals: " . mysqli_error($conn) . "'); window.location.href='viewSupervisor.php';</script>";
            exit();
        }

        // Now delete supervisor
        $sql_student = "DELETE FROM supervisor WHERE supervisorID IN ($IDs)";
        if (mysqli_query($conn, $sql_student)) {
            echo "<script>alert('Selected users deleted successfully.'); window.location.href='viewSupervisor.php';</script>";
        } else {
            echo "<script>alert('Error deleting users: " . mysqli_error($conn) . "'); window.location.href='viewSupervisor.php';</script>";
        }
    } else {
        echo "<script>alert('No users selected.'); window.location.href='viewSupervisort.php';</script>";
    }
}

mysqli_close($conn);
?>
