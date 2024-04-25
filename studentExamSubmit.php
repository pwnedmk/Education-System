<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$user = $_SESSION["Username"];
$examID = $_GET["examID"];
$db_name = "educationsystem";
$db_user = "admin";
$db_passwd = "admin";
$db = new mysqli("localhost", $db_user, $db_passwd, $db_name);
$grade = 0;
$checkQuestionIDs = array();
foreach ($_POST as $name => $value) {
    list($type, $index, $questionId) = explode('_', $name);
    $query = "INSERT INTO student_answers (student_username, exam_id, question_id, answer) VALUES ('$user', '$examID', '$questionId', '$value')";
    $db->query($query) or die("Database Error: " . $db->error);
    if ($type == "MC"){
        $queryAnswers = "select answer, correct from answers where question_id = $questionId";
        $result = $db->query($queryAnswers);
        $MCanswers = $result->fetch_all(MYSQLI_ASSOC);
        $count = 0;
        foreach($MCanswers as $ans){
            $count++;
            if ($count == $value && $ans["correct"] == 1){
                $grade++;
            }
        }
    }
    elseif ($type == "FI"){
        $queryAnswers = "select answer from answers where question_id = $questionId";
        $FIanswer = $db->query($queryAnswers)->fetch_assoc()['answer'];
        if ((string)$FIanswer == (string)$value){
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

$notification_message = "Exam $examID has been submittedd by $user ($student_id).";
file_put_contents("notifications.txt", $notification_message . PHP_EOL, FILE_APPEND);

$responseData = ['grade' => $grade, 'checkQuestionIDs' => $checkQuestionIDs];
echo json_encode($responseData);
?>