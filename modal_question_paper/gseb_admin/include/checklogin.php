<?php
session_start();
include '../../common/globalvariable.php';
include '../database/connect.php';
include '../../common/function.php';
include '../../common/validation.php';

if (strlen($_SESSION['role_id']) == 0) {

  header("Location:$base_url/gujcet_admin/index.php");
} else {

  $role = 1; // Assuming role_id for admin is 1
  $stmt = $con->prepare("SELECT `username`,`role_id`, `id`, `email` , `name`  FROM tbl_admin WHERE role_id = ? AND email = ? AND password = ? AND is_active = 1 AND is_delete = 0");
  $stmt->bind_param("iss", $role, $email, $password);
  $stmt->execute();
  $result = $stmt->get_result(); // get the mysqli result
  $row = $result->fetch_assoc();

  $username = $row['username'];
  
}
