<body>
<form method="POST" action="sendExam.php">
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
$getExamTitle = "select title from exam where exam_id = " . $examID;
$title = $db->query($getExamTitle);
$row = $title->fetch_assoc();
echo "<h2>" . $row['title'] . "</h2>";
$getExam = "Select question, checkQuestions.question_id, student_username, currentGrade, type from checkQuestions join questions on checkQuestions.question_id = questions.question_id where checkQuestions.exam_id = $examID && graded = 0 group by question_id";
$examResult = $db->query($getExam);
if ($examResult->num_rows > 0) {
    $exam = array();
    while ($row = $examResult->fetch_assoc()) {
        $exam[] = $row;
    }
} 
$index = 0;
foreach ($exam as $row) {
    $current_grade = $row["currentGrade"];
    $type = $row['type'];
    $question = $row['question'];
    $questionId = $row['question_id'];
    $current_student = $row["student_username"];
    $answersQuery = "select answer from answers where question_id = $questionId";
    $answersResult = $db->query($answersQuery);
    $answer = $answersResult->fetch_assoc()['answer'];
    if ($type == "FI"){
        echo "<div class='qnas'>$question
        <br><br><p>Answer:" . $answer . "</p></div><br>
        <label for='" . $index . "y'>Correct</label>
        <input type='radio' name='" . $index . "y' value='1'>
        <label for='" . $index . "n'>A</label>
        <input type='radio' name='" . $index . "n' value='0'>";

    }
    else {
        echo "<div class='qnas'>$question
        <br><br><p>Answer:" . $answer . "</p></div><br><br>
        <label for='" . $index . "y'>Correct</label>
        <input type='radio' name='" . $index . "y' value='1'>
        <label for='" . $index . "n'>A</label>
        <input type='radio' name='" . $index . "n' value='0'>";
    }
    $index++;
}
?>
<input type="text" id="feedback" placeholder="Give feedback here!">
<input type="submit" class="submit" id="submitS" exam-id="<?php echo $examID; ?>" value="Submit">
<div id="error"></div>
</form>
</body>
</html>