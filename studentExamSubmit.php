<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$user = $_SESSION["Username"];
$examID = $_GET["examID"];
$db_name = "educationsystem";
$db_user = "Myles";
$db_passwd = "password";
$db = new mysqli("localhost", $db_user, $db_passwd, $db_name);
$grade = 0;
$checkQuestionIDs = array();
foreach ($_POST as $name => $value) {
    list($type, $index, $questionId) = explode('_', $name);
    $query = "INSERT INTO student_answers (student_username, exam_id, question_id, answer) VALUES ('$user', '$examID', '$questionId', '$value')";
    $db->query($query) or die("Database Error: " . $db->error);
    $queryQuestion = "Select type from questions where question_id = $questionId";
    $resultType = $db->query($queryQuestion)->fetch_assoc();
    $type = $resultType['type'];
    if ($type == "MC"){
        $queryAnswers = "select answer from answers where question_id = $questionId";
        $MCanswer = $db->query($queryAnswers)->fetch_assoc()['answer'];
        if ($MCanswer == $value){
            $grade++;
        }
    }
    elseif ($type == "FI"){
        $queryAnswers = "select answer from answers where question_id = $questionId";
        $FIanswer = $db->query($queryAnswers)->fetch_assoc()['answer'];
        if ((int)$FIanswer == (int)$value){
            $grade++;
        }
        else{
            array_push($checkQuestionIDs, $questionId);
        }
    }
    elseif ($type == "ES"){
        array_push($checkQuestionIDs, $questionId);
    }
}
$responseData = ['grade' => $grade, 'checkQuestionIDs' => $checkQuestionIDs];
echo json_encode($responseData);
?>