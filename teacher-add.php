<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin'){
    header("Location: ../../login.php");
    exit;
}

if (isset($_POST['fname'], $_POST['lname'], $_POST['username'], $_POST['pass'], 
          $_POST['address'], $_POST['employee_number'], $_POST['phone_number'], 
          $_POST['qualification'], $_POST['email_address'], $_POST['gender'], 
          $_POST['date_of_birth'])) {

    include "../../DB_connection.php";

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $password = $_POST['pass'];
    $address = $_POST['address'];
    $employee_number = $_POST['employee_number'];
    $phone_number = $_POST['phone_number'];
    $qualification = $_POST['qualification'];
    $email = $_POST['email_address'];
    $gender = $_POST['gender'];
    $dob = $_POST['date_of_birth'];

    // ---- Handle Teacher Image Upload ----
    $image = NULL;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "../../uploads/teachers/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $imageName;
        }
    }

    // ---- Insert Teacher into DB ----
    $sql = "INSERT INTO teacher (fname, lname, username, password, address, 
                                 employee_number, phone_number, qualification, 
                                 email_address, gender, date_of_birth, image)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$fname, $lname, $username, $password, $address, 
                    $employee_number, $phone_number, $qualification, 
                    $email, $gender, $dob, $image]);

    header("Location: ../teacher.php?success=Teacher added successfully!");
    exit;

} else {
    header("Location: ../teacher-add.php?error=All fields are required");
    exit;
}
?>
