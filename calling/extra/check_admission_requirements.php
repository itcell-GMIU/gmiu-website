<?php
session_start();

include '../../common/globalvariable.php';
include '../../database/connect.php';
// include '../../common/function.php';
// include '../../common/validation.php';

header('Content-Type: application/json');

// Get value from GET request
if (!isset($_GET['inq_student_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "inq_student_id not received"
    ]);
    exit;
}

$inq_id = $_GET['inq_student_id'];

$q = "SELECT first_name, middle_name, last_name, gender, mobile_number, email, faculty_id, level_id, program_id
      FROM tbl_inquiry_student 
      WHERE inq_student_id = '$inq_id'";

$run = mysqli_query($con, $q);
$data = mysqli_fetch_assoc($run);

$missing = [];

// Validate correct fields
if (empty($data['first_name']))
    $missing[] = "First Name";

if (empty($data['middle_name']))
    $missing[] = "Middle Name";

if (empty($data['last_name']))
    $missing[] = "Last Name";

if (empty($data['gender']))
    $missing[] = "Gender";

if (empty($data['mobile_number']))
    $missing[] = "Mobile Number";

if (empty($data['email']))
    $missing[] = "Email";

if (empty($data['faculty_id']))
    $missing[] = "Faculty";

if (empty($data['level_id']))
    $missing[] = "Level";

if (empty($data['program_id']))
    $missing[] = "Program";

if (!empty($missing)) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing fields: " . implode(", ", $missing)
    ]);
    exit;
}

echo json_encode(["status" => "ok"]);
?>