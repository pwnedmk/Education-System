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
$sql_teacher_id = "SELECT id FROM login WHERE userID = '$logged_in_username'";
$result_teacher_id = $conn->query($sql_teacher_id);

if ($result_teacher_id->num_rows == 0) {
    header("Location: login.php");
    exit();
}

// Retrieve the list of assignments from the teacher_assignments table
$sql_assignments = "SELECT  id, title, file_path, due_date FROM teacher_assignments";
$result_assignments = $conn->query($sql_assignments);

// Retrieve student scores data from the database
$query = "SELECT ss.score, ta.max_score FROM student_submissions ss JOIN teacher_assignments ta ON ss.assignment_id = ta.id WHERE ss.graded = 1";
$result = $conn->query($query);

// Count the number of scores in each range
$grades = array(
    'A' => 0,
    'B' => 0,
    'C' => 0,
    'D' => 0,
    'Failing' => 0
);

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
    <title>Teacher Page</title>
    <script src="javascript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" type="text/css" href="test4.css">
    <style>
        /* CSS for truncating long titles */
        .truncated-title {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
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
            <h3 id="listHeader">Assignment List</h3>
            <?php
            if ($result_assignments->num_rows > 0) {
                while ($row_assignment = $result_assignments->fetch_assoc()) {
                    // Truncate long titles
                    $title = $row_assignment['title'];
                    if (strlen($title) > 20) {
                        $title = mb_substr($title, 0, 5, "utf-8") . ".....";
                    }
                    echo "<p><a href='assignment_submissions.php?assignment_id=" . $row_assignment['id'] . "'>" . $title . "</a>";
                    echo "<a href='" . $row_assignment['file_path'] . "' target='_blank'>View Assignment</a>";
                    echo "Due Date: " . $row_assignment['due_date'] . " </p>";
                }
            } else {
                echo "<p>No assignments found</p>";
            }
            ?>
        </div>
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
                <canvas id="scorePieChart"></canvas>
            </div>
            <div class="col3" id="top_performer">
                <ul>
                    <li>.</li>
                    <li>top performer</li>
                    <li>.</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Get the canvas element
        var ctx = document.getElementById('scorePieChart').getContext('2d');

        // Create the pie chart
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['A', 'B', 'C', 'D', 'Failing'],
                datasets: [{
                    data: [<?php echo implode(',', $grades); ?>],
                    backgroundColor: ['green', 'lime', 'yellow', 'orange', 'red']
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Student Score Distribution'
                }
            }
        });
    </script>
</body>
</html>
