<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin'){
    header("Location: ../../login.php");
    exit;
}

if(isset($_GET['id'])){
    include "../../DB_connection.php";
    include "../data/result.php";

    $result_id = $_GET['id'];
    deleteResult($result_id, $conn);
}

header("Location: ../result.php");
exit;
?>
