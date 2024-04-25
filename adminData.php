<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to the database
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "educationsystem";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT ss.score, ta.max_score FROM student_submissions ss JOIN teacher_assignments ta ON ss.assignment_id = ta.id WHERE ss.graded = 0";
$result = $conn->query($query);

$grades = [
    'A' => 0,
    'B' => 0,
    'C' => 0,
    'D' => 0,
    'Failing' => 0
];

while ($row = $result->fetch_assoc()) {
    $percentage = (double) $row['score'] / (double) $row['max_score'] * 100;

    if ($percentage >= 90) {
        $grades['A']++;
    } else if ($percentage >= 80) {
        $grades['B']++;
    } else if ($percentage >= 70) {
        $grades['C']++;
    } else if ($percentage >= 60) {
        $grades['D']++;
    } else {
        $grades['Failing']++;
    }
}

echo json_encode($grades);