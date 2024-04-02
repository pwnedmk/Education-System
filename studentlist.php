<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="test3.css">
   
</head>
<body>
<nav id="menu_area">
    <ul>
        <li><a href="teachers_page.php">Home</a></li>
        <li><a href="studentlist.php">Student List</a></li>
        <li><a href="upload_assignment.php">Create Assignment</a></li>
        <li>Grade Assignment</li>
        <li>Calendar</li>
    </ul>
</nav>
<div id="list_area">
    <table class="list-table">
        <thead>
        <tr>
            <th width="70">Image</th>
            <th width="500">Name</th>
            <th width="150">Email</th>
        </tr>
        </thead>
        <?php
    
        $servername = "localhost";
        $username = "admin";
        $password = "admin";
        $dbname = "educationsystem";

    
        $conn = new mysqli($servername, $username, $password, $dbname);

        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $sql = "SELECT name, email FROM login WHERE type = 'student'";
        $result = $conn->query($sql);

        
        if ($result->num_rows > 0) {
            echo '<tbody>';

        
            while($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>Image</td>'; // 이미지를 넣을 열
                echo '<td>' . $row["name"] . '</td>'; // 이름 열
                echo '<td>' . $row["email"] . '</td>'; // 이메일 열
                echo '</tr>';
            }

            echo '</tbody>';
        } else {
            echo "<tbody><tr><td colspan='3'>No students found</td></tr></tbody>";
        }

        
        $conn->close();
        ?>
    </table>
</div>
</body>
</html>
