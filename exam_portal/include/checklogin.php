<?php
session_start();
include '../../common/globalvariable.php';
include '../../database/connect.php';
include '../../common/function.php';
include '../../common/validation.php';
include '../api/operations.php';

if (strlen($_SESSION['staff_id']) == 0) {

  header("Location:../index.php");
} else {
  $staff_id = $_SESSION['staff_id'];
  $role = $_SESSION['role'];

  if ($role == 52 || $role == 53) {
    $cmd = "SELECT role.id AS role_id, staff.program_id as program_id,staff.name AS name,staff.ex_role AS ex_role ,staff.EXsubject AS EXsubject FROM tbl_exam_staff AS staff LEFT JOIN tbl_role AS role ON staff.role_id = role.id WHERE staff.id = ?";
    $stmt = $con->prepare($cmd);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    $row = $result->fetch_assoc();

    $name = $row['name'];
    $role_id = $row['role_id'];
    $ex_role = $row['ex_role'];
    $ExsubCode = $row['EXsubject'];
    $HODprogram_id = $row['program_id'];
    
    $crud->readSingleRecordColumn("tbl_im_management", "is_active", ["type" => 1], $mid_status);

  } else {
    $cmd = "SELECT role.id AS role_id,staff.name AS name,staff.faculty_id as faculty_id , staff.level_id as level_id , staff.program_id as program_id FROM tbl_staff AS staff LEFT JOIN tbl_role AS role ON staff.role_id = role.id WHERE staff.id = ?";
    $stmt = $con->prepare($cmd);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    $row = $result->fetch_assoc();


    $name = $row['name'];
    $role_id = $row['role_id'];
    $faculty_id = $row['faculty_id'];
    $level_id = $row['level_id'];
    $program_id = $row['program_id'];

    $crud->readSingleRecordColumn("tbl_im_management", "is_active", ["type" => 1], $mid_status);
  }
}
