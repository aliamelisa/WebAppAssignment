<?php
session_start();
include('db_connect.php');

$conn = OpenCon();

if (isset($_POST['login'])) {
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $numberID = mysqli_real_escape_string($conn, $_POST['numberID']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Determine which table to query based on role
    if ($role == 'admin') {
        $sql = "SELECT * FROM admin WHERE adminID = '$numberID' AND password = '$password'";
        $redirect = "admin/adminMain.php";
    } elseif ($role == 'student') {
        $sql = "SELECT * FROM student WHERE studentID = '$numberID' AND password = '$password'";
        $redirect = "student/studentMain.php";
    } elseif ($role == 'supervisor') {
        $sql = "SELECT * FROM supervisor WHERE supervisorID = '$numberID' AND password = '$password'";
        $redirect = "supervisor/supervisorMain.php";
    } else {
        echo "<script>alert('Invalid role selected!'); window.location.href = 'login.php';</script>";
    }

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["mySession"] = $row[$role . "ID"];
        header("Location: $redirect");

    } else {
        echo "<script>alert('User not found!'); window.location.href = 'login.php';</script>";
    }
} else {
    echo "<script> alert('Incorrect username or password!');
        window.location.href = 'login.php'; </script>";
}
?>
