<?php
include("../db_connect.php");
$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST['user_ID'];
    $fullName = $_POST['user_name'];
    $password = $_POST['user_pass'];
    $phoneNumber = $_POST['phone_num'];
    $email = $_POST['user_email'];

    $sql = "UPDATE supervisor 
            SET fullName='$fullName', password='$password', phoneNumber='$phoneNumber', email='$email'
            WHERE supervisorID='$ID'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Supervisor updated successfully!'); window.location.href='viewSupervisor.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
