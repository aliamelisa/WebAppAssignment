<?php
session_start();
include("db_connect.php");
$conn = OpenCon();

// ✅ Ensure user is logged in
if (!isset($_SESSION['mySession']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

$user_role = $_SESSION['role']; // Role: 'admin', 'supervisor', 'student'

// ✅ Define keyword-based redirects for each role
$roleBasedKeywords = [
    'student' => [
        "marksheet" => "student/studentMarksheet.php",
        "meeting" => "student/meeting.php",
        "proposal" => "student/proposal.php",
        "progress" => "student/studentProgress.php",
        "update" => "student/studentDetail.php",
        "feedback" => "student/student-feedback.php",
    ],
    'supervisor' => [
        "proposal" => "supervisor/proposal.php",
        "project" => "supervisor/studentproject_assignment.php",
        "meeting" => "student/meeting.php",
        "progress" => "supervisor/supervisorProjectPlanning.php",
        "meeting log" => "supervisor/meetinglogviews.php",
        "marksheet" => "supervisor/marksheet_sv.php",
        "update" => "supervisor/supervisorDetail.php",
        "feedback" => "supervisor/supervisor-feedback.php",
        
    ],
    'admin' => [
        "user" => "admin/adminUserManagement.php",
        "feedback" => "admin/admin-feedback.php",
        "announcement" => "admin/adminAnnouncement.html",
    ]
];

// ✅ Initialize error message
$errorMessage = "";

// ✅ Get search query if provided
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $searchQuery = strtolower(trim($_GET['query']));

    // ✅ Check for matches within the user's role
    if (isset($roleBasedKeywords[$user_role])) {
        foreach ($roleBasedKeywords[$user_role] as $keyword => $redirectUrl) {
            if (stripos($searchQuery, $keyword) !== false) {
                header("Location: $redirectUrl");
                exit();
            }
        }
    }

    // ✅ If no keyword matches, store an error message
    $errorMessage = "No results found for '<b>$searchQuery</b>'. Please try a different keyword.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
    <script>
        function showErrorMessage(message) {
            document.getElementById("error-container").innerHTML = message;
        }
    </script>
</head>
<body>
    <!-- <header>
        <h1>Search</h1>
        <form action="search.php" method="GET">
            <input type="text" name="query" placeholder="Search..." required>
            <button type="submit">Search</button>
        </form>
    </header> -->

    <main>
        <div id="error-container" class="error-message">
            <?php if (!empty($errorMessage)) { echo $errorMessage; } ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 FCI FYP Management System</p>
    </footer>
</body>
</html>
