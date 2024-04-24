<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            margin: 20px;
            padding: 0;
            font-family: sans-serif;
            background: #f2f2f2;
        }
        .submit {
            color: rgb(0, 0, 0);
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }
        .qnas {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .qnas input[type="text"],
        .qnas input[type="radio"] {
            margin-right: 10px;
        }

        .qnas label {
            font-weight: bold;
            margin-right: 5px;
        }

        .qnas span {
            margin-right: 10px;
        }

    </style>
</head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$examID = $_GET["examID"];
$db_name = "educationsystem";
$db_user = "admin";
$db_passwd = "admin";
$db = new mysqli("localhost", $db_user, $db_passwd, $db_name);
$getExamTitle = "select title from exam where exam_id = " . $examID;
$title = $db->query($getExamTitle);
$row = $title->fetch_assoc();
echo "<h2>" . $row['title'] . "</h2>";
$getExam = "Select question, type, question_id from questions where exam_id = $examID";
$examResult = $db->query($getExam);
if ($examResult->num_rows > 0) {
    $exam = array();
    while ($row = $examResult->fetch_assoc()) {
        $exam[] = $row;
    }
} 
$index = 0;
foreach ($exam as $row) {
    $type = $row['type'];
    $question = $row['question'];
    if ($type == "MC"){
        $questionId = $row['question_id'];
        $answersQuery = "select answer from answers where question_id = $questionId";
        $MCanswers = $db->query($answersQuery);
        if ($MCanswers->num_rows > 0) {
            $answers = array();
            while ($row = $MCanswers->fetch_assoc()) {
                $answers[] = $row['answer'];
            }
        } 
        echo "<div class='qnas'>" . $question . "
        <br><br>
        <label for='" . $type . $index . "a'>A</label>
        <input type='radio' id='" . $type . $index . "a' name='" . $type . "a[" . $index . "]' value='1'>
        <span>" . $answers[0] . "</span><br>
        <label for='" . $type . $index . "b'>B</label>
        <input type='radio' id='" . $type . $index . "b' name='" . $type . "a[" . $index . "]' value='2'>
        <span>" . $answers[1] . "</span><br>
        <label for='" . $type . $index . "c'>C</label>
        <input type='radio' id='" . $type . $index . "c' name='" . $type . "a[" . $index . "]' value='3'>
        <span>" . $answers[2] . "</span><br>
        <label for='" . $type . $index . "d'>D</label>
        <input type='radio' id='" . $type . $index . "d' name='" . $type . "a[" . $index . "]' value='4'>
        <span>" . $answers[3] . "</span><br>
        </div><br>";
    }
    else if ($type == "FI"){
        echo "<div class='qnas'>$question
        <br><br><input type='text' name='" . $type . "a[" . $index . "]' placeholder='Enter an Answer'></div><br><br>";
    }
    else {
        echo "<div class='qnas'>$question
        <br><br><input type='text' name='" . $type . "a[" . $index . "]' placeholder='Enter an Answer'></div><br><br>";
    }
    $index++;
}
?>
<button class="submit" id="submit">Submit</button>
</body>
</html>