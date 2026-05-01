<?php
session_start();
include '../common/globalvariable.php';
include '../database/connect.php';
include '../common/function.php';
include '../common/validation.php';

if (strlen($_SESSION['staff_id']) == 0) {

  header("Location:$base_url/gmiulogin.php");
} else {
  if ($_SESSION['role_id'] == 18) {
    $staff_id = $_SESSION['staff_id'];

    $cmd = "Select name from tbl_staff where id=? ";
    $stmt = $con->prepare($cmd);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    $row = $result->fetch_assoc();

    $name = $row['name'];
  } else {
    header("Location:$base_url/gmiulogin.php");
  }
}