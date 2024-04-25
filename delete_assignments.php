<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit();
}

// Check if delete button is clicked
if (isset($_POST["delete_submit"]) && isset($_POST["delete_due_dates"])) {
    // Connect to the database
    $servername = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "educationsystem";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete student submissions for selected assignments
    foreach ($_POST["delete_due_dates"] as $assignment_id) {
        $sql_delete_submissions = "DELETE FROM student_submissions WHERE assignment_id = $assignment_id";
        if ($conn->query($sql_delete_submissions) === FALSE) {
            echo "Error deleting submissions: " . $conn->error;
        }
    }

    // Delete assignments
$sql_delete_assignments = "DELETE FROM teacher_assignments WHERE id IN (" . implode(",", $_POST["delete_due_dates"]) . ")";
if ($conn->query($sql_delete_assignments) === TRUE) {
    echo "Selected assignments deleted successfully";
    echo "<script>window.location.href = 'teacher_page.php';</script>"; // 삭제 후 선생님 페이지로 이동
} else {
    echo "Error deleting assignments: " . $conn->error;
}

$conn->close();
} else {
    echo "No assignments selected for deletion";
}
?>
