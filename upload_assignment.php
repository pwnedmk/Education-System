<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Assignment</title>
    <link rel="stylesheet" type="text/css" href="test2.css">
</head>
<body>
<nav id="menu_area">
        <ul>
            <li><a href="teachers_page.php">Home</a></li>
            <li>Student List</li>
            <li><a href="upload_assignment.php">Create Assignment</a></li>
            <li>Grade Assignment</li>
            <li>Calendar</li>
        </ul>
    </nav>
    <div class="container">
        <h2>Upload Assignment</h2>
        <form method="POST" action="upload_assignment.php" enctype="multipart/form-data" class="upload-form">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="file">Assignment File:</label>
                <input type="file" name="file" required>
            </div>
            <input type="submit" value="Upload Assignment" class="btn">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $description = $_POST["description"];
            $file_name = $_FILES["file"]["name"];
            $file_tmp = $_FILES["file"]["tmp_name"];
            $file_path = "uploads/" . $file_name;

            if (move_uploaded_file($file_tmp, $file_path)) {
                $servername = "localhost";
                $username = "admin";
                $password = "admin";
                $dbname = "educationsystem";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "INSERT INTO assignments (title, description, file_path) VALUES ('$title', '$description', '$file_path')";
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='success-message'>Assignment uploaded successfully.</div>";
                } else {
                    echo "<div class='error-message'>Error uploading assignment: " . $conn->error . "</div>";
                }

                $conn->close();
            } else {
                echo "<div class='error-message'>Error uploading file.</div>";
            }
        }
        ?>
    </div>
</body>
</html>