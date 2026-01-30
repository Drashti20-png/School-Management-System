<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";
include "data/grade.php";
include "data/section.php";

$grades = getAllGrades($conn);
$sections = getAllSections($conn);

$fname = $_GET['fname'] ?? '';
$lname = $_GET['lname'] ?? '';
$uname = $_GET['uname'] ?? '';
$address = $_GET['address'] ?? '';
$email = $_GET['email'] ?? '';
$pfn = $_GET['pfn'] ?? '';
$pln = $_GET['pln'] ?? '';
$ppn = $_GET['ppn'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Add Student</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <a href="student.php" class="btn btn-dark">Go Back</a>
    <form action="req/student-add.php" method="post" enctype="multipart/form-data" class="shadow p-3 mt-3">
        <h3>Add New Student</h3><hr>

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="fname" class="form-control" value="<?= htmlspecialchars($fname) ?>" required>
        </div>
        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="lname" class="form-control" value="<?= htmlspecialchars($lname) ?>" required>
        </div>
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($uname) ?>" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="text" name="pass" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email_address" class="form-control" value="<?= htmlspecialchars($email) ?>">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($address) ?>">
        </div>
        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control">
        </div>
        <div class="mb-3">
            <label>Gender</label><br>
            <input type="radio" name="gender" value="Male" checked> Male
            <input type="radio" name="gender" value="Female"> Female
        </div>
        <div class="mb-3">
            <label>Parent First Name</label>
            <input type="text" name="parent_fname" class="form-control" value="<?= htmlspecialchars($pfn) ?>">
        </div>
        <div class="mb-3">
            <label>Parent Last Name</label>
            <input type="text" name="parent_lname" class="form-control" value="<?= htmlspecialchars($pln) ?>">
        </div>
        <div class="mb-3">
            <label>Parent Phone Number</label>
            <input type="text" name="parent_phone_number" class="form-control" value="<?= htmlspecialchars($ppn) ?>">
        </div>
        <div class="mb-3">
            <label>Grade</label><br>
            <?php foreach ($grades as $grade): ?>
                <input type="radio" name="grade" value="<?= $grade['grade_id'] ?>"> <?= $grade['grade_code'].'-'.$grade['grade'] ?>
            <?php endforeach; ?>
        </div>
        <div class="mb-3">
            <label>Section</label><br>
            <?php foreach ($sections as $section): ?>
                <input type="radio" name="section" value="<?= $section['section_id'] ?>"> <?= $section['section'] ?>
            <?php endforeach; ?>
        </div>
        <div class="mb-3">
            <label>Upload Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
