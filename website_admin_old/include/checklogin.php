<?php
session_start();
include '../../common/globalvariable.php';
include '../../database/connect.php';
include '../../common/function.php';
include '../../common/validation.php';

if (strlen($_SESSION['web_admin_id']) == 0) {

  header("Location:$base_url_website_admin");
} elseif($_SESSION['role_id'] == "8") {
  $web_admin_id = $_SESSION['web_admin_id'];

  $cmd = "SELECT role.id AS role_id,staff.name AS name,staff.faculty_id as faculty_id , staff.level_id as level_id , staff.program_id as program_id FROM tbl_staff AS staff LEFT JOIN tbl_role AS role ON staff.role_id = role.id WHERE staff.id = ?";
  $stmt = $con->prepare($cmd);
  $stmt->bind_param("i", $web_admin_id);
  $stmt->execute();
  $result = $stmt->get_result(); // get the mysqli result
  $row = $result->fetch_assoc();

  $name = $row['name'];
  $role_id = $row['role_id'];
  $faculty_id = $row['faculty_id'];
  $level_id = $row['level_id'];
  $program_id = $row['program_id'];
}
else{
  {
    $web_admin_id = $_SESSION['web_admin_id'];
  
    $cmd = "SELECT role.id AS role_id, admin.name AS name FROM tbl_admin AS admin LEFT JOIN tbl_role AS role ON admin.role_id = role.id WHERE admin.id = ?";
    $stmt = $con->prepare($cmd);
    $stmt->bind_param("i", $web_admin_id);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    $row = $result->fetch_assoc();
  
    $name = $row['name'];
    $role_id = $row['role_id'];
  }
}