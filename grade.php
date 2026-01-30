<?php 
// All Grades
function getAllGrades($conn){
   $sql = "SELECT * FROM grades";
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   return $stmt->rowCount() >= 1 ? $stmt->fetchAll() : false;
}
function getGradeById($grade_id, $conn){
    $sql = "SELECT * FROM grades WHERE grade_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$grade_id]);
    if ($stmt->rowCount() == 1) {
        return $stmt->fetch();
    } else {
        return false; // make sure it returns false
    }
}


// DELETE
function removeGrade($id, $conn){
   $sql  = "DELETE FROM grades WHERE grade_id=?";
   $stmt = $conn->prepare($sql);
   $re   = $stmt->execute([$id]);
   return $re ? 1 : 0;
}
