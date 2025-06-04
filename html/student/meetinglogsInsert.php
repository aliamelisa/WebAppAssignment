<?php
    include("../db_connect.php");
    $conn = OpenCon();

    $meetingID = $_REQUEST['meetingID'];
    $supervisorID =  $_REQUEST['supervisorID'];
    $studentID =  $_REQUEST['studentID'];
    $meetinglog = $_REQUEST['meeting-log'];
    $filename = $_FILES['meeting-log']['name'];
        
    $sql = "INSERT INTO meetinglog (meetingID, supervisorID, studentID, meetingLog) VALUES ('$meetingID', '$supervisorID', '$studentID','$meetinglog')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $path = '../../file/meetinglogfile/';
            
        move_uploaded_file($_FILES['meeting-log']['tmp_name'],($path . $filename));
        echo "<script>alert('Meeting log added successfully!'); window.location.href='meetinglogs.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>