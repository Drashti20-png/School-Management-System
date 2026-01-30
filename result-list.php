<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";
include "data/student.php";

// Fetch all results with student info
$sql = "SELECT r.*, s.fname, s.lname, s.username 
        FROM results r 
        JOIN students s ON r.student_id = s.student_id 
        ORDER BY r.result_date DESC";
$stmt = $conn->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Results</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">All Student Results</h2>
    <a href="result-add.php" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Add New Result
    </a>

    <?php if ($results && count($results) > 0): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Subject</th>
                    <th>Marks Obtained</th>
                    <th>Total Marks</th>
                    <th>Grade</th>
                    <th>Exam Type</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php $i = 0; foreach ($results as $row): $i++; ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= htmlspecialchars($row['fname'].' '.$row['lname'].' ('.$row['username'].')') ?></td>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td><?= $row['marks_obtained'] ?></td>
                        <td><?= $row['total_marks'] ?></td>
                        <td><?= htmlspecialchars($row['grade']) ?></td>
                        <td><?= htmlspecialchars($row['exam_type']) ?></td>
                        <td><?= htmlspecialchars($row['result_date']) ?></td>
                        <td>
                            <a href="result-edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="result-delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" 
                               onclick="return confirm('Are you sure you want to delete this result?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No results found!</div>
    <?php endif; ?>
</div>
</body>
</html>
