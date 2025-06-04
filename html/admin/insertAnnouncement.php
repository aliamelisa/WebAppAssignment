<?php
  include("../db_connect.php");
  $conn = OpenCon();

  $title = $_REQUEST['announceTitle'];
  $target =  $_REQUEST['target'];
  $from =  $_REQUEST['from'];
  $content = $_REQUEST['announcement'];
  $date = new DateTime();
  $formattedDate = $date->format('Y-m-d');
        
  $sql = "INSERT INTO announcement (title, target, announceBy, content, datePosted) VALUES ('$title', '$target','$from', '$content', '$formattedDate')";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    echo "<script>alert('Announcement posted successfully!'); window.location.href='adminMain.php';</script>";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

  mysqli_close($conn);
?>