<?php
session_start();

include '../../common/globalvariable.php';
include '../../database/connect.php';
// include '../../common/function.php';
// include '../../common/validation.php';

// ----------------------------
// DataTables Request
// ----------------------------
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

// Optional filters from frontend (can be passed via POST or GET)
$faculty_id = isset($_POST['faculty_id']) ? $_POST['faculty_id'] : null;
$program_id = isset($_POST['program_id']) ? $_POST['program_id'] : null;
$level_id = isset($_POST['level_id']) ? $_POST['level_id'] : null;
$role_id = isset($_POST['role_id']) ? $_POST['role_id'] : null;
$url_for = isset($_POST['url_for']) ? $_POST['url_for'] : null;


// ----------------------------
// Mapping arrays
// ----------------------------
$lastExamOptions = [
    1 => '10th',
    2 => '12th Commerce',
    3 => '12th Science (A Group)',
    4 => '12th Science (B Group)',
    5 => '12th Arts',
    6 => 'Graduate',
    7 => 'Post Graduate'
];

$isOnlineOptions = [
    1 => 'Website',
    2 => 'Whatsapp',
    3 => 'Other',
    4 => 'Walk In',
    5 => 'E-Mail',
    6 => 'Confidential'
];

// ----------------------------
// Base Query with Joins
// ----------------------------
$baseSql = "FROM tbl_inquiry_student as pro
LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id 
LEFT JOIN tbl_level level ON pro.level_id = level.id 
LEFT JOIN tbl_program program ON pro.program_id = program.id
LEFT JOIN tbl_staff staff ON pro.staff_id = staff.id  
LEFT JOIN tbl_staff staff2 ON pro.counselor_id = staff2.id
LEFT JOIN tbl_staff staff3 ON pro.assign_by = staff3.id
WHERE pro.is_delete = 0 AND pro.is_active = 1";

// ----------------------------
// Dynamic Filters
// ----------------------------
$params = [];
$types = "";

// Faculty filter
if (!empty($faculty_id)) {
    $baseSql .= " AND pro.faculty_id = ?";
    $params[] = $faculty_id;
    $types .= "i";
}

// Program filter
if (!empty($program_id)) {
    $baseSql .= " AND pro.program_id = ?";
    $params[] = $program_id;
    $types .= "i";
}

// Level filter
if (!empty($level_id)) {
    $baseSql .= " AND pro.level_id = ?";
    $params[] = $level_id;
    $types .= "i";
}

// Role Id filter
$isOnline = "";
if (!empty($role_id)) {
    if ($role_id == 57) {
        $baseSql .= " AND pro.is_online = 6";
        $isOnline .= " AND is_online = 6";
    } elseif ($role_id == 12) {
        $baseSql .= " AND pro.is_online != 6";
        $isOnline .= " AND is_online != 6";
    } elseif ($role_id == 13) {
        $baseSql .= " AND pro.is_online != 6";
        $isOnline .= " AND is_online != 6";
    }
}

// URL for filter
$urlForQue = "";
if (!empty($url_for)) {
    if ($url_for == 'inq') {
        $baseSql .= " AND pro.staff_id IS NOT NULL AND pro.staff_id != ''";
        $urlForQue .= " AND pro.staff_id IS NOT NULL AND pro.staff_id != ''";
    } elseif ($url_for == 'myinq') {
        $baseSql .= " AND pro.staff_id = " . $_SESSION['staff_id'];
        $urlForQue .= " AND pro.staff_id = " . $_SESSION['staff_id'];
    }
}

// Global search
if (!empty($searchValue)) {
    $baseSql .= " AND (
        pro.first_name LIKE ? OR pro.middle_name LIKE ? OR pro.last_name LIKE ? OR
        pro.inq_student_id LIKE ? OR
        staff.name LIKE ? OR staff2.name LIKE ? OR
        faculty.name LIKE ? OR level.name LIKE ? OR program.name LIKE ? OR
        pro.gender LIKE ? OR pro.mobile_number LIKE ? OR pro.email LIKE ?
    )";
    $like = "%$searchValue%";
    $params = array_merge($params, array_fill(0, 12, $like));
    $types .= str_repeat("s", 12);
}

// ----------------------------
// Total Records
// ----------------------------
$totalRecords = $con->query("SELECT COUNT(*) as total FROM tbl_inquiry_student as pro WHERE is_delete=0 AND is_active=1 $isOnline $urlForQue")->fetch_assoc()['total'];

// ----------------------------
// Total Filtered Records
// ----------------------------
$stmtCount = $con->prepare("SELECT COUNT(*) as total $baseSql");
if (!empty($params)) {
    $stmtCount->bind_param($types, ...$params);
}
$stmtCount->execute();
$totalFiltered = $stmtCount->get_result()->fetch_assoc()['total'];

// ----------------------------
// Pagination
// ----------------------------
$baseSql .= " ORDER BY pro.id DESC LIMIT ?, ?";
$params[] = $start;
$params[] = $length;
$types .= "ii";

// ----------------------------
// Final Data Query
// ----------------------------
$sql = "SELECT 
        pro.is_admission_confirm as is_admission_confirm,
        pro.id as id,
        pro.last_exam_status as exam_status ,
        staff2.name as counselor_name,
        pro.is_admission_confirm as admission_status ,
        pro.id as id,pro.staff_id as staff_id ,
        staff.name as staff_name,
        staff2.name as counselor_name,
        staff3.name as assign_by_name,
        pro.inq_student_id as inq_student_id,
        pro.first_name as first_name ,
        pro.middle_name as middle_name,
        pro.last_name as last_name,
        pro.last_school_name as last_school_name,
        pro.gender as gender,
        pro.dob as dob,
        pro.mobile_number as mobile_number,
        pro.mobile_number2 as mobile_number2,
        pro.email as email,
        pro.faculty_id as faculty_id,
        pro.level_id as level_id,
        pro.program_id as program_id,
        pro.last_exam as last_exam,
        pro.last_exam_marks as last_exam_mark,
        pro.is_online as is_online,
        --pro.call_count as call_count,
        (
            SELECT COUNT(*) 
            FROM tbl_inquiry_call_logs AS cl 
            WHERE cl.inq_student_id = pro.inq_student_id
              AND cl.is_active = 1
              AND cl.is_delete = 0
        ) AS call_count,
        
        pro.specify_degree as specify_degree,
        faculty.name as faculty_name,
        level.name as level_name ,
        program.name as program_name
        $baseSql";

$stmt = $con->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// ----------------------------
// Build Data Array
// ----------------------------
$data = [];
$sr_no = $start + 1;
while ($row = $result->fetch_assoc()) {
    $fullName = trim($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);

    // You can pass parameters to action buttons using query strings
    $viewUrl = "candidate-view.php?id=" . urlencode($row['id']);
    $editUrl = "candidate-edit.php?id=" . urlencode($row['id']);
    // $deleteUrl = "candidate-delete.php?id=" . urlencode($row['id']);

    // $data[] = [
    //     $sr_no++,
    //     $row['inq_student_id'] ?? 'N/A',
    //     $row['first_name'] ?? 'N/A',
    //     $row['middle_name'] ?? 'N/A',
    //     $row['last_name'] ?? 'N/A',
    //     $row['gender'] ?? 'N/A',
    //     $row['mobile_number'] ?? 'N/A',
    //     $row['mobile_number2'] ?? 'N/A',
    //     $row['email'] ?? 'N/A',
    //     $row['faculty_name'] ?? 'N/A',
    //     $row['level_name'] ?? 'N/A',
    //     $row['program_name'] ?? 'N/A',
    //     $row['last_school_name'] ?? 'N/A',
    //     $lastExamOptions[$row['last_exam']] ?? 'N/A',
    //     $row['exam_status'] ?? 'N/A',
    //     $row['specify_degree'] ?? 'N/A',
    //     isset($row['is_admission_confirm'])
    //     ? ($row['is_admission_confirm'] ? 'Confirmed' : 'Pending')
    //     : 'N/A',
    //     $isOnlineOptions[$row['is_online']] ?? 'N/A',
    //     $row['staff_name'] ?? 'N/A',
    //     $row['counselor_name'] ?? 'N/A',
    //     $row['call_count'] ?? 'N/A',
    //     '<div class="dropdown">
    //         <a href="#" class="btn btn-sm btn-primary">View</a>
    //         <a href="#" class="btn btn-sm btn-success">Edit</a>
    //         <a href="#" class="btn btn-sm btn-danger">Delete</a>
    //     </div>'
    // ];

    $row['sr_no'] = $sr_no++;
    $row['last_exam'] = isset($lastExamOptions[$row['last_exam']]) ? $lastExamOptions[$row['last_exam']] : 'N/A';
    $row['is_online'] = isset($isOnlineOptions[$row['is_online']]) ? $isOnlineOptions[$row['is_online']] : 'N/A';
    $row['admission_status'] = ($row['is_admission_confirm'] == 1) ? 'Confirmed' : 'Pending';
    $row['action'] = '<div class="dropdown">
    <a href="' . $viewUrl . '" class="btn btn-sm btn-primary">View</a>
    <a href="' . $editUrl . '" class="btn btn-sm btn-success">Edit</a>
    </div>';
    // <a href="' . $deleteUrl . '" class="btn btn-sm btn-danger">Delete</a>

    // Append the whole object
    $data[] = $row;
}

// ----------------------------
// Return JSON for DataTables
// ----------------------------
echo json_encode([
    "draw" => $draw,
    "recordsTotal" => intval($totalRecords),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
]);
