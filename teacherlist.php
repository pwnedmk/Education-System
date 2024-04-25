<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="test4.css">
   
</head>
<body>
<nav id="menu_area">
    <ul>
        <li><a href="admin_page.php">Home</a></li>
        <li><a href="studentlist1.php">Student List</a></li>
        <li><a href="teacherlist.php">Teacher List</a></li>
        <li><a href="createNewuser.php">Create New User</a></li>
        <li><a href="logout.php"><button>Logout</button></a></li>
    </ul>
</nav>
<div id="list_area">
<form action="delete_teacher.php" method="post">
    <table class="list-table">
        <thead>
        <tr>
            <th width="70">Image</th>
            <th width="500">Name</th>
            <th width="150">Email</th>
            <th width="50">Select</th>
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

        
        $sql = "SELECT name, email FROM login WHERE type = 'teacher'";
        $result = $conn->query($sql);

        
        if ($result->num_rows > 0) {
            echo '<tbody>';

        
            while($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>Image</td>'; 
                echo '<td>' . $row["name"] . '</td>'; 
                echo '<td>' . $row["email"] . '</td>'; 
                echo '<td><input type="checkbox" name="selected_teachers[]" value="' . $row["email"] . '"></td>';
                echo '</tr>';
            }

            echo '</tbody>';
        } else {
            echo "<tbody><tr><td colspan='3'>No teachers found</td></tr></tbody>";
        }

        
        $conn->close();
        ?>
    </table>
    <input id="delete" type="submit" value="Delete Selected Teachers">
    </form>
</div>
</body>
</html>
