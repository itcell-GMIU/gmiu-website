<?php
// --- START: Error Handling for AJAX ---
// Report all errors, but do not display them to the user
error_reporting(E_ALL);
ini_set('display_errors', 0);
// It's better to log errors to a file in a production environment
// ini_set('log_errors', 1);
// ini_set('error_log', '/path/to/your/php-error.log');

// Set the content type to JSON
header('Content-Type: application/json; charset=utf-8');
// --- END: Error Handling for AJAX ---

include "../include/checklogin.php";

// 1. --- Read Parameters Sent by DataTables ---
$draw = $_POST['draw'] ?? 1;
$start = $_POST['start'] ?? 0;
$length = $_POST['length'] ?? 100;
$searchValue = $_POST['search']['value'] ?? '';
$orderColumnIndex = $_POST['order'][0]['column'] ?? 0;
$orderDir = $_POST['order'][0]['dir'] ?? 'asc';

$columns = [
    'pro.id',
    'pro.inq_student_id',
    'pro.first_name',
    'pro.middle_name',
    'pro.last_name',
    'pro.gender',
    'pro.last_school_name',
    'pro.mobile_number',
    'pro.mobile_number2',
    'pro.email',
    'faculty.name',
    'level.name',
    'program.name',
    'pro.last_exam',
    'pro.last_exam_status',
    'pro.is_admission_confirm',
    'pro.is_online',
    'staff.name',
    'staff2.name',
    'pro.call_count'
];
$orderColumn = $columns[$orderColumnIndex] ?? 'pro.id';


// 2. --- Get Total Record Count ---
$totalRecordsQuery = $con->query("SELECT COUNT(id) as allcount FROM tbl_inquiry_student WHERE is_delete = 0");
$totalRecordsData = $totalRecordsQuery->fetch_assoc();
$totalRecords = $totalRecordsData['allcount'];


// 3. --- Build the Main Query (with Searching) ---
$status = 0;
$params = ['i' => &$status];
$param_types = 'i';
$searchQuery = "";

if (!empty($searchValue)) {
    $searchableColumns = [
        'pro.inq_student_id',
        'pro.first_name',
        'pro.middle_name',
        'pro.last_name',
        'pro.email',
        'pro.mobile_number',
        'staff.name',
        'staff2.name'
    ];
    $searchQuery = " AND (";
    $searchParam = "%{$searchValue}%";
    $first = true;
    foreach ($searchableColumns as $column) {
        if (!$first) {
            $searchQuery .= " OR ";
        }
        $searchQuery .= "$column LIKE ?";
        $param_types .= 's';
        $params[] = &$searchParam;
        $first = false;
    }
    $searchQuery .= ")";
}

$sql = "SELECT 
    pro.is_admission_confirm, pro.id, pro.last_exam_status as exam_status, staff2.name as counselor_name,
    pro.staff_id, staff.name as staff_name, pro.inq_student_id, pro.first_name, pro.middle_name, 
    pro.last_name, pro.last_school_name, pro.gender, pro.dob, pro.mobile_number, pro.mobile_number2, 
    pro.email, pro.faculty_id, pro.level_id, pro.program_id, pro.last_exam, pro.last_exam_marks, 
    pro.is_online, pro.call_count, faculty.name as faculty_name, level.name as level_name,
    program.name as program_name
FROM 
    tbl_inquiry_student as pro
LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id 
LEFT JOIN tbl_level level ON pro.level_id = level.id 
LEFT JOIN tbl_program program ON pro.program_id = program.id
LEFT JOIN tbl_staff staff ON pro.staff_id = staff.id   
LEFT JOIN tbl_staff staff2 ON pro.counselor_id = staff2.id
WHERE pro.is_delete = ? " . $searchQuery;


// 4. --- Get Filtered Record Count ---
$count_sql = "SELECT COUNT(*) as filtered_count FROM tbl_inquiry_student as pro LEFT JOIN tbl_staff staff ON pro.staff_id = staff.id LEFT JOIN tbl_staff staff2 ON pro.counselor_id = staff2.id WHERE pro.is_delete = ? " . $searchQuery;
$stmt = $con->prepare($count_sql);
$stmt->bind_param($param_types, ...array_values($params));
$stmt->execute();
$totalFilteredRecords = $stmt->get_result()->fetch_assoc()['filtered_count'];
$stmt->close();


// 5. --- Add Ordering and Pagination ---
$sql .= " ORDER BY $orderColumn $orderDir LIMIT ?, ?";
$param_types .= 'ii';
$params[] = &$start;
$params[] = &$length;

$stmt = $con->prepare($sql);
$stmt->bind_param($param_types, ...array_values($params));
$stmt->execute();
$result = $stmt->get_result();
$data = [];
$sr = $start;

// 6. --- Process and Format Data ---
while ($row = $result->fetch_assoc()) {
    $sr++;

    // Your existing data formatting logic
    $last_exam_name = "<b>N/A</b>";
    $examMap = ['1' => 'SSC', '2' => 'HSC(A)', '3' => 'HSC(B)', '4' => 'UG', '5' => 'HSC(COMMERCE)', '6' => 'HSC(ARTS)', '7' => 'PG', '8' => 'ITI', '9' => 'DIPLOMA'];
    if (isset($examMap[$row['last_exam']]))
        $last_exam_name = $examMap[$row['last_exam']];

    $status_text = "<b>N/A</b>";
    if ($row['exam_status'] == '1')
        $status_text = "PASS";
    elseif ($row['exam_status'] == '2')
        $status_text = "Appeared";

    $mode = "N/A";
    $modeMap = ['0' => 'Walk-In', '1' => 'Website', '2' => 'WhatsApp', '3' => 'Other', '4' => 'Walk In', '5' => 'E-Mail'];
    if (isset($modeMap[$row['is_online']]))
        $mode = $modeMap[$row['is_online']];

    $admission_status = ($row['is_admission_confirm'] == 1) ? "Admission Confirm" : "Inquiry";

    $data[] = [
        "Sr" => $sr,
        "inquiry Id" => $row['inq_student_id'] ?? 'N/A',
        "First Name" => $row['first_name'] ?? 'N/A',
        "middle Name" => $row['middle_name'] ?? 'N/A',
        "Last Name" => $row['last_name'] ?? 'N/A',
        "Gender" => $row['gender'] ?? 'N/A',
        "last_school_name" => $row['last_school_name'] ?? 'N/A',
        "Mobile Number 1" => $row['mobile_number'] ?? 'N/A',
        "Mobile Number 2" => $row['mobile_number2'] ?? 'N/A',
        "Email" => $row['email'] ?? 'N/A',
        "Faculty Name" => $row['faculty_name'] ?? 'N/A',
        "Level Name" => $row['level_name'] ?? 'N/A',
        "Program Name" => $row['program_name'] ?? 'N/A',
        "Last Exam" => $last_exam_name,
        "Last Exam Status" => $status_text,
        "Status" => $admission_status,
        "Inquiry Mode" => $mode,
        "Assign Staff" => $row['staff_name'] ?? 'N/A',
        "Counselor" => $row['counselor_name'] ?? 'N/A',
        "call_count" => $row['call_count'] ?? 'N/A',
        "Remarks" => '<a href="../common/fetch_remarks.php?id2=' . $row['inq_student_id'] . '" class="btn btn-primary"><i class="fa fa-eye"></i></a>',
        "Action" => '<a href="student_edit.php?id=' . $row['id'] . '" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>'
    ];
}

// 7. --- Send the Final JSON Response ---
$response = [
    "draw" => intval($draw),
    "recordsTotal" => intval($totalRecords),
    "recordsFiltered" => intval($totalFilteredRecords),
    "data" => $data
];

echo json_encode($response);
exit;