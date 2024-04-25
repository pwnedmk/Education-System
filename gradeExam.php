<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$user = $_SESSION["Username"];
$grade = isset($_GET['grade']) ? $_GET['grade'] : null;
$examID = isset($_GET['examID']) ? $_GET['examID'] : null;
$checkQuestionIDs = [];
$db_name = "educationsystem";
$db_user = "admin";
$db_passwd = "admin";
$db = new mysqli("localhost", $db_user, $db_passwd, $db_name);
foreach ($_GET as $key => $value) {
    if (strpos($key, 'array[') === 0 && substr($key, -1) === ']') {
        $index = substr($key, 6, -1);
        $checkQuestionIDs[(int)$index] = (int)$value;
    }
}
foreach ($checkQuestionIDs as $i){
    $insertQuery = "insert into checkQuestions (question_id, student_username, exam_id, currentGrade) values ($i, $user, $examID, $grade)";
    $db->query($insertQuery);
}
echo "<h3>Exam submitted. Current grade of multiple choice and fill in the blank is $grade</h3>";
?>
</body>
</html>

