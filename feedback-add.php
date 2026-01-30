<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";
include "data/student.php";

$students = getAllStudents($conn);
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $feedback_text = $_POST['feedback_text'];

    $sql = "INSERT INTO feedback (student_id, feedback_text, created_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$student_id, $feedback_text])) {
        $message = "Feedback added successfully!";
    } else {
        $message = "Error adding feedback!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Student Feedback</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Add Student Feedback</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label for="student_id" class="form-label">Student</label>
            <select name="student_id" id="student_id" class="form-control" required>
                <option value="">Select Student</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['student_id'] ?>">
                        <?= htmlspecialchars($student['fname'].' '.$student['lname'].' ('.$student['username'].')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="feedback_text" class="form-label">Feedback</label>
            <textarea name="feedback_text" id="feedback_text" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Add Feedback</button>
        <a href="feedback-list.php" class="btn btn-secondary">View Feedback</a>
    </form>
</div>
</body>
</html>
