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
$sql_scores = "SELECT score FROM student_submissions";
$result_scores = $conn->query($sql_scores);

$scores = array();
while ($row_score = $result_scores->fetch_assoc()) {
    $scores[] = $row_score['score'];
}

// Count the number of scores in each range
$scoreRanges = array(
    '0-25' => 0,
    '26-50' => 0,
    '51-75' => 0,
    '76-100' => 0
);

foreach ($scores as $score) {
    if ($score >= 0 && $score <= 25) {
        $scoreRanges['0-25']++;
    } elseif ($score >= 26 && $score <= 50) {
        $scoreRanges['26-50']++;
    } elseif ($score >= 51 && $score <= 75) {
        $scoreRanges['51-75']++;
    } elseif ($score >= 76 && $score <= 100) {
        $scoreRanges['76-100']++;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test</title>
    <script src="javascript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <h3 id="listHeader">Assignment List</h3>
            <?php
            if ($result_assignments->num_rows > 0) {
                while ($row_assignment = $result_assignments->fetch_assoc()) {
                    echo "<p><a href='assignment_submissions.php?assignment_id=" . $row_assignment['id'] . "'>" . $row_assignment['title'] . "</a>";
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
                labels: ['0-25', '26-50', '51-75', '76-100'],
                datasets: [{
                    data: [<?php echo implode(',', $scoreRanges); ?>],
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0']
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