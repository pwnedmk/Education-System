<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "educationsystem";

// Connecting to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Test the connection
$sql = "SELECT 1";
$result = $conn->query($sql);

$sql = "SELECT 1";
$result = $conn->query($sql);

if ($result !== false) {
    echo "Database connection successful.\n";
} else {
    echo "Database connection failed.\n";
}

// Target directory
$targetDir = "uploads/";

// Check if the directory exists and is writable
if (!is_dir($targetDir) || !is_writable($targetDir)) {
    echo "Target directory does not exist or is not writable.\n";
    exit();
}

if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $originalFileName = basename($_FILES['file']["name"]);
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $baseName = pathinfo($originalFileName, PATHINFO_FILENAME);
    $counter = 1;
    $fileName = $originalFileName;
    $targetPath = $targetDir . $fileName;

    // Check and modify the filename if it already exists in the directory
    while (file_exists($targetPath)) {
        $fileName = $baseName . "(" . $counter . ")." . $extension;
        $targetPath = $targetDir . $fileName;
        $counter++;
    }

    // Moving the file to target path
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath)) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $due_date = $_POST['due_date'];
        $score = $_POST['score'];

        $logMessage = "Teacher Assignment Upload - Title: " . $title . "\n";

        // Append log message to notifications.txt
        file_put_contents('notifications.txt', $logMessage, FILE_APPEND);

        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO teacher_assignments (title, description, file_path, max_score, due_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error . "\n";
            exit();
        }

        $stmt->bind_param("sssis", $title, $description, $targetPath, $score, $due_date);

        if ($stmt->execute()) {
            echo "Assignment uploaded successfully and saved to teacher_assignments table\n";
            $assignmentId = $conn->insert_id;

        } else {
            echo "Error inserting assignment: " . $stmt->error . "\n";
        }

        $stmt->close();
    } else {
        echo "Error moving the file\n";
    }
} else {
    echo "File not uploaded\n";
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
            <li><a href="teacher_page.php">Home</a></li>
            <li><a href="studentlist.php">Student List</a></li>
            <li><a href="upload_assignment.php?user_type=teacher">Create Assignment</a></li>
            <li><a href="exam.html">Create Test/Quiz</a></li>
            <li><a href="logout.php"><button>Logout</button></a></li>
        </ul>
    </nav>
    <div class="container">
        <h2 id="h2">Upload Assignment</h2>
        <form method="POST" action="" enctype="multipart/form-data" class="upload-form">
            <div class="form-group">
                <label for="file">Assignment File:</label>
                <input id="chooseFile" type="file" name="file" required>
            </div>
            
            <?php if ($_GET['user_type'] === 'teacher'): ?>
                <div class="form-group">
                    <label for="title">Title:</label>
                    <div id="titl">
                    <input type="text" name="title" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="desc" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="due_date">Due Date:</label>
                    <input type="date" name="due_date" id="due_date" required>
                </div>
                <div class="form-group">
                    <label for="score">Score:</label>
                    <input type="number" name="score" id="score" required>
                </div>
            <?php endif; ?>
            <div class="submit">
            <input type="hidden" name="user_type" value="<?php echo $_GET['user_type']; ?>">
            <input id="submit" type="submit" value="Upload Assignment" class="btn">
            </div>
        </form>
    </div>
</body>
</html>