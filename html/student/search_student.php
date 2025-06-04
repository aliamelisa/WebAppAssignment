<?php
session_start();
include("../db_connect.php");
$conn = OpenCon();

// if (!isset($_SESSION['mySession']) || $_SESSION['role'] !== 'student') {
//     header("Location: ../login.php");
//     exit();
// }

$studentKeywords = [
    "marksheet" => "studentMarksheet.php",
    "meeting" => "meeting.php",
    "proposal" => "proposal.php",
    "progress" => "studentProgress.php",
    "update" => "studentDetail.php",
    "announcement" => "viewAnnouncement.php",
    "feedback" => "student-feedback.php",
];

$errorMessage = "";

if (isset($_GET['query']) && !empty($_GET['query'])) {
    $searchQuery = strtolower(trim($_GET['query']));
    
    foreach ($studentKeywords as $keyword => $redirectUrl) {
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
    <title>Student Search</title>
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
