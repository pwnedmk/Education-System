<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to the database
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "educationsystem";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the student ID based on the logged-in username
$logged_in_username = $_SESSION["Username"];
$sql_student_id = "SELECT id FROM login WHERE userID = '$logged_in_username'";
$result_student_id = $conn->query($sql_student_id);

if ($result_student_id->num_rows == 0) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['assignment_id'])) {
    $assignment_id = $_GET['assignment_id'];
}
// Retrieve the list of assignments from the teacher_assignments table
$sql_assignments = "SELECT student_submissions.id, student_id, file_path, submitted_at, name FROM student_submissions JOIN login ON student_submissions.student_id = login.id
WHERE assignment_id = " . $assignment_id ;
$result_assignments = $conn->query($sql_assignments);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student</title>
    <link rel="stylesheet" type="text/css" href="test4.css">
</head>
<body>
    <nav id="menu_area">
        <ul>
            <li><a href="teacher_page.php">Home</a></li>
            <li><a href="studentlist.php">Student List</a></li>
            <li><a href="upload_assignment.php?user_type=teacher">Create Assignment</a></li>
            <li><a href="exam.html">Create Test/Quiz</a></li>
            <li><a href="logout.php"><button>Logout</button></a></li>
        </ul>
    </nav>
    <div id="content_area">
        <div id="list">
            <h3 id="listHeader">Submission List</h3>
            <?php
            if ($result_assignments->num_rows > 0) {
                while ($row_assignment = $result_assignments->fetch_assoc()) {
                    echo "<div class='assignment'>";
                    echo "<p><a href='grade_assignments.php?assignment_id=" . $assignment_id . "&student_id=" . $row_assignment['student_id'] . "'>" . $row_assignment['name'] . "</a>";
                    echo "Submission Date: " . $row_assignment['submitted_at'];
                    echo "<a href='" . $row_assignment['file_path'] . "' target='_blank'>View Assignment</a></p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No assignments found</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>