<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
// if (!isset($_SESSION["Username"]) || $_SESSION["UserType"] != 'student') {
//     header("Location: login.php");
//     exit();
// }

$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "educationsystem";

$student_id = $_SESSION["ID"];

// Check if assignment_id is provided in the URL
if (isset($_GET['assignment_id'])) {
    $assignment_id = $_GET['assignment_id'];
    echo "Assignment ID: " . $assignment_id;
} else {
    echo "Assignment ID not provided.";
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES["file"]["tmp_name"];
    $file_path = "upload_stu/" . $file_name;

    // Check if the directory exists and is writable
    if (!is_dir("upload_stu") || !is_writable("upload_stu")) {
        echo "Upload directory does not exist or is not writable.";
        exit();
    }

    if (move_uploaded_file($file_tmp, $file_path)) {
        echo "Assignment ID: " . $assignment_id . "<br>";
        echo "Student ID: " . $student_id . "<br>";
        echo "File Path: " . $file_path . "<br>";

        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO student_submissions (assignment_id, student_id, file_path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
            exit();
        }
        
        $stmt->bind_param("iis", $assignment_id, $student_id, $file_path);
        if ($stmt->execute()) {
            echo "Assignment submitted successfully.";
        } else {
            echo "Error submitting assignment: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading file.";
    }

}
if (isset($_GET['assignment_id'])) {
    $assignment_id = $_GET['assignment_id'];
    echo "Assignment ID: " . $assignment_id;
} else {
    echo "Assignment ID not provided.";
    exit();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Upload Assignment</title>
    <link rel="stylesheet" type="text/css" href="test4.css">
</head>
<body>
    <nav id="menu_area">
        <ul>
            <li><a href="student_page.php">Home</a></li>
            <li><a href="check_grades.php">Check Grade</a></li>
            <!-- <li><a href="student_upload.php">Create Assignment</a></li> -->
            <li><a href="takeExam.php?examID=29">Sample Test/Quiz</a></li>
            <li><a href="logout.php"><button>Logout</button></a></li>
        </ul>
    </nav>
    <div class="container">
    <?php if (isset($assignment_id)): ?>
    <div class="container"> 
        <h2 id="h2-stu">Upload Assignment</h2>
        <form method="POST" action="" enctype="multipart/form-data" class="upload-form">
            <div class="form-group">
                <label id= ags_stu for="file">Assignment File:</label>
                <input id= file type="file" name="file" required>
                <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
            </div>
            <div id = submit-stu>
            <input type="submit" value="Submit Assignment" class="btn">
            
            </div>
        </form>
    </div>
    <?php endif; ?>
</body>
</html>