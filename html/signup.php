<?php
include 'db_connect.php'; // Include database connection

$conn = OpenCon(); // Open database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $studentID = mysqli_real_escape_string($conn, $_POST['studentID']);
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Store password as plain text
    $phoneNumber = mysqli_real_escape_string($conn, $_POST['phoneNumber']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Validate password length
    if (strlen($password) < 6 || strlen($password) > 12) {
        $message = "Password must be between 6 and 12 characters!";
    } else {
        // Check if student ID or email already exists
        $check_sql = "SELECT * FROM student WHERE studentID = '$studentID' OR email = '$email'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $message = "Student ID or Email already registered!";
        } else {
            // Insert student data with supervisorID set to NULL
            $sql = "INSERT INTO student (studentID, supervisorID, fullName, password, phoneNumber, email) 
                    VALUES ('$studentID', NULL, '$fullName', '$password', '$phoneNumber', '$email')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>
                        alert('Registration successful! Redirecting to login...');
                        window.location.href='login.php';
                      </script>";
                exit();
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        }
    }
}

CloseCon($conn); // Close database connection
?>



<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/mainForm.css">
</head>

<body>
    <div class="title">
        <h1>Welcome to FCI Final Year Project Management Portal</h1>
    </div>
    
    <div class="main">
        <h1>Sign Up Form</h1>
        <h3>Fill up the form to create an account</h3>

        <?php if (isset($message)) { ?>
            <p style="color:red; font-weight:bold;"><?php echo $message; ?></p>
        <?php } ?>

        <form action="signup.php" method="POST">
            <p class="col-25">
                <label for="studentID">Student ID :</label>
            </p>
            <p class="col-75">
                <input type="text" name="studentID" placeholder="Enter your Student ID" required/>
            </p>

            <p class="col-25">
                <label for="fullName">Full Name :</label>
            </p>
            <p class="col-75">
                <input type="text" name="fullName" placeholder="Enter your full name" required/>
            </p>

            <p class="col-25">
                <label for="phoneNumber">Phone Number:</label>
            </p>
            <p class="col-75">
                <input type="tel" name="phoneNumber" placeholder="601******" required/>
            </p>

            <p class="col-25">
                <label for="email">Email :</label>
            </p>
            <p class="col-75">
                <input type="email" name="email" placeholder="ahmad@gmail.com" required/>
            </p>

            <p class="col-25">
                <label for="password">Password :</label>
            </p>
            <p class="col-75">
                <input type="password" name="password" placeholder="Password (6-8 characters)" required pattern="[A-Za-z0-9]{6,12}"/>
            </p>
            
            <p>
                <input type="submit" value="Sign Up">
                <input type="reset" value="Reset">
            </p>
        </form>
    </div>
</body>

</html>

