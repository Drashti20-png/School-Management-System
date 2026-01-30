<?php 
session_start();
if (!isset($_SESSION['teacher_id']) || $_SESSION['role'] !== 'Teacher') {
    header("Location: ../Teacher/req/index.php?error=Please login first");
    exit;
}

include "../DB_connection.php";
include "../Teacher/data/teacher.php";
include "data/subject.php";
include "data/class.php";
include "data/grade.php";
include "data/section.php";

$teacher_id = $_SESSION['teacher_id'];
$teacher = getTeacherById($teacher_id, $conn);
if (!$teacher) {
    session_destroy();
    header("Location: ../Teacher/req/index.php?error=Teacher not found");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Dashboard</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="icon" href="logo.png">
<style>
    .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #0d6efd;
        margin: auto;
        display: block;
    }
</style>
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container mt-5">
    <div class="card mx-auto" style="width: 22rem;">
        <?php
       
        $imagePath = "../uploads/" . $teacher['image'];

        if (!empty($teacher['image']) && file_exists($imagePath)) {
            echo '<img src="'.htmlspecialchars($imagePath).'" class="profile-img" alt="Teacher Photo">';
        } else {
            echo '<img src="img/teacher-'.$teacher['gender'].'.png" class="profile-img" alt="Teacher Photo">';
        }
        ?>
        <div class="card-body text-center">
            <h5 class="card-title">@<?= htmlspecialchars($teacher['username']) ?></h5>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Name: <?= htmlspecialchars($teacher['fname'].' '.$teacher['lname']) ?></li>
            <li class="list-group-item">Username: <?= htmlspecialchars($teacher['username']) ?></li>
            <li class="list-group-item">Employee #: <?= htmlspecialchars($teacher['employee_number']) ?></li>
            <li class="list-group-item">Address: <?= htmlspecialchars($teacher['address']) ?></li>
            <li class="list-group-item">Phone: <?= htmlspecialchars($teacher['phone_number']) ?></li>
            <li class="list-group-item">Email: <?= htmlspecialchars($teacher['email_address']) ?></li>
            <li class="list-group-item">Qualification: <?= htmlspecialchars($teacher['qualification']) ?></li>
            <li class="list-group-item">DOB: <?= htmlspecialchars($teacher['date_of_birth']) ?></li>
            <li class="list-group-item">Joined: <?= htmlspecialchars($teacher['date_of_joined']) ?></li>
            <li class="list-group-item">Gender: <?= htmlspecialchars($teacher['gender']) ?></li>
            <li class="list-group-item">
                Subjects: 
                <?php 
                $subjectsList = '';
                foreach(str_split(trim($teacher['subjects'])) as $subId){
                    $sub = getSubjectById($subId, $conn);
                    if($sub) $subjectsList .= $sub['subject_code'].', ';
                }
                echo rtrim($subjectsList, ', ');
                ?>
            </li>
            <li class="list-group-item">
                Classes: 
                <?php
                $classList = '';
                foreach(str_split(trim($teacher['class'])) as $classId){
                    $cls = getClassById($classId, $conn);
                    if($cls){
                        $grade = getGradeById($cls['grade'], $conn);
                        $section = getSectioById($cls['section'], $conn);
                        if($grade && $section) $classList .= $grade['grade_code'].'-'.$grade['grade'].$section['section'].', ';
                    }
                }
                echo rtrim($classList, ', ');
                ?>
            </li>
        </ul>
        <div class="card-body text-center">
            <a href="logout.php" class="btn btn-danger w-100">Logout</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
