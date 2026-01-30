<?php
session_start();
if (!isset($_SESSION['principal_id'])) {
    header("Location: ../login.php?error=Access denied");
    exit;
}

if (isset($_POST['notice']) && !empty(trim($_POST['notice']))) {
    include "../DB_connection.php";
    $principal_id = $_SESSION['principal_id'];
    $notice = trim($_POST['notice']);

    $stmt = $conn->prepare("INSERT INTO notices (posted_by, notice) VALUES (?, ?)");
    $stmt->execute([$principal_id, $notice]);

    header("Location: index.php");
    exit;
} else {
    header("Location: index.php?error=Notice cannot be empty");
    exit;
}
?>
