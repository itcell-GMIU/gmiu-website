<?php
include './include/checklogin.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the request parameters
$request = $_REQUEST;

// Define the total number of records in the database
$cmd = $con->prepare("SELECT COUNT(*) AS totalRecords FROM tbl_inquiry_student WHERE is_delete = ? AND is_admission_confirm = ?");
$status = 0;
$cmd->bind_param("ii", $status, $status);
$cmd->execute();
$result = $cmd->get_result();
$totalRecords = $result->fetch_assoc()['totalRecords'];

// Search functionality
$searchValue = $request['search']['value']; // Search input from DataTables
$searchQuery = "";

if (!empty($searchValue)) {
    $searchValue = $con->real_escape_string($searchValue); // Escape user input
    $searchQuery = " AND (pro.inq_student_id LIKE '%$searchValue%' OR 
                          pro.first_name LIKE '%$searchValue%' OR 
                          pro.middle_name LIKE '%$searchValue%' OR
                          pro.last_name LIKE '%$searchValue%' OR
                          pro.mobile_number LIKE '%$searchValue%' OR 
                          pro.email LIKE '%$searchValue%' OR 
                          faculty.name LIKE '%$searchValue%' OR 
                          level.name LIKE '%$searchValue%' OR 
                          program.name LIKE '%$searchValue%' OR 
                          staff.name LIKE '%$searchValue%' OR 
                          pro.last_exam LIKE '%$searchValue%' OR
                          pro.is_online LIKE '%$searchValue%')";
}

// Fetch filtered total records
$cmd = $con->prepare("SELECT COUNT(*) AS filteredRecords FROM tbl_inquiry_student AS pro 
                      LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id 
                      LEFT JOIN tbl_level level ON pro.level_id = level.id 
                      LEFT JOIN tbl_program program ON pro.program_id = program.id 
                      LEFT JOIN tbl_staff staff ON pro.staff_id = staff.id 
                      WHERE pro.is_delete = ? AND pro.is_admission_confirm = ? $searchQuery");
$cmd->bind_param("ii", $status, $status);
$cmd->execute();
$result = $cmd->get_result();
$filteredRecords = $result->fetch_assoc()['filteredRecords'];

// Fetch data from the database
$cmd = $con->prepare("SELECT pro.id as id, pro.inq_student_id as inq_student_id, pro.first_name, pro.middle_name, pro.last_name, pro.gender,pro.last_school_name, pro.dob, 
                        pro.mobile_number, pro.mobile_number2, pro.email, faculty.name as faculty_name, level.name as level_name, program.name as program_name, 
                        pro.last_exam, pro.is_online, pro.call_count, staff.name as staff_name 
                      FROM tbl_inquiry_student AS pro 
                      LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id 
                      LEFT JOIN tbl_level level ON pro.level_id = level.id 
                      LEFT JOIN tbl_program program ON pro.program_id = program.id 
                      LEFT JOIN tbl_staff staff ON pro.staff_id = staff.id 
                      WHERE pro.is_delete = ? AND pro.is_admission_confirm = ? $searchQuery
                      LIMIT ?, ?");

// Handling pagination limits
$start = (int) $request['start'];
$length = (int) $request['length'];

// Binding parameters and executing
$cmd->bind_param("iiii", $status, $status, $start, $length);
$cmd->execute();
$result = $cmd->get_result();

$data = [];
$sr = $start + 1;

// Fetch and structure data to send to DataTables
while ($row = $result->fetch_assoc()) {
    $last_exam_name = getExamName($row['last_exam']);
    $is_online = $row['is_online'] == 1 ? "Online" : "Offline";

    $data[] = [
        "sr_no" => $sr++,
        "inq_student_id" => $row['inq_student_id'],
        "first_name" => $row['first_name'],
        "middle_name" => $row['middle_name'],
        "last_name" => $row['last_name'],
        "gender" => $row['gender'],
        "last_school_name" => $row['last_school_name'],
        "dob" => date('d-m-Y', strtotime($row['dob'])), // Format DOB
        "mobile_number" => $row['mobile_number'],
        "mobile_number2" => $row['mobile_number2'],
        "email" => $row['email'],
        "faculty_name" => $row['faculty_name'],
        "level_name" => $row['level_name'],
        "program_name" => $row['program_name'],
        "last_exam_name" => $last_exam_name,
        "is_online" => $is_online,
        "staff_name" => $row['staff_name'],
        "call_count" => $row['call_count'],
        "remarks" => "<a href='fetch_remarks.php?id2=" . $row['inq_student_id'] . "' class='btn btn-primary'><i class='fa fa-eye'></i></a>",
        "actions" => "<a href='conform_admission.php?id=" . $row['id'] . "' class='btn btn-primary'><i class='fa fa-check-square'></i></a>"
    ];
}

// Return the data in JSON format
$response = [
    "draw" => intval($request['draw']),
    "recordsTotal" => intval($totalRecords),
    "recordsFiltered" => intval($filteredRecords), // Updated to use filtered records
    "data" => $data
];

echo json_encode($response);

// Helper function to get exam name
function getExamName($exam_code)
{
    $exam_names = [
        '1' => "SSC",
        '2' => "HSC(A)",
        '3' => "HSC(B)",
        '4' => "UG",
        '5' => "HSC(COMMERCE)",
        '6' => "HSC(ARTS)",
        '7' => "PG",
        '8' => "ITI",
        '9' => "DIPLOMA"
    ];

    return $exam_names[$exam_code] ?? "<b>N/A</b>";
}
?>