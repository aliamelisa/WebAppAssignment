<?php

require_once '../db_connect.php';
$conn = OpenCon();

if(isset($_POST['submit'])){

    // Check if a file was uploaded without errors
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $target_dir = "../../file/resourcefile/"; // Change this to the desired directory for uploaded files
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is allowed (you can modify this to allow specific file types)
        $allowed_types = array("jpg", "jpeg", "png", "gif", "pdf", "docx");
        if (!in_array($file_type, $allowed_types)) {
            echo "Sorry, only JPG, JPEG, PNG, GIF, PDF and DOC files are allowed.";
        } else {
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                // File upload success, now store information in the database
                $filename = $_FILES["file"]["name"];

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Insert the file information into the database
                $sql = "INSERT INTO file (fileName) VALUES ('$filename')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Upload successful!'); window.location.href = 'resource.php';</script>";
                } else {
                    echo "<script>alert('There was an error uploading your file. Please try again!'); window.location.href = 'resource.php';</script>";
                }

                $conn->close();
            } else {
                echo "<script>alert('There was an error uploading your file. Please try again!'); window.location.href = 'resource.php';</script>";
            }
        }
    } else {
        echo "<script>alert('There is no file upload. Please try again!'); window.location.href = 'resource.php';</script>";
    }
}
?>