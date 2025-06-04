<?php
include("../db_connect.php");
$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST['user_ID'];
    $fullName = $_POST['user_name'];
    $password = $_POST['user_pass'];
    $phoneNumber = $_POST['phone_num'];
    $email = $_POST['user_email'];

    $sql = "UPDATE admin 
            SET fullName='$fullName', password='$password', phoneNumber='$phoneNumber', email='$email'
            WHERE adminID='$ID'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Admin updated successfully!'); window.location.href='viewAdmin.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
