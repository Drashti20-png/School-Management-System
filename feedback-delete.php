<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";

if (!isset($_GET['id'])) {
    header("Location: feedback-list.php");
    exit;
}

$id = $_GET['id'];

// Delete feedback
$stmt = $conn->prepare("DELETE FROM feedback WHERE id = ?");
$stmt->execute([$id]);

header("Location: feedback-list.php");
exit;
