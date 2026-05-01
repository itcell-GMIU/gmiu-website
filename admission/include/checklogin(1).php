<?php
session_start();
include '../database/connect.php';
include '../common/globalvariable.php';
include '../common/function.php';
include '../common/validation.php';

if (strlen($_SESSION['student_id']) == 0 || $_SESSION['secretkey'] != "secret") {

  header("Location:$base_url_admission");
} else {
  $student_id = $_SESSION['student_id'];


  $cmd = "Select stu.*,pro.name as program_name,level.name as level_name,faculty.shortname as faculty_shortname,faculty.name as faculty_name,stu.account_office_approve_reject_date as account_office_approve_reject_date, stu.transaction_id as transaction_id, stu.payment_id as payment_id from tbl_admission_student as stu LEFT JOIN tbl_program pro
  ON stu.program_id = pro.id LEFT JOIN tbl_faculty faculty
  ON stu.faculty_id = faculty.id LEFT JOIN tbl_level level
  ON stu.level_id = level.id where stu.id=? ";
  $stmt = $con->prepare($cmd);
  $stmt->bind_param("i", $student_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $stu_first_name = !empty($row['first_name']) ? $row['first_name'] : "";
    $stu_middle_name = !empty($row['middle_name']) ? $row['middle_name'] : "";
    $stu_last_name = !empty($row['last_name']) ? $row['last_name'] : "";
    $stu_email = !empty($row['email']) ? $row['email'] : "";
    $stu_number = !empty($row['mobile_number']) ? $row['mobile_number'] : "";
    $stu_faculty_id = !empty($row['faculty_id']) ? $row['faculty_id'] : "";
    $stu_level_id = !empty($row['level_id']) ? $row['level_id'] : "";
    $stu_program_id = !empty($row['program_id']) ? $row['program_id'] : "";
    $mode = !empty($row['mode']) ? $row['mode'] : "";
    $payment_mode = !empty($row['payment_mode']) ? $row['payment_mode'] : "";
    $payment_status = !empty($row['payment_status']) ? $row['payment_status'] : "";
    $adhar_number = !empty($row['adhar_number']) ? $row['adhar_number'] : "";
    $gender = !empty($row['gender']) ? $row['gender'] : "";
    $dob = !empty($row['dob']) ? $row['dob'] : "";
    $blood_group = !empty($row['blood_group']) ? $row['blood_group'] : "";
    $religion = !empty($row['religion']) ? $row['religion'] : "";
    $caste = !empty($row['caste']) ? $row['caste'] : "";
    $father_name = !empty($row['father_name']) ? $row['father_name'] : "";
    $mother_name = !empty($row['mother_name']) ? $row['mother_name'] : "";
    $parent_mobile_number = !empty($row['parent_mobile_number']) ? $row['parent_mobile_number'] : "";
    $parent_email_id = !empty($row['parent_email_id']) ? $row['parent_email_id'] : "";
    $father_occupation = !empty($row['father_occupation']) ? $row['father_occupation'] : "";
    $mother_occupation = !empty($row['mother_occupation']) ? $row['mother_occupation'] : "";
    $permanent_address = !empty($row['permanent_address']) ? $row['permanent_address'] : "";
    $permanent_pincode = !empty($row['permanent_pincode']) ? $row['permanent_pincode'] : "";
    $address = !empty($row['address']) ? $row['address'] : "";
    $pincode = !empty($row['pincode']) ? $row['pincode'] : "";
    $city = !empty($row['city']) ? $row['city'] : "";
    $state = !empty($row['state']) ? $row['state'] : "";
    $permanent_city = !empty($row['permanent_city']) ? $row['permanent_city'] : "";
    $permanent_state = !empty($row['permanent_state']) ? $row['permanent_state'] : "";
    $is_same_addr = !empty($row['is_same_addr']) ? $row['is_same_addr'] : "";
    $token_amount = !empty($row['token_amount']) ? $row['token_amount'] : "";
    $payment_date_time = !empty($row['payment_date_time']) ? $row['payment_date_time'] : "";
    $gr_number = !empty($row['gr_number']) ? $row['gr_number'] : "";
    $stu_program_name = !empty($row['program_name']) ? $row['program_name'] : "";
    $stu_faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "";
    $stu_faculty_shortname = !empty($row['faculty_shortname']) ? $row['faculty_shortname'] : "";
    $stu_level_name = !empty($row['level_name']) ? $row['level_name'] : "";
    $stu_cluster_status = !empty($row['status']) ? $row['status'] : "";
    $stu_admission_status = !empty($row['admission_status']) ? $row['admission_status'] : "";
    $stu_admission_step = !empty($row['step']) ? $row['step'] : "";
    $comment = !empty($row['comment']) ? $row['comment'] : "";
    $account_office_status = !empty($row['account_office_status']) ? $row['account_office_status'] : "";
    $account_office_approve_reject_date = !empty($row['account_office_approve_reject_date']) ? $row['account_office_approve_reject_date'] : "";
    $transaction_id = !empty($row['transaction_id']) ? $row['transaction_id'] : "";
    $payment_id = !empty($row['payment_id']) ? $row['payment_id'] : "";
    

  } else {
    $stu_first_name = "";
    $stu_middle_name = "";
    $stu_last_name = "";
    $stu_email = "";
    $stu_number = "";
    $stu_faculty_id = "";
    $stu_level_id = "";
    $stu_program_id = "";
    $mode = "";
    $payment_mode = "";
    $adhar_number = "";
    $dob = "";
    $gender = "";
    $blood_group = "";
    $religion = "";
    $caste = "";
    $father_name = "";
    $mother_name = "";
    $parent_mobile_number = "";
    $parent_email_id = "";
    $father_occupation = "";
    $mother_occupation = "";
    $permanent_address = "";
    $permanent_pincode = "";
    $address = "";
    $pincode = "";
    $city = "";
    $state = "";
    $permanent_city = "";
    $permanent_state = "";
    $is_same_addr = "";
    $token_amount = "";
    $payment_date_time = "";
    $gr_number = "";
    $stu_program_name = "";
    $stu_faculty_name = "";
    $stu_faculty_shortname = "";
    $stu_level_name = "";
    $stu_cluster_status = "";
    $stu_admission_status = "";
    $stu_admission_step = "";
    $comment = "";
    $account_office_status = "";
    $account_office_approve_reject_date = ""; 
    $transaction_id = "";
    $payment_id = "";
  }
}