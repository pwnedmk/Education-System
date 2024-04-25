<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
    <link rel="stylesheet" type="text/css" href="test4.css">
    
    
</head>
<body>



<!-- New User Form -->
<div id="container-admin">
    <h2>Create New User</h2>
    <form method="POST" action="admin_page.php">
        <div class="textbox">
            <label for="new_userID"></label>
            <input id="new_userID" type="text" name="new_userID" placeholder="Enter Username" required>
        </div>
        <div class="textbox">
            <label for="new_pass"></label>
            <input id="new_pass" type="password" name="new_pass" placeholder="Enter Password" required>
        </div>
        <div class="textbox">
            <label for="new_name"></label>
            <input id="new_name" type="text" name="new_name" placeholder="Enter Name" required>
        </div>
        <div class="textbox">
            <label for="new_email"></label>
            <input id="new_email" type="email" name="new_email" placeholder="Enter Email" required>
        </div>
        <div>
            <label for="userType">User Type:</label>
            <select id="userType" name="userType" required>
                <option value="teacher">Teacher</option>
                <option value="student">Student</option>
            </select>
            
            <button id="create" type="submit" name="submitNewUser">Create</button>
            
        </div>
        
    </form>
</div>

<?php

$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "educationsystem";


$db = new mysqli($servername, $username, $password, $dbname);


if ($db->connect_error) {
    die("fail to connect: " . $db->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["submitNewUser"])) {
        
        if (!empty($_POST["new_userID"]) && !empty($_POST["new_pass"]) && !empty($_POST["new_name"]) && !empty($_POST["new_email"]) && !empty($_POST["userType"])) {
            
            $user = $_POST["new_userID"];
            $pass = $_POST["new_pass"];
            $name = $_POST["new_name"];
            $email = $_POST["new_email"];
            $type = $_POST["userType"]; 

            
            $sql = "INSERT INTO login (userID, password, type, name, email) VALUES ('$user', '$pass', '$type', '$name', '$email')";

            
            if ($db->query($sql) === TRUE) {
                echo "new user created.";
            } else {
                echo "error: " . $sql . "<br>" . $db->error;
            }
        } else {
            echo ".";
        }
    }
}


$db->close();
?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var createUserBtn = document.getElementById('createUserBtn');
        var container = document.getElementById('container-admin');

        createUserBtn.addEventListener('click', function() {
            container.style.display = 'block';
        });
    });
</script>
</body>
</html>
