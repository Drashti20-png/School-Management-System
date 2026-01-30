<?php
session_start();
include "../DB_connection.php";
include "data/student.php";
include "data/grade.php";
include "data/section.php";

if (!((isset($_SESSION['admin_id']) && $_SESSION['role']==='Admin') || 
      (isset($_SESSION['principal_id']) && $_SESSION['role']==='Principal'))) {
    header("Location: ../login.php?error=Access denied");
    exit;
}

if (!isset($_GET['student_id'])) {
    header("Location: students.php?error=Student ID missing");
    exit;
}

$student_id = $_GET['student_id'];
$student = getStudentById($student_id, $conn);
if (!$student) {
    header("Location: students.php?error=Student not found");
    exit;
}

$grade = getGradeById($student['grade'], $conn);
$section = getSectioById($student['section'], $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Student Profile</h3>
    <div class="card" style="width: 22rem;">
        <img src="../img/student-<?= $student['gender'] ?>.png" class="card-img-top" alt="Student">
        <div class="card-body">
            <h5 class="card-title">@<?= $student['username'] ?></h5>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">First Name: <?= $student['fname'] ?></li>
            <li class="list-group-item">Last Name: <?= $student['lname'] ?></li>
            <li class="list-group-item">Username: <?= $student['username'] ?></li>
            <li class="list-group-item">Address: <?= $student['address'] ?></li>
            <li class="list-group-item">Date of Birth: <?= $student['date_of_birth'] ?></li>
            <li class="list-group-item">Email: <?= $student['email_address'] ?></li>
            <li class="list-group-item">Gender: <?= $student['gender'] ?></li>
            <li class="list-group-item">Grade: <?= $grade ? $grade['grade_code'].'-'.$grade['grade'] : '-' ?></li>
            <li class="list-group-item">Section: <?= $section ? $section['section'] : '-' ?></li>
            <li class="list-group-item">Parent Name: <?= $student['parent_fname'].' '.$student['parent_lname'] ?></li>
            <li class="list-group-item">Parent Phone: <?= $student['parent_phone_number'] ?></li>
        </ul>
        <div class="card-body">
            <a href="student-edit.php?student_id=<?= $student['student_id'] ?>" class="btn btn-warning">Edit</a>
            <a href="students.php" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
</body>
</html>
