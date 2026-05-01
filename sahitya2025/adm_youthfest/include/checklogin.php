<?php
session_start();
include("../../dbconnect.php");
include '../../operations.php';

if (strlen($_SESSION['staff_id']) == 0) {

  header("Location:../index.php");
} else {
  $staff_id = $_SESSION['staff_id'];
  $role = $_SESSION['role'];

    $cmd = "SELECT role_id AS role_id,staff.name AS name FROM tbl_admin AS staff WHERE staff.id = ?";
    $stmt = $con->prepare($cmd);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $row = $result->fetch_assoc();

    $name = $row['name'];
    $role_id = $row['role_id'];
  
}
