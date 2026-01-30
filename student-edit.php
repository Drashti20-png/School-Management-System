<?php
session_start();

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../../logout.php");
    exit;
}

if (
    isset($_POST['student_id'], $_POST['fname'], $_POST['lname'], $_POST['username'],
          $_POST['grade'], $_POST['section'], $_POST['address'], $_POST['gender'],
          $_POST['email_address'], $_POST['date_of_birth'],
          $_POST['parent_fname'], $_POST['parent_lname'], $_POST['parent_phone_number'])
) {
    include '../../DB_connection.php';
    include '../data/student.php';

    $student_id = $_POST['student_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['username'];
    $grade = $_POST['grade'];
    $section = $_POST['section'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $email_address = $_POST['email_address'];
    $date_of_birth = $_POST['date_of_birth'];
    $parent_fname = $_POST['parent_fname'];
    $parent_lname = $_POST['parent_lname'];
    $parent_phone_number = $_POST['parent_phone_number'];

    $data = 'student_id=' . $student_id;

    // Validate required fields
    if (empty($fname) || empty($lname) || empty($uname) || empty($grade) || empty($section) || empty($address) || empty($gender) || empty($email_address) || empty($date_of_birth) || empty($parent_fname) || empty($parent_lname) || empty($parent_phone_number)) {
        $em = "All fields are required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }

    if (!unameIsUnique($uname, $conn, $student_id)) {
        $em = "Username is already taken";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }

    // Handle image upload
    $imageName = null;
    if (isset($_FILES['student_image']) && $_FILES['student_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['student_image']['tmp_name'];
        $fileName = $_FILES['student_image']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExt, $allowedExts)) {
            $imageName = 'student_' . $student_id . '_' . time() . '.' . $fileExt;
            $destPath = '../../uploads/' . $imageName;
            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                $em = "Error uploading image";
                header("Location: ../student-edit.php?error=$em&$data");
                exit;
            }
        } else {
            $em = "Invalid image format (allowed: jpg, jpeg, png, gif)";
            header("Location: ../student-edit.php?error=$em&$data");
            exit;
        }
    }

    // Update DB
    if ($imageName) {
        $sql = "UPDATE students SET username=?, fname=?, lname=?, grade=?, section=?, address=?, gender=?, email_address=?, date_of_birth=?, parent_fname=?, parent_lname=?, parent_phone_number=?, image=? WHERE student_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname, $fname, $lname, $grade, $section, $address, $gender, $email_address, $date_of_birth, $parent_fname, $parent_lname, $parent_phone_number, $imageName, $student_id]);
    } else {
        $sql = "UPDATE students SET username=?, fname=?, lname=?, grade=?, section=?, address=?, gender=?, email_address=?, date_of_birth=?, parent_fname=?, parent_lname=?, parent_phone_number=? WHERE student_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname, $fname, $lname, $grade, $section, $address, $gender, $email_address, $date_of_birth, $parent_fname, $parent_lname, $parent_phone_number, $student_id]);
    }

    $sm = "Student updated successfully!";
    header("Location: ../student-edit.php?success=$sm&$data");
    exit;

} else {
    $em = "Invalid form submission";
    header("Location: ../student.php?error=$em");
    exit;
}
?>
