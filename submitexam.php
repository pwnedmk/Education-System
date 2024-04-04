<?php
$length = $_POST["index"];
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$db_name = "educationsystem";
$db_user = "admin";
$db_passwd = "admin";
$db = new mysqli("localhost", $db_user, $db_passwd, $db_name);
$user = "Myles"; //change to session user later
$MCindex = 0;
$FIBindex = 0;
$EssayIndex = 0;
$AsToAdd = array();
$title = $_POST["title"];
$examQuery = "INSERT INTO exam (title) VALUES ('$title')";
$db->query($examQuery) or die("Database Error");
$exam_id = $db->insert_id;
if (isset($_POST["MCfq"])){
    $MCfq = $_POST["MCfq"];
    $MCq = $_POST["MCq"];
    $MCa = $_POST["MCa"];
    if (!empty($MCfq)) {
        $MCfq = array_values($MCfq);
        $MCq = array_values($MCq);
        $MCa = array_values($MCa);
    
        foreach ($MCfq as $index => $fqToAdd) {
            $MCaToAdd = $MCa[$index];
            $MCqsToAdd = $MCq[$index];
            echo($MCaToAdd);
    
            $questionsQuery = "INSERT INTO questions (question, type, exam_id) VALUES ('$fqToAdd', 'MC', '$exam_id')";
            $db->query($questionsQuery) or die("Database Error: MCq");
            $questionId = $db->insert_id;
    
            foreach ($MCqsToAdd as $subIndex => $MCqs) {
                if ($MCaToAdd - 1 == $subIndex){
                    $answersQuery = "INSERT INTO answers (answer, question_id, correct) VALUES ('$MCqs', $questionId, true)";
                }
                else{
                    $answersQuery = "INSERT INTO answers (answer, question_id, correct) VALUES ('$MCqs', $questionId, false)";
                }
                echo($answersQuery);
                $db->query($answersQuery) or die("Database Error: MCa");
            }
        }
    }
}
if (isset($_POST["FIq"])){
    $FIq = $_POST["FIq"];
    $FIa = $_POST["FIa"];
    if (!empty($FIq)) {
        $FIq = array_values($FIq);
        $FIa = array_values($FIa);

        foreach ($FIq as $index => $qToAdd) {
            $aToAdd = $FIa[$index];

            $questionsQuery = "INSERT INTO questions (question, type, exam_id) VALUES ('$qToAdd', 'FI', '$exam_id')";
            $db->query($questionsQuery) or die("Database Error: FIq");
            $questionId = $db->insert_id;

            $answersQuery = "INSERT INTO answers (answer, question_id, correct) VALUES ('$aToAdd', $questionId, true)";
            $db->query($answersQuery) or die("Database Error: FIa");
        }
    }
}
if (isset($_POST["ESq"])){
    $ESq = $_POST["ESq"];
    if (!empty($ESq)) {
        $ESq = array_values($ESq);

        foreach ($ESq as $index => $qToAdd) {
            $questionsQuery = "INSERT INTO questions (question, type, exam_id) VALUES ('$qToAdd', 'ES', '$exam_id')";
            $db->query($questionsQuery) or die("Database Error: ES");
        }
    }
}

?>