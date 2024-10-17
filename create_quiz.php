<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.html");
    exit();
}

$questions = [];
$questionAdded = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['question'], $_POST['option1'], $_POST['option2'], $_POST['option3'], $_POST['option4'], $_POST['correct_answer'])) {
        $stmt = $conn->prepare("INSERT INTO questions (question, option1, option2, option3, option4, correct_answer) VALUES (?, ?, ?, ?, ?, ?)");
        
        if ($stmt === false) {
            die("Error preparing the statement: " . $conn->error);
        }

        $stmt->bind_param("sssssi", $_POST['question'], $_POST['option1'], $_POST['option2'], $_POST['option3'], $_POST['option4'], $_POST['correct_answer']);
        
        if ($stmt->execute()) {
            $questionAdded = true;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$result = $conn->query("SELECT * FROM questions");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Questions</title>
    <link rel="stylesheet" href="create_quiz.css">
</head>
<body>
    <div class="header">
        <div class="user-info">
            <p>Welcome, <?php echo $_SESSION['username']; ?>!</p><br>
            <a href="create_quiz.php?logout=true" class="logoutbutton">Logout</a>
        </div>
    </div>

    <div class="container">
        <h1>Add Questions</h1>
        <form method="POST">
            <label for="question">Question:</label>
            <input type="text" name="question" required placeholder="Enter your question">
            
            <label for="option1">Option 1:</label>
            <input type="text" name="option1" required placeholder="Option 1">

            <label for="option2">Option 2:</label>
            <input type="text" name="option2" required placeholder="Option 2">

            <label for="option3">Option 3:</label>
            <input type="text" name="option3" required placeholder="Option 3">

            <label for="option4">Option 4:</label>
            <input type="text" name="option4" required placeholder="Option 4">

            <label for="correct_answer">Correct Answer (Option number):</label>
            <input type="number" name="correct_answer" min="1" max="4" required placeholder="1-4">

            <button type="submit">Add Question</button>
        </form>

        <?php if ($questionAdded): ?>
            <div style="margin-top: 20px; text-align: center;">
                <h3>Question added successfully!</h3>
            </div>
        <?php endif; ?>

        <h2>Current Questions:</h2>
        <table>
            <tr>
                <th>Question</th>
                <th>Options</th>
                <th>Correct Answer</th>
                <th>Action</th>
            </tr>
            <?php foreach ($questions as $q): ?>
            <tr>
                <td><?php echo $q['question']; ?></td>
                <td>
                    1. <?php echo $q['option1']; ?><br>
                    2. <?php echo $q['option2']; ?><br>
                    3. <?php echo $q['option3']; ?><br>
                    4. <?php echo $q['option4']; ?>
                </td>
                <td><?php echo $q['correct_answer']; ?></td>
                <td>
                    <form method="POST" action="delete_question.php">
                        <input type="hidden" name="question_id" value="<?php echo $q['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
