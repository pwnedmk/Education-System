<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_name = "educationsystem";
    $db_user = "admin";
    $db_passwd = "admin";
    $db = new mysqli("localhost", $db_user, $db_passwd, $db_name);
    $examID = isset($_POST['exam_id']) ? $_POST['exam_id'] : null;
    $feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';
    $questions = $_POST['questions'] ?? [];
    foreach ($questions as $index => $response) {
        $questionId = (int)$response['question_id'];
        $isCorrect = (int)$response['correct'];
        $query = "UPDATE checkQuestions SET graded = 1 WHERE exam_id = ? AND question_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('siii', $feedback, $isCorrect, $examID, $questionId);
        $stmt->execute();

        if ($stmt->error) {
            echo "Database error: " . $stmt->error;
        }
    }

    echo "Exam processed successfully!";
    header("location: /education-system/teachers_page.php");
}
?>