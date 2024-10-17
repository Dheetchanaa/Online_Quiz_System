<?php
session_start();
include 'db_connect.php';

$questions = [];
$marks = 0; 
$totalQuestions = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['answers'])) {
        foreach ($_POST['answers'] as $question_id => $selected_answer) {

            $stmt = $conn->prepare("SELECT correct_answer FROM questions WHERE id = ?");
            $stmt->bind_param("i", $question_id);
            $stmt->execute();
            $stmt->bind_result($correct_answer);
            $stmt->fetch();

            if ($selected_answer == $correct_answer) {
                $marks++;
            }
            $stmt->close();
        }
    }
}

$result = $conn->query("SELECT * FROM questions");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
        $totalQuestions++;
    }
}
$conn->close(); // Close the connection here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz</title>
    <link rel="stylesheet" href="quiz_style.css">
</head>
<body>
    <div class="container">
        <h1>Take Quiz</h1>
        <a href="index.html" class="home-button">Home</a> <!-- Home button -->
        <form method="POST">
            <?php foreach ($questions as $q): ?>
                <div class="question-block">
                    <p><?php echo htmlspecialchars($q['question']); ?></p>
                    <div>
                        <label>
                            <input type="radio" name="answers[<?php echo $q['id']; ?>]" value="1"> <?php echo htmlspecialchars($q['option1']); ?>
                        </label><br>
                        <label>
                            <input type="radio" name="answers[<?php echo $q['id']; ?>]" value="2"> <?php echo htmlspecialchars($q['option2']); ?>
                        </label><br>
                        <label>
                            <input type="radio" name="answers[<?php echo $q['id']; ?>]" value="3"> <?php echo htmlspecialchars($q['option3']); ?>
                        </label><br>
                        <label>
                            <input type="radio" name="answers[<?php echo $q['id']; ?>]" value="4"> <?php echo htmlspecialchars($q['option4']); ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit">Submit Answers</button>
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div style="margin-top: 20px;">
                <h2>Your Score: <?php echo $marks; ?> out of <?php echo $totalQuestions; ?></h2>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
