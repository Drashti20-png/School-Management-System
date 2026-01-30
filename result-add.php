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
    $subjects = $_POST['subject'];
    $marks_obtained = $_POST['marks_obtained'];
    $total_marks = $_POST['total_marks'];
    $exam_type = $_POST['exam_type'];

    $total_obtained = 0;
    $total_max = 0;

    foreach ($subjects as $key => $subject) {
        $marks = $marks_obtained[$key];
        $max = $total_marks[$key];
        $grade = '';

        // Simple grade calculation
        $percentage_subject = ($max > 0) ? ($marks / $max) * 100 : 0;
        if ($percentage_subject >= 80) $grade = 'A';
        elseif ($percentage_subject >= 60) $grade = 'B';
        elseif ($percentage_subject >= 40) $grade = 'C';
        else $grade = 'F';

        // Insert each subject result
        $sql = "INSERT INTO results (student_id, subject, marks_obtained, total_marks, grade, exam_type, result_date)
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$student_id, $subject, $marks, $max, $grade, $exam_type]);

        $total_obtained += $marks;
        $total_max += $max;
    }

    // Overall percentage
    $overall_percentage = ($total_max > 0) ? round(($total_obtained / $total_max) * 100, 2) : 0;

    // Overall grade
    if ($overall_percentage >= 80) $overall_grade = 'A';
    elseif ($overall_percentage >= 60) $overall_grade = 'B';
    elseif ($overall_percentage >= 40) $overall_grade = 'C';
    else $overall_grade = 'F';

    $message = "Results added successfully! Total Marks: $total_obtained/$total_max, Percentage: $overall_percentage%, Overall Grade: $overall_grade";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Student Result</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<script>
function addSubjectRow() {
    const table = document.getElementById('subjects-table').getElementsByTagName('tbody')[0];
    const row = table.insertRow();
    row.innerHTML = `
        <td><input type="text" name="subject[]" class="form-control" required></td>
        <td><input type="number" name="marks_obtained[]" class="form-control" required></td>
        <td><input type="number" name="total_marks[]" class="form-control" required></td>
        <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()">Remove</button></td>
    `;
}
</script>
</head>
<body>
<div class="container mt-5">
    <h2>Add Student Result (Multiple Subjects)</h2>

    <?php if ($message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Student</label>
            <select name="student_id" class="form-control" required>
                <option value="">Select Student</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['student_id'] ?>">
                        <?= htmlspecialchars($student['fname'].' '.$student['lname'].' ('.$student['username'].')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Exam Type</label>
            <input type="text" name="exam_type" class="form-control" required>
        </div>

        <h5>Subjects & Marks</h5>
        <table class="table table-bordered" id="subjects-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Marks Obtained</th>
                    <th>Total Marks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="subject[]" class="form-control" required></td>
                    <td><input type="number" name="marks_obtained[]" class="form-control" required></td>
                    <td><input type="number" name="total_marks[]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()">Remove</button></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-secondary mb-3" onclick="addSubjectRow()">Add Another Subject</button>
        <br>
        <button type="submit" class="btn btn-success">Save Results</button>
        <a href="result-list.php" class="btn btn-secondary">View All Results</a>
    </form>
</div>
</body>
</html>
