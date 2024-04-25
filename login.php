<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body id="blur">
    <div class="wrapper">
        <form method="POST">
            <div class="login-box">
                <h1>Login</h1>
                <div id="loginForm">
                    <div class="textbox">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <input id="user" type="text" name="userID" placeholder="Username">
                    </div>
                    <div class="textbox">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        <input id="pass" type="password" name="pass" placeholder="Password">
                    </div>
                    <button class="button" name="sub" type="submit">Login</button>
                </div>
                <br>
                <input type="radio" name="STAButton" class="STAState" checked id="StudentButton" value="student"/>
                <label class="STA" for="StudentButton">Student</label>
                <input type="radio" name="STAButton" class="STAState" id="TeacherButton" value="teacher"/>
                <label class="STA" for="TeacherButton">Teacher</label>
                <input type="radio" name="STAButton" class="STAState" id="AdminButton" value="admin"/>
                <label class="STA" for="AdminButton">Admin</label>
            </div>
        </form>
        <div id="message">
            <h3>Password must contain the following:</h3>
            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
            <p id="number" class="invalid">A <b>number</b></p>
            <p id="length" class="invalid">Between <b>8 and 24 characters</b></p>
            <p id="special" class="invalid">A <b>special character</b> (!, @, #, $ ...)</p>
        </div>
    </div>
    <?php
        // Report all error information on the webpage
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if (isset($_POST['sub'])) {
            $type = $_POST["STAButton"];
            $servername = "localhost";
            $username = "admin"; 
            $password = "admin"; 
            $dbname = "educationsystem";
        
            // Create connection
            $db = new mysqli($servername, $username, $password, $dbname);
            $check = 0;

            // Check connection
            if ($db->connect_error) {
                die("Connection failed: " . $db->connect_error);
            }
    
            // Use prepared statement in SQL
            
            $user = $_POST['userID'];
            $pass = $_POST['pass'];
            $sql = "SELECT userID, password FROM login where type = '" . $type . "'";
    
            $result = $db->query($sql);
            
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) { // info about query"https://www.w3schools.com/php/php_mysql_select.asp
                    if ($row["userID"] == $user) {
                        $check = 1;
                        if ($row["password"] != $pass) {
                            echo '<script>alert("Username does not match password")</script>';
                        } else {
                            $sql = "SELECT ID FROM login where userID = '" . $user . "'";
                            $id = $db->query($sql)->fetch_object()->ID;

                            session_start();
                            $_SESSION["Username"] = $user;
                            $_SESSION["ID"] = $id;
                            header("Location: " . $type . "_page.php");
                            exit();
                        }
                    }
                }
                if ($check == 0) {
                    echo ('<script>alert("Username does not exist under type "' . $type . '")</script>');
                }
            }
            $result->close();
            $db->close();
        }
    ?>

    <script>
        var myInput = document.getElementById("new_pass");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");
        var special = document.getElementById("special");
        var checker = true;

        // When the user clicks on the password field, show the message box
        myInput.onfocus = function() {
            document.getElementById("message").style.display = "block";
        }

        // When the user starts to type something inside the password field
        myInput.onkeyup = function() {

            // Define your variables in an array
            var booleans = [true, true, true, true, true,];

            // Validate lowercase letters
            var lowerCaseLetters = /[a-z]/g;
            if(myInput.value.match(lowerCaseLetters)) {
                booleans[0] = false;
                letter.classList.remove("invalid");
                letter.classList.add("valid");
            } else {
                booleans[0] = true;
                letter.classList.remove("valid");
                letter.classList.add("invalid");
            }

            // Validate capital letters
            var upperCaseLetters = /[A-Z]/g;
            if(myInput.value.match(upperCaseLetters)) {
                booleans[1] = false;
                capital.classList.remove("invalid");
                capital.classList.add("valid");
            } else {
                booleans[1] = true;
                capital.classList.remove("valid");
                capital.classList.add("invalid");
            }

            // Validate numbers
            var numbers = /[0-9]/g;
            if(myInput.value.match(numbers)) {
                booleans[2] = false;
                number.classList.remove("invalid");
                number.classList.add("valid");
            } else {
                booleans[2] = true;
                number.classList.remove("valid");
                number.classList.add("invalid");
            }

            var specials = /[^a-zA-Z0-9]/g;
            if(myInput.value.match(specials)) {
                booleans[3] = false;
                special.classList.remove("invalid");
                special.classList.add("valid");
            } else {
                booleans[3] = true;
                special.classList.remove("valid");
                special.classList.add("invalid");
            }

            // Validate length
            if(myInput.value.length >= 8 && myInput.value.length <= 24) {
                booleans[4] = false;
                length.classList.remove("invalid");
                length.classList.add("valid");
            } else {
                booleans[4] = true;
                length.classList.remove("valid");
                length.classList.add("invalid");
            }

            if (booleans.some(val => val === true)) {
                document.getElementById("newUserButton").disabled = true;
            } else {
                document.getElementById("newUserButton").disabled = false;
            }
        }
    </script>
</body>
</html>
