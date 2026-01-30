<?php
session_start();

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../../logout.php");
    exit;
}

if (
    isset($_POST['fname']) &&
    isset($_POST['lname']) &&
    isset($_POST['username']) &&
    isset($_POST['teacher_id']) &&
    isset($_POST['address']) &&
    isset($_POST['employee_number']) &&
    isset($_POST['phone_number']) &&
    isset($_POST['qualification']) &&
    isset($_POST['email_address']) &&
    isset($_POST['gender']) &&
    isset($_POST['date_of_birth']) &&
    isset($_POST['subjects']) &&
    isset($_POST['classes'])
) {

    include '../../DB_connection.php';
    include "../data/teacher.php";

    $teacher_id = $_POST['teacher_id'];
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $uname = trim($_POST['username']);
    $address = trim($_POST['address']);
    $employee_number = trim($_POST['employee_number']);
    $phone_number = trim($_POST['phone_number']);
    $qualification = trim($_POST['qualification']);
    $email_address = trim($_POST['email_address']);
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];

    $subjects = implode(",", $_POST['subjects']);
    $classes = implode(",", $_POST['classes']);

    $data = "teacher_id=$teacher_id";

    // Validations
    if (empty($fname) || empty($lname) || empty($uname) || empty($address) ||
        empty($employee_number) || empty($phone_number) || empty($qualification) ||
        empty($email_address) || empty($gender) || empty($date_of_birth)) {
        $em = "Please fill in all required fields!";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }

    if (!unameIsUnique($uname, $conn, $teacher_id)) {
        $em = "Username is already taken!";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }

    // Update teacher
    $sql = "UPDATE teacher SET
                username=?, class=?, fname=?, lname=?, subjects=?,
                address=?, employee_number=?, date_of_birth=?, phone_number=?, qualification=?, gender=?, email_address=?
            WHERE teacher_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $uname, $classes, $fname, $lname, $subjects,
        $address, $employee_number, $date_of_birth,
        $phone_number, $qualification, $gender, $email_address, $teacher_id
    ]);

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $img_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','gif'];

        if (in_array(strtolower($ext), $allowed)) {
            $new_name = uniqid().'_teacher.'.$ext;
            $upload_dir = "../../uploads/teachers/";
            if (move_uploaded_file($tmp_name, $upload_dir.$new_name)) {
                $stmt = $conn->prepare("UPDATE teacher SET image=? WHERE teacher_id=?");
                $stmt->execute([$new_name, $teacher_id]);
            }
        }
    }

    $sm = "Successfully updated!";
    header("Location: ../teacher-edit.php?success=$sm&$data");
    exit;

} else {
    $em = "Invalid request!";
    header("Location: ../teacher.php?error=$em");
    exit;
}
?>
