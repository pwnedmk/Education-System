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

// Retrieve the student ID based on the logged-in username
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "educationsystem";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$logged_in_username = $_SESSION["Username"];
$sql_student_id = "SELECT id FROM login WHERE userID = '$logged_in_username'";
$result_student_id = $conn->query($sql_student_id);

if ($result_student_id->num_rows == 0) {
    header("Location: login.php");
    exit(); 
} 

$row_student_id = $result_student_id->fetch_assoc();
$student_id = $row_student_id['id'];

// Retrieve the list of assignments and feedback for the student
$sql_assignments_feedback = "SELECT ta.id, ta.title, ta.max_score, ss.score, ss.feedback FROM teacher_assignments ta JOIN student_submissions ss ON ss.assignment_id = ta.id WHERE ss.student_id = $student_id";
$result_assignments_feedback = $conn->query($sql_assignments_feedback);   

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>student</title>
    <script src="javascript.js"></script>
    <link rel="stylesheet" type="text/css" href="test4.css">
</head>
<body>
    <nav id="menu_area">
        <ul>
            <li><a href="student_page.php">Home</a></li>
            <li><a href="check_grades.php">Check Grades</a></li>
            <!-- <li><a href="student_upload.php">upload assignment</a></li> -->
            <!-- <li><a href="takeExam.php?examID=29">Sample Test/Quiz</a></li> -->
            <li><a href="logout.php"><button>Logout</button></a></li>
        </ul>
    </nav>
    <div id="content_area">
    <div id="list">
        <h3 id="listHeader">Grades</h3>
        <?php
        if ($result_assignments_feedback->num_rows > 0) {
            while ($row_assignment_feedback = $result_assignments_feedback->fetch_assoc()) {
                echo "<p style='background-color: white, color: red;'> Assignment Title:&nbsp;" . $row_assignment_feedback['title'];
                echo "<a>Score: " . $row_assignment_feedback['score'] . "&nbsp;/&nbsp;" . $row_assignment_feedback['max_score'] . "</a></hr>";
                echo "<p><b>Feedback:</b> " . $row_assignment_feedback['feedback'] . "</p>";
                echo "</p>";
            }
        } else {
            echo "<p>No assignments found</p>";
        }
        ?>
    </div>
    <!-- Rest of the code remains the same -->
    
        <hr>
        <div id="horizontal_section">
            <div class="col1" id="calendar">
                <div class="sec_cal">
                    <div class="cal_nav">
                        <a href="javascript:;" class="nav-btn go-prev">prev</a>
                        <div class="year-month"></div>
                        <a href="javascript:;" class="nav-btn go-next">next</a>
                    </div>
                    <div class="cal_wrap">
                        <div class="days">
                            <div class="day">MON</div>
                            <div class="day">TUE</div>
                            <div class="day">WED</div>
                            <div class="day">THU</div>
                            <div class="day">FRI</div>
                            <div class="day">SAT</div>
                            <div class="day">SUN</div>
                        </div>
                        <div class="dates"></div>
                    </div>
                </div>
            </div>
            
            <div class="col2" id="none">
                <img src="wsulogo.jpg" style="width:290px; height: 240px;" alt="candy">
            </div>
            
            <div class="col3" id="top_performer">
                <ul>
                    <li>.</li>
                    <li></li>
                    <li>.</li>
                </ul>
            </div>
        </div>
        </div>
    </div>
</body>
</html>
