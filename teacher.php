<?php  

// Get Teacher by ID
function getTeacherById($teacher_id, $conn) {
    $sql = "SELECT * FROM teacher WHERE teacher_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$teacher_id]);

    return ($stmt->rowCount() == 1) 
        ? $stmt->fetch(PDO::FETCH_ASSOC)
        : false;
}

// Get All Teachers
function getAllTeachers($conn) {
    $sql = "SELECT * FROM teacher";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return ($stmt->rowCount() >= 1) 
        ? $stmt->fetchAll(PDO::FETCH_ASSOC) 
        : [];
}

// Check if username is unique
function unameIsUnique($uname, $conn, $teacher_id = 0) {
    $sql = "SELECT username, teacher_id FROM teacher WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$uname]);

    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($teacher_id == 0) {
        return $teacher ? false : true;
    } else {
        return ($teacher && $teacher['teacher_id'] != $teacher_id) 
            ? false 
            : true;
    }
}

// Delete Teacher
function removeTeacher($id, $conn) {
    $sql = "DELETE FROM teacher WHERE teacher_id=?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$id]);
}

// Search Teachers
function searchTeachers($key, $conn) {
    $key = "%".$key."%";

    $sql = "SELECT * FROM teacher
            WHERE teacher_id LIKE ?
            OR fname LIKE ?
            OR lname LIKE ?
            OR username LIKE ?
            OR employee_number LIKE ?
            OR phone_number LIKE ?
            OR qualification LIKE ?
            OR email_address LIKE ?
            OR address LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $key, $key, $key, 
        $key, $key, $key, 
        $key, $key, $key
    ]);

    return ($stmt->rowCount() >= 1)
        ? $stmt->fetchAll(PDO::FETCH_ASSOC)
        : [];
}
?>
