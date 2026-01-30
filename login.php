<?php
session_start();
include "../DB_connection.php";
include "data/teacher.php";

// Redirect if already logged in
if (isset($_SESSION['teacher_id']) && $_SESSION['role'] === 'Teacher') {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Fetch teacher by username
    $sql = "SELECT * FROM teacher WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $teacher = $stmt->fetch();

    if ($teacher) {

        /* 
           -------------------------------------------------------
            CASE 1: Your DB uses PLAIN PASSWORDS (like "kalpana").
           -------------------------------------------------------
        */
        if ($password === $teacher['password']) {

            $_SESSION['teacher_id'] = $teacher['teacher_id'];
            $_SESSION['role'] = 'Teacher';

            header("Location: index.php");
            exit;
        }

        /*
           -------------------------------------------------------
           CASE 2: If password is HASHED (starts with $2y$ )
           -------------------------------------------------------
        */
        if (password_verify($password, $teacher['password'])) {

            $_SESSION['teacher_id'] = $teacher['teacher_id'];
            $_SESSION['role'] = 'Teacher';

            header("Location: index.php");
            exit;
        }

        // Password mismatch
        $error = "Incorrect Username or Password";

    } else {
        $error = "Incorrect Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Yanshi School - Teacher Login</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">

</head>
<body>
<div class="container mt-5" style="max-width:400px;">
    <h3 class="text-center mb-4">Teacher Login</h3>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="post">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Login</button>
    </form>

    <p class="text-center mt-3"><a href="../index.php">← Back to Home</a></p>
    <p class="text-center mt-3">© 2025 Yanshi School. All rights reserved.</p>
</div>
</body>
</html>
