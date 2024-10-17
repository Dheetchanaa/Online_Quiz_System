<?php
session_start();
include 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['question_id'])) {
    $question_id = $_POST['question_id'];

    $stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $stmt->close();

    header("Location: create_quiz.php");
    exit;
}
$conn->close();