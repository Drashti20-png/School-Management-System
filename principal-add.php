<?php
session_start();
if ($_SESSION['role'] != 'Admin') {
    header("Location: ../login.php"); exit;
}

include "../DB_connection.php";
include "data/principal.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $uname = trim($_POST['username']);
    $qualification = trim($_POST['qualification']);
    $email = trim($_POST['email_address']);
    $phone = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $gender = $_POST['gender'];
    $dob = $_POST['date_of_birth'];

    if (!unamePrincipalIsUnique($uname, $conn)) {
        $error = "Username is taken!";
    } else {
        $sql = "INSERT INTO principal (username,fname,lname,qualification,email_address,phone_number,address,gender,date_of_birth)
                VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname,$fname,$lname,$qualification,$email,$phone,$address,$gender,$dob]);
        $success = "Principal added successfully!";
    }
}
?>

<!-- HTML Form (Bootstrap) -->
<form method="post" class="p-3">
  <input type="text" name="fname" placeholder="First Name" required>
  <input type="text" name="lname" placeholder="Last Name" required>
  <input type="text" name="username" placeholder="Username" required>
  <input type="text" name="qualification" placeholder="Qualification" required>
  <input type="email" name="email_address" placeholder="Email" required>
  <input type="text" name="phone_number" placeholder="Phone Number">
  <input type="text" name="address" placeholder="Address">
  <input type="date" name="date_of_birth">
  <select name="gender">
    <option value="Male">Male</option>
    <option value="Female">Female</option>
  </select>
  <button type="submit">Add Principal</button>
</form>
