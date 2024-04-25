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

$query = "SELECT ss.score, ta.max_score FROM student_submissions ss JOIN teacher_assignments ta ON ss.assignment_id = ta.id WHERE ss.graded = 1 AND ss.assignment_id = " . $assignment_id;
$result = $conn->query($query);

$grades = [
    'A' => 0,
    'B' => 0,
    'C' => 0,
    'D' => 0,
    'Failing' => 0
];

while ($row = $result->fetch_assoc()) {
    $percentage = (double) $row['score'] / (double) $row['max_score'] * 100;

    if ($percentage >= 90) {
        $grades['A']++;
    } else if ($percentage >= 80) {
        $grades['B']++;
    } else if ($percentage >= 70) {
        $grades['C']++;
    } else if ($percentage >= 60) {
        $grades['D']++;
    } else {
        $grades['Failing']++;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Submissions</title>
    <link rel="stylesheet" type="text/css" href="test4.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <canvas id="submissionChart"></canvas>
        <script>document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('submissionChart').getContext('2d');
            const chartData = {
                labels: Object.keys(<?php echo json_encode($grades); ?>),
                datasets: [{
                    data: Object.values(<?php echo json_encode($grades); ?>),
                    backgroundColor: ['green', 'lime', 'yellow', 'orange', 'red']
                }]
            };
            const submissionChart = new Chart(ctx, {
                type: 'pie',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: { enabled: true }
                    }
                }
            });
        });
        </script>
    </div>
    </body>
</html>