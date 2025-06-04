<?php
        include("../db_connect.php");
        $conn = OpenCon();

        $userID = $_REQUEST['user_ID'];
        $first_name =  $_REQUEST['user_name'];
        $password =  $_REQUEST['user_pass'];
        $phone = $_REQUEST['phone_num'];
        $email = $_REQUEST['user_email'];
        
        $sql = "INSERT INTO admin (adminID, fullName, password, phoneNumber, email) VALUES ('$userID', '$first_name', '$password','$phone', '$email')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Admin added successfully!'); window.location.href='viewAdmin.php';</script>";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }

        mysqli_close($conn);
        ?>