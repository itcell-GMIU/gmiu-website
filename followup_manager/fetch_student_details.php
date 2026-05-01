<?php
include 'include/checklogin.php';
// include '../database/connect.php';
$student_id = $_GET['student_id'];

$stmt = $con->prepare("SELECT stu.gr_number, 
    CONCAT_WS(' ', stu.first_name, stu.middle_name, stu.last_name) AS full_name, 
    pac.quota AS pac_quota,
    pac.mode AS pac_mode,     
    pro.name AS program_name, 
    pro.id AS program_id,
    level.id AS level_id,
    faculty.id AS faculty_id,
    level.name AS level_name, 
    faculty.name AS faculty_name 
    FROM tbl_admission_student stu
    LEFT JOIN tbl_program pro ON stu.program_id = pro.id
    LEFT JOIN tbl_level level ON stu.level_id = level.id
    LEFT JOIN tbl_faculty faculty ON stu.faculty_id = faculty.id
    LEFT JOIN tbl_pac_form pac ON stu.id = pac.student_id
    WHERE stu.id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
echo json_encode($result);


