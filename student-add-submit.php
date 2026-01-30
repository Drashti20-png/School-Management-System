<?php
session_start();
if (!isset($_SESSION['r_user_id']) || $_SESSION['role'] !== "Registrar Office") {
    header("Location: ../login.php?error=Access denied");
    exit;
}

include "../DB_connection.php";

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect form data
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $address = $_POST['address'] ?? '';
    $email = $_POST['email_address'] ?? '';
    $dob = $_POST['date_of_birth'] ?? null;
    $gender = $_POST['gender'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['pass'] ?? '';
    $parent_fname = $_POST['parent_fname'] ?? '';
    $parent_lname = $_POST['parent_lname'] ?? '';
    $parent_phone = $_POST['parent_phone_number'] ?? '';
    $grade = $_POST['grade'] ?? '';
    $section = $_POST['section'] ?? '';

    // Handle image upload
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExt, $allowedExt)) {
            // Save with original file name
            $targetDir = "../uploads/";
            $imageName = basename($fileName);
            $targetFile = $targetDir . $imageName;

            if (!move_uploaded_file($fileTmp, $targetFile)) {
                header("Location: ../student-add.php?error=Failed to upload image");
                exit;
            }
        } else {
            header("Location: ../student-add.php?error=Invalid image type");
            exit;
        }
    }

    // Hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO students 
        (fname, lname, address, email_address, date_of_birth, gender, username, password, parent_fname, parent_lname, parent_phone_number, grade, section, image) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $result = $stmt->execute([
        $fname, $lname, $address, $email, $dob, $gender,
        $username, $passwordHash, $parent_fname, $parent_lname,
        $parent_phone, $grade, $section, $imageName
    ]);

    if ($result) {
        header("Location: ../student-add.php?success=Student added successfully");
        exit;
    } else {
        header("Location: ../student-add.php?error=Failed to add student");
        exit;
    }
} else {
    header("Location: ../student-add.php");
    exit;
}
?>
