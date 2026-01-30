<?php
session_start();

if (isset($_POST['uname']) && isset($_POST['pass'])) {

    include "../DB_connection.php";

    $uname = trim($_POST['uname']);
    $pass  = trim($_POST['pass']);

    if (empty($uname)) {
        $em  = "Username is required";
        header("Location: ../login.php?error=$em");
        exit;
    } else if (empty($pass)) {
        $em  = "Password is required";
        header("Location: ../login.php?error=$em");
        exit;
    }

    // Check Principal table
    $sql = "SELECT * FROM principal WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$uname]);

    if ($stmt->rowCount() == 1) {
        $principal = $stmt->fetch();
        $hashed_password = $principal['password'];

        if (password_verify($pass, $hashed_password)) {
            // Set session variables
            $_SESSION['role'] = "Principal";
            $_SESSION['principal_id'] = $principal['principal_id'];
            $_SESSION['principal_name'] = $principal['fname'] . " " . $principal['lname'];

            // Redirect to Principal dashboard
            header("Location: ../Principal/index.php");
            exit;
        } else {
            $em  = "Incorrect Username or Password";
            header("Location: ../login.php?error=$em");
            exit;
        }

    } else {
        $em  = "Incorrect Username or Password";
        header("Location: ../login.php?error=$em");
        exit;
    }

} else {
    header("Location: ../login.php");
    exit;
}
?>
