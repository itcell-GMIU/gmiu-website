<?php
session_start();
include '../common/globalvariable.php';
include '../database/connect.php';
include '../common/function.php';
include '../common/validation.php';

if (strlen($_SESSION['student_id']) == 0 || $_SESSION['secretkey'] != "secret") {
  header("Location:$base_url_student");
} else {
  $student_id = $_SESSION['student_id'];

  $cmd = "Select stu.*,pro.name as program_name,level.name as level_name,faculty.name as faculty_name, doc.photo as photo, stu.semester as sem from tbl_students_2023 as stu LEFT JOIN tbl_program pro
  ON stu.program_id = pro.id LEFT JOIN tbl_faculty faculty
  ON stu.faculty_id = faculty.id LEFT JOIN tbl_level level
  ON stu.level_id = level.id LEFT JOIN tbl_student_document doc
  ON stu.id = doc.student_id where stu.id=? ";
  $stmt = $con->prepare($cmd);
  $stmt->bind_param("i", $student_id);
  $stmt->execute();
  $result = $stmt->get_result(); // get the mysqli result

  if ($result->num_rows == 1) {

    $row = $result->fetch_assoc();
    $gr_no = !empty($row['gr_number']) ? $row['gr_number'] : "N/A";
    $er_no = !empty($row['enrollnment_no']) ? $row['enrollnment_no'] : "N/A";
    $sem = !empty($row['sem']) ? $row['sem'] : "N/A";
    $name = !empty($row['first_name'] . ' ' .  $row['middle_name'] . ' ' . $row['last_name']) ? ($row['first_name'] . ' ' .  $row['middle_name'] . ' ' . $row['last_name']) : "N/A";
    $first_name = !empty($row['first_name']) ? $row['first_name'] : "N/A";
    $middle_name = !empty($row['middle_name']) ? $row['middle_name'] : "N/A";
    $last_name = !empty($row['last_name']) ? $row['last_name'] : "N/A";
    $email = !empty($row['email']) ? $row['email'] : "N/A";
    $adhar_number = !empty($row['adhar_number']) ? $row['adhar_number'] : "N/A";
    $mobile_number = !empty($row['mobile_number']) ? $row['mobile_number'] : "N/A";
    $dob = !empty($row['dob']) ? $row['dob'] : "N/A";
    $gender = !empty($row['gender']) ? $row['gender'] : "N/A";
    $address = !empty($row['address']) ? $row['address'] : "N/A";
    $parent_mobile_number = !empty($row['parent_mobile_number']) ? $row['parent_mobile_number'] : "N/A";
    $parent_email_id = !empty($row['parent_email_id']) ? $row['parent_email_id'] : "N/A";
    $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "N/A";
    $level_name = !empty($row['level_name']) ? $row['level_name'] : "N/A";
    $program_name = !empty($row['program_name']) ? $row['program_name'] : "N/A";
    // $photo = !empty($row['photo']) ? $row['photo'] : "N/A";
    $photo = "N/A";
    $level_id = !empty($row['level_id']) ? $row['level_id'] : "N/A";
    $faculty_id = !empty($row['faculty_id']) ? $row['faculty_id'] : "N/A";
    $program_id = !empty($row['program_id']) ? $row['program_id'] : "N/A";
    
    $pr_image = !empty($row['profile_image']) ? $row['profile_image'] : "N/A";
    $signature = !empty($row['signature']) ? $row['signature'] : "N/A";
  } else {
    $gr_no = "N/A";
    $name = "N/A";
    $first_name = "N/A";
    $middle_name = "N/A";
    $last_name = "N/A";
    $email = "N/A";
    $adhar_number = "N/A";
    $mobile_number = "N/A";
    $dob = "N/A";
    $gender = "N/A";
    $address = "N/A";
    $parent_mobile_number = "N/A";
    $parent_email_id = "N/A";
    $faculty_name = "N/A";
    $level_name = "N/A";
    $program_name = "N/A";
    $photo = "N/A";
  }
}
?>