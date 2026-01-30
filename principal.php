<?php
// Get Principal by ID
function getPrincipalById($principal_id, $conn) {
    $sql = "SELECT * FROM principal WHERE principal_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$principal_id]);
    return $stmt->rowCount() == 1 ? $stmt->fetch() : false;
}

// Get All Principals
function getAllPrincipals($conn) {
    $sql = "SELECT * FROM principal";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->rowCount() >= 1 ? $stmt->fetchAll() : 0;
}

// Check username uniqueness
function unamePrincipalIsUnique($uname, $conn, $principal_id=0){
    $sql = "SELECT username, principal_id FROM principal WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$uname]);

    if ($principal_id == 0) {
        return $stmt->rowCount() == 0;
    } else {
        if ($stmt->rowCount() >= 1) {
            $principal = $stmt->fetch();
            return $principal['principal_id'] == $principal_id;
        } else {
            return true;
        }
    }
}

// Delete Principal
function removePrincipal($id, $conn){
    $sql = "DELETE FROM principal WHERE principal_id=?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$id]);
}
?>
