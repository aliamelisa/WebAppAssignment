<?php
include("../db_connect.php");
$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST['user_ID'];
    $SV_ID = $_POST['SV_ID'];
    $fullName = $_POST['user_name'];
    $password = $_POST['user_pass'];
    $phoneNumber = $_POST['phone_num'];
    $email = $_POST['user_email'];

    $sql = "UPDATE student 
            SET supervisorID='$SV_ID', fullName='$fullName', password='$password', phoneNumber='$phoneNumber', email='$email'
            WHERE studentID='$ID'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Student updated successfully!'); window.location.href='viewStudent.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
