<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";

// Fetch feedback with student info
$sql = "SELECT f.id, f.feedback_text, f.created_at, s.fname, s.lname, s.username 
        FROM feedback f 
        JOIN students s ON f.student_id = s.student_id 
        ORDER BY f.created_at DESC";
$stmt = $conn->query($sql);
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Student Feedback</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Student Feedback</h2>

    <?php if ($feedbacks && count($feedbacks) > 0): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Username</th>
                    <th>Feedback</th>
                    <th>Date Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php $i = 0; foreach ($feedbacks as $fb): $i++; ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= htmlspecialchars($fb['fname'].' '.$fb['lname']) ?></td>
                    <td><?= htmlspecialchars($fb['username']) ?></td>
                    <td><?= htmlspecialchars($fb['feedback_text']) ?></td>
                    <td><?= htmlspecialchars($fb['created_at']) ?></td>
                    <td>
                        <a href="feedback-delete.php?id=<?= $fb['id'] ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this feedback?')">
                            <i class="fas fa-trash-alt"></i> Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No feedback found!</div>
    <?php endif; ?>
</div>
</body>
</html>
