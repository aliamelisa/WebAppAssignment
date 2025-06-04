<?php
session_start();
include("../db_connect.php");
$conn = OpenCon();

if(isset($_SESSION['mySession'])) {
    $user_id = $_SESSION['mySession'];

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE adminID = '$user_id'");

    while ($row = mysqli_fetch_array($result)) {
        $username = $row['fullName'];
    }
}
else {
    header('Location:../login.php');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $proposalID = $_POST['proposalID'];
    $proposalStatus = $_POST['proposalStatus'];

    // Update the proposal status
    $query = "UPDATE proposal SET proposalStatus = ? WHERE proposalID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $proposalStatus, $proposalID);

    if ($stmt->execute()) {
        // If the proposal is approved, insert it into the project table
        if ($proposalStatus == "Approved") {
            // Fetch project details from proposal table
            $proposal_query = "SELECT projectTitle, supervisorID, studentID FROM proposal WHERE proposalID = ?";
            $proposal_stmt = $conn->prepare($proposal_query);
            $proposal_stmt->bind_param("i", $proposalID);
            $proposal_stmt->execute();
            $proposal_result = $proposal_stmt->get_result();
            $proposal_data = $proposal_result->fetch_assoc();

            if ($proposal_data) {
                $projectTitle = $proposal_data['projectTitle'];
                $supervisorID = $proposal_data['supervisorID'];
                $studentID = $proposal_data['studentID'];

                // Check if project already exists for this proposal
                $check_query = "SELECT COUNT(*) AS count FROM project WHERE projectID = ?";
                $check_stmt = $conn->prepare($check_query);
                $check_stmt->bind_param("i", $proposalID);
                $check_stmt->execute();
                $check_result = $check_stmt->get_result();
                $row = $check_result->fetch_assoc();

                if ($row['count'] == 0) {
                    // Insert into project table
                    $insert_query = "INSERT INTO project (projectID, projectTitle, supervisorID, studentID, progress, milestone, completionStatus)
                                     VALUES (?, ?, ?, ?, 0, 'Not Started', 'In Progress')";
                    $insert_stmt = $conn->prepare($insert_query);
                    $insert_stmt->bind_param("issi", $proposalID, $projectTitle, $supervisorID, $studentID);
                    
                    if ($insert_stmt->execute()) {
                        echo "<script>alert('Proposal approved.');</script>";
                    } else {
                        echo "<script>alert('Error.');</script>";
                    }
                    $insert_stmt->close();
                } else {
                    echo "<script>alert('Proposal already exists.');</script>";
                }
                $check_stmt->close();
            } else {
                echo "<script>alert('Error fetching proposal details.');</script>";
            }
            $proposal_stmt->close();
        }
        
        echo "<script>window.location.href='adminUpdateProposal.php';</script>";
    } else {
        echo "Error updating proposal: " . $conn->error;
    }

    $stmt->close();
}

// Function to get all proposals
function getProposals($conn) {
    $query = "SELECT proposalID, supervisorID, studentID, specialization, projectTitle, projectType, filename, proposalStatus FROM proposal";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($conn));
    }

    return $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Proposal</title>
    <link rel="stylesheet" href="../../css/adminUserManagement.css" />
</head>
<body>
    <header>
        <h1>Final Year Project Management</h1>
        <form action="search_admin.php" method="GET" class="search">
            <input type="text" name="query" placeholder="Search..." required>
            <button type="submit">Search</button>
        </form>
        <div class="user-actions">
        <span>Hi, <?php echo $username?></span>
        </div>
    </header>
    <nav>
    <a href="https://clic.mmu.edu.my">CLIC</a>
    <a href="https://ebwise.mmu.edu.my">eBwise</a>
    <a href="contributors.php">Contributors</a>
    <a href="admin-feedback.php">Feedback</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </nav>
    <div>
        <div id="title">
            <h1>Proposal Management</h1>
        </div>
        <div class="rectangle">
            <h2>Update Proposal</h2>
            <table border="1">
                <tr>
                    <th>Proposal ID</th>
                    <th>Supervisor ID</th>
                    <th>Student ID</th>
                    <th>Specialization</th>
                    <th>Project Title</th>
                    <th>Project Type</th>
                    <th>Filename</th>
                    <th>Status</th>
                    <th>Update</th>
                </tr>
                <?php
                $result = getProposals($conn);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['proposalID']}</td>
                        <td>{$row['supervisorID']}</td>
                        <td>{$row['studentID']}</td>
                        <td>{$row['specialization']}</td>
                        <td>{$row['projectTitle']}</td>
                        <td>{$row['projectType']}</td>
                        <td><a href='../../file/proposalfile/{$row['filename']}' target='_blank'>View</a></td>
                        <td>{$row['proposalStatus']}</td>
                        <td>
                            <form action='adminUpdateProposal.php' method='POST'>
                                <input type='hidden' name='proposalID' value='{$row['proposalID']}'>
                                <select name='proposalStatus' required>
                                    <option value='Pending' " . ($row['proposalStatus'] == 'Pending' ? "selected" : "") . ">Pending</option>
                                    <option value='Approved' " . ($row['proposalStatus'] == 'Approved' ? "selected" : "") . ">Approved</option>
                                    <option value='Rejected' " . ($row['proposalStatus'] == 'Rejected' ? "selected" : "") . ">Rejected</option>
                                </select>
                                <button type='submit'>Update</button>
                            </form>
                        </td>
                    </tr>";
                }
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
    <footer>© 2024 FCI FYP Management System. All rights reserved.</footer>
</body>
</html>
