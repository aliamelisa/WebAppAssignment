<?php
    include("../db_connect.php");
    $conn = OpenCon();

    $studentID = $_REQUEST['studentID'];
    $supervisorID = $_REQUEST['supervisorID'];
    $title = $_REQUEST['meeting-title'];
    $date = $_REQUEST['meeting-date'];
    $time = $_REQUEST['meeting-time'];
    $platform = $_REQUEST['meeting-platform'];
    $desc = $_REQUEST['meeting-description'];

    $sql = "INSERT INTO meeting (studentID, supervisorID, meetingTitle, meetingDate, meetingTime, meetingPlatform, meetingDescription) VALUES ('$studentID', '$supervisorID' ,'$title', '$date', '$time','$platform', '$desc')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>alert('Meeting added successfully!'); window.location.href='meeting.php';</script>";
        } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    mysqli_close($conn);
?>