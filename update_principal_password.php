<?php
include "DB_connection.php";

// New plain password
$newPassword = "rekha123"; 

// Hash it
$hashed = password_hash($newPassword, PASSWORD_DEFAULT);

// Update principal's password
$sql = "UPDATE principal SET password = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$hashed, "principal1"]);

echo "Password updated successfully. New password: $newPassword";
