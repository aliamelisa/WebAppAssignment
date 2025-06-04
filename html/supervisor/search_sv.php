<?php
session_start();
include("../db_connect.php");
$conn = OpenCon();

// if (!isset($_SESSION['mySession']) || $_SESSION['role'] !== 'supervisor') {
//     header("Location: ../login.php");
//     exit();
// }

$supervisorKeywords = [
    "project" => "studentproject_assignment.php",
    "feedback" => "supervisor-feedback.php",
    "marksheet" => "marksheet_sv.php",
    "update" => "supervisorDetail.php",
    "proposal" => "proposal.php",
    "progress" => "supervisorProjectPlanning.php",
    "meeting" => "meetinglogsview.php"
];

$errorMessage = "";

if (isset($_GET['query']) && !empty($_GET['query'])) {
    $searchQuery = strtolower(trim($_GET['query']));
    
    foreach ($supervisorKeywords as $keyword => $redirectUrl) {
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
    <title>Supervisor Search</title>
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
