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

// Retrieve assignment and student id from array
$assignment_id = $_GET['assignment_id'];
$student_id = $_GET['student_id'];
$max_score;

$sql_max_score = "SELECT max_score FROM teacher_assignments WHERE id = ?";
$stmt_max_score = $conn->prepare($sql_max_score);
$stmt_max_score->bind_param("i", $assignment_id);
$stmt_max_score->execute();
$stmt_max_score->bind_result($max_score);
$stmt_max_score->fetch();
$stmt_max_score->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $score = $_POST['score'];
    $feedback = $_POST['feedback'];
    $assignment_id = $_GET['assignment_id'];
    $student_id = $_GET['student_id'];

    // Check if the assignment exists for the student
    $sql_check_assignment = "SELECT * FROM student_submissions WHERE student_id = $student_id AND assignment_id = $assignment_id";
    $result_check_assignment = $conn->query($sql_check_assignment);

    if ($result_check_assignment->num_rows > 0) {
        // Assignment exists, update the score and feedback
        $calculated_score = (double)$score / (double)$max_score;
        $sql_update_score = "UPDATE student_submissions SET score = ?, feedback = ? WHERE student_id = ? AND assignment_id = ?";
        $stmt = $conn->prepare($sql_update_score);
        $stmt->bind_param("dsii", $calculated_score, $feedback, $student_id, $assignment_id);
        $stmt->execute();
        $stmt->close();
        echo "Score and feedback updated successfully!";
    } else {
        echo "Assignment not found for the student.";
    }
}

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
    <div class="container">
        <h2 id="h2">Input Score</h2>
        <form method="POST" action="" enctype="multipart/form-data" class="upload-form">
            <div class="form-group">
                <label id="score" for="score">Score: </label>
                <input type="number" name="score" id="score" required>
                <?php echo "<span class='score-info'>&nbsp;/&nbsp;$max_score</span>"; ?>
            </div>
            <div class="form-group">
                <label for="feedback">Feedback:</label>
                <textarea id="feedback" name="feedback" style="width: 400px;height:138px;" required></textarea>
            </div>
            <div class="submit">
                <input id="submit" type="submit" value="Upload Assignment" class="btn">
            </div>
        </form>
    </div>
</body>
</html>
