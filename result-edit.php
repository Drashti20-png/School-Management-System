<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin'){
    header("Location: ../../login.php");
    exit;
}

if(isset($_POST['result_id'], $_POST['student_id'], $_POST['subject_id'], $_POST['marks'], $_POST['grade'], $_POST['exam_name'], $_POST['date'])) {
    include "../../DB_connection.php";
    include "../data/result.php";

    $result_id = $_POST['result_id'];
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $marks = $_POST['marks'];
    $grade = $_POST['grade'];
    $exam_name = $_POST['exam_name'];
    $date = $_POST['date'];

    if(updateResult($result_id, $student_id, $subject_id, $marks, $grade, $exam_name, $date, $conn)){
        header("Location: ../result.php?success=Result updated successfully");
        exit;
    } else {
        header("Location: ../result-edit.php?id=$result_id&error=Failed to update result");
        exit;
    }
} else {
    $result_id = $_POST['result_id'] ?? '';
    header("Location: ../result-edit.php?id=$result_id&error=All fields are required");
    exit;
}
?>
