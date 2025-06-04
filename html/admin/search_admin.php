<?php
session_start();
include("../db_connect.php");
$conn = OpenCon();

// if (!isset($_SESSION['mySession']) || $_SESSION['role'] !== 'admin') {
//     header("Location: ../login.php");
//     exit();
// }

$adminKeywords = [
    "user" => "adminUserManagement.php",
    "feedback" => "admin-feedback.php",
    "proposal" => "adminUpdateProposal.php",
    "announcement" => "adminAnnouncement.html",
    "supervisor" => "viewSupervisor.php",
    "admin" => "viewAdmin.php",
    "student" => "viewStudent.php",
];

$errorMessage = "";

if (isset($_GET['query']) && !empty($_GET['query'])) {
    $searchQuery = strtolower(trim($_GET['query']));
    
    foreach ($adminKeywords as $keyword => $redirectUrl) {
        if (stripos($searchQuery, $keyword) !== false) {
            header("Location: $redirectUrl");
            exit();
        }
    }
    
    $errorMessage = "No results found for '<b>$searchQuery</b>'. Try another keyword.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Search</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <main>
        <div class="error-message">
            <?php if (!empty($errorMessage)) { echo $errorMessage; } ?>
        </div>
    </main>
</body>
</html>
