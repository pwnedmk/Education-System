<?php
    $servername = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "educationsystem";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $selected_students = $_POST['selected_students'];

    if (!empty($selected_students)) {
        foreach ($selected_students as $email) {
            
            $sql = "DELETE FROM login WHERE email = '$email'";
            
        
            mysqli_query($conn, $sql);
        }

    
        echo "<script>alert('Selected user has been deleted.');</script>";
    } else {

        echo "<script>alert('Please select a user to delete.');</script>";
    }

    echo "<meta http-equiv='refresh' content='0;url=/Education-system/studentlist1.php'>";

    mysqli_close($conn);
?>
