<?php

require_once '../db_connect.php';
$conn = OpenCon();

if(isset($_POST['submit'])){

    // Check if a file was uploaded without errors
    if (isset($_FILES["project-file"]) && $_FILES["project-file"]["error"] == 0) {
        $target_dir = "../../file/proposalfile/"; // Change this to the desired directory for uploaded files
        $target_file = $target_dir . basename($_FILES["project-file"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is allowed (you can modify this to allow specific file types)
        $allowed_types = array("pdf");
        if (!in_array($file_type, $allowed_types)) {
            echo "Sorry, only PDF files are allowed.";
        } else {
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["project-file"]["tmp_name"], $target_file)) {
                // File upload success, now store information in the database
                $filename = $_FILES["project-file"]["name"];
                $filetype = $_FILES["project-file"]["type"];
                $supervisorID = $_POST['supervisor-id'];
                $specialization = $_POST['specialisation'];
                $projecttitle = $_POST['project-title'];
                $projecttype = $_POST['project-type'];
                

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Insert the file information into the database
                $sql = "INSERT INTO proposal (supervisorID, specialization, projectTitle, projectType, filename, proposalstatus) VALUES ('$supervisorID', '$specialization', '$projecttitle', '$projecttype', '$filename', 'pending')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Upload successful!'); window.location.href = 'supervisorMain.php';</script>";
                } else {
                    echo "<script>alert('There was an error uploading your file. Please try again!'); window.location.href = 'proposal.php';</script>";
                }

                $conn->close();
            } else {
                echo "<script>alert('There was an error uploading your file. Please try again!'); window.location.href = 'proposal.php';</script>";
            }
        }
    } else {
        echo "<script>alert('There is no file upload. Please try again!'); window.location.href = 'proposal.php';</script>";
    }
}
?>