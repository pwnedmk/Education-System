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

if ($result !== false) {
    echo "Database connection successful.
";
} else {
    echo "Database connection failed.
";
}

// Target directory
$targetDir = "uploads/";

// Check if the directory exists and is writable
if (!is_dir($targetDir) || !is_writable($targetDir)) {
    echo "Target directory does not exist or is not writable.
";
    exit();
}

if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $fileName = basename($_FILES['file']["name"]);
    $targetPath = $targetDir . $fileName;

    // Moving the file to target path
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath)) {
        $title = $_POST['title'];
        $description = $_POST['description'];

        echo "Title: " . $title . "
";
        echo "Description: " . $description . "
";
        echo "File Path: " . $targetPath . "
";

        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO teacher_assignments (title, description, file_path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error . "
";
            exit();
        }

        $stmt->bind_param("sss", $title, $description, $targetPath);

        if ($stmt->execute()) {
            echo "Assignment uploaded successfully and saved to teacher_assignments table";
        } else {
            echo "Error: " . $sql . " Error Details: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error moving the file";
    }
} else {
    echo "File not uploaded";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Assignment</title>
    <link rel="stylesheet" type="text/css" href="test4.css">
    <style>
   
</style>
</head>
<body>
    <nav id="menu_area">
        <ul>
            <li><a href="teacher_page.php">Home</a></li>
            <li><a href="studentlist.php">Student List</li>
            <li><a href="upload_assignment.php?user_type=teacher">Create Assignment</a></li> 
            <li>Grade Assignment</li>
            <li>Calendar</li>
        </ul>
    </nav>
    <div class="container">
        <h2 id =h2 >Upload Assignment</h2>
        <form method="POST" action="" enctype="multipart/form-data" class="upload-form">
            <div class="form-group">
                <label for="file">Assignment File:</label>
                <input id=chooseFile type="file" name="file" required>
            </div>
            
            <?php if ($_GET['user_type'] === 'teacher'): ?>
                <div class="form-group">
                    <label for="title">Title:</label>
                    <div id= titl>
                    <input type="text" name="title" required>
            
            </div>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea  id= desc name="description" required></textarea>
                </div>
            <?php endif; ?>
            <div class="submit">
            <input type="hidden" name="user_type" value="<?php echo $_GET['user_type']; ?>">
            <input id= submit type="submit" value="Upload Assignment" class="btn">
            </div>
        </form>
    </div>
</body>
</html>