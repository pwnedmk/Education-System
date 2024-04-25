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

// Retrieve the list of assignments from the teacher_assignments table
$sql_assignments = "SELECT  id, title, file_path, due_date FROM teacher_assignments";
$result_assignments = $conn->query($sql_assignments);   

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Page</title>
    <script src="javascript.js"></script>
    <link rel="stylesheet" type="text/css" href="test4.css">
</head>
<body>
    <nav id="menu_area">
        <ul>
            <li><a href="student_page.php">Home</a></li>
            <li><a href="check_grades.php">Check Grades</a></li>
            <!-- <li><a href="student_upload.php">upload assignment</a></li> -->
            <li><a href="logout.php"><button>Logout</button></a></li>
        </ul>
    </nav>
    <div id="content_area">
    <div id="list">
        <h3 id="listHeader">Assignment List</h3>
        <?php
        if ($result_assignments->num_rows > 0) {
            while ($row_assignment = $result_assignments->fetch_assoc()) {
                $due_date = strtotime($row_assignment['due_date']);
                $current_date = time();
                if ($current_date <= $due_date) {
                    echo "<p style='background-color: white, color: red;'><a href='student_upload.php?assignment_id=" . $row_assignment['id'] . "'>" . $row_assignment['title'] . "</a>";
                    echo "<span style='margin-left: 10px;'>Due Date: " . $row_assignment['due_date'] . "</span>";
                    echo "<a href='" . $row_assignment['file_path'] . "' target='_blank'>View Assignment</a></hr>";
                } else {
                    echo "<p style='background-color: lightgray; color: black;'>Assignment Title:&nbsp;" . $row_assignment['title'];
                    echo "<span style='margin-left: 10px;'>Due Date: " . $row_assignment['due_date'] . "</span>";
                    echo "(Expired)";
                    echo "</p>";
                }
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
