<?php
session_start();
include '../../common/globalvariable.php';
include '../../database/connect.php';

// ----------------------------
// DataTables Request & Filters
// ----------------------------
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

$faculty_id = $_POST['faculty_id'] ?? null;
$program_id = $_POST['program_id'] ?? null;
$level_id = $_POST['level_id'] ?? null;
$role_id = $_POST['role_id'] ?? null;
$url_for = $_POST['url_for'] ?? null;
$staff_id_sess = $_SESSION['staff_id'] ?? 0;

$columnMap = [
    1 => 'pro.inq_student_id',
    2 => "full_name",
    3 => 'pro.gender',
    7 => 'faculty.shortname',
    8 => 'level.short_name',
    9 => 'program.name',
    10 => 'pro.last_exam',
    11 => 'pro.last_exam_status',
    12 => 'pro.is_admission_confirm',
    13 => 'pro.is_online',
    14 => 'staff.name',
    15 => 'staff2.name',
    16 => 'staff3.name',
    17 => 'call_count',
    18 => 'pro.mobile_number',
    19 => 'pro.mobile_number2',
    20 => 'pro.email'
];

$lastExamOptions = [1 => '10th', 2 => '12th Commerce', 3 => '12th Science (A Group)', 4 => '12th Science (B Group)', 5 => '12th Arts', 6 => 'Graduate', 7 => 'Post Graduate', 8 => 'Diploma', 9 => 'ITI', 10 => 'Diploma Pharmacy'];
$isOnlineOptions = [1 => 'Website', 2 => 'Whatsapp', 3 => 'Other', 4 => 'Walk In', 5 => 'E-Mail', 6 => 'Confidential'];

// ----------------------------
// Build Base Where Clause
// ----------------------------
$whereClauses = ["pro.is_delete = 0", "pro.is_active = 1"];
$params = [];
$types = "";

if (!empty($faculty_id)) {
    $whereClauses[] = "pro.faculty_id = ?";
    $params[] = $faculty_id;
    $types .= "i";
}
if (!empty($program_id)) {
    $whereClauses[] = "pro.program_id = ?";
    $params[] = $program_id;
    $types .= "i";
}
if (!empty($level_id)) {
    $whereClauses[] = "pro.level_id = ?";
    $params[] = $level_id;
    $types .= "i";
}

// Role Logic
if ($role_id == 12) {
    $whereClauses[] = "pro.is_online != 6";
} elseif ($role_id == 13) {
    $whereClauses[] = "pro.is_online = 4";
}

// URL Logic
if ($url_for == 'inq') {
    $whereClauses[] = "pro.staff_id IS NOT NULL AND pro.staff_id != '' AND pro.is_admission_confirm = 0 AND pro.is_closed = 0";
} elseif ($url_for == 'myinq') {
    $whereClauses[] = "pro.staff_id = ? AND pro.is_admission_confirm = 0 AND pro.is_closed = 0";
    $params[] = $staff_id_sess;
    $types .= "i";
} elseif ($url_for == 'approvedinq') {
    $whereClauses[] = "pro.is_admission_confirm = 1 AND pro.is_closed = 0";
    if (in_array($role_id, [15, 16])) {
        $whereClauses[] = "pro.confirm_by = ?";
        $params[] = $staff_id_sess;
        $types .= "i";
    }
} elseif ($url_for == 'rejectedinq') {
    $whereClauses[] = "pro.is_admission_confirm = -1 AND pro.is_closed = 0";
    if (in_array($role_id, [15, 16])) {
        $whereClauses[] = "pro.staff_id = ?";
        $params[] = $staff_id_sess;
        $types .= "i";
    }
} elseif ($url_for == 'closedinq') {
    $whereClauses[] = "pro.is_closed = 1";
    if (in_array($role_id, [15, 16])) {
        $whereClauses[] = "pro.staff_id = ?";
        $params[] = $staff_id_sess;
        $types .= "i";
    }
} else {
    $whereClauses[] = "pro.is_admission_confirm = 0 AND pro.is_closed = 0";
}

// Global Search (Optimized)
if (!empty($searchValue)) {
    $keywords = explode(' ', preg_replace('/\s+/', ' ', $searchValue));
    foreach ($keywords as $word) {
        $like = '%' . $word . '%';
        $whereClauses[] = "(pro.first_name LIKE ? OR pro.middle_name LIKE ? OR pro.last_name LIKE ? OR pro.inq_student_id LIKE ? OR staff.name LIKE ? OR faculty.name LIKE ? OR program.name LIKE ? OR pro.mobile_number LIKE ? OR pro.email LIKE ?)";
        for ($i = 0; $i < 9; $i++) {
            $params[] = $like;
            $types .= "s";
        }
    }
}

$whereSql = " WHERE " . implode(" AND ", $whereClauses);

// ----------------------------
// Optimized Totals
// ----------------------------
// Total unfiltered
$totalRecords = $con->query("SELECT COUNT(id) FROM tbl_inquiry_student WHERE is_delete=0 AND is_active=1")->fetch_row()[0];

// Total filtered
$stmtCount = $con->prepare("SELECT COUNT(pro.id) FROM tbl_inquiry_student pro 
    LEFT JOIN tbl_staff staff ON pro.staff_id = staff.id 
    LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id
    LEFT JOIN tbl_program program ON pro.program_id = program.id $whereSql");
if ($types)
    $stmtCount->bind_param($types, ...$params);
$stmtCount->execute();
$totalFiltered = $stmtCount->get_result()->fetch_row()[0];

// ----------------------------
// Data Query (Replaced Subquery with Join)
// ----------------------------
$orderSql = " ORDER BY pro.id DESC";
if (isset($_POST['order'][0]['column']) && isset($columnMap[intval($_POST['order'][0]['column'])])) {
    $dir = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
    $orderSql = " ORDER BY " . $columnMap[intval($_POST['order'][0]['column'])] . " $dir";
}

$sql = "SELECT pro.*, 
        CONCAT_WS(' ', pro.first_name, pro.middle_name, pro.last_name) AS full_name,
        staff.name as staff_name, staff2.name as confirm_by_name, staff3.name as assign_by_name,
        faculty.shortname as faculty_name, level.short_name as level_name, program.name as program_name,
        COUNT(cl.id) as call_count
        FROM tbl_inquiry_student pro
        LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id 
        LEFT JOIN tbl_level level ON pro.level_id = level.id 
        LEFT JOIN tbl_program program ON pro.program_id = program.id
        LEFT JOIN tbl_staff staff ON pro.staff_id = staff.id  
        LEFT JOIN tbl_staff staff2 ON pro.confirm_by = staff2.id
        LEFT JOIN tbl_staff staff3 ON pro.assign_by = staff3.id
        LEFT JOIN tbl_inquiry_call_logs cl ON cl.inq_student_id = pro.inq_student_id AND cl.is_active = 1 AND cl.is_delete = 0
        $whereSql
        GROUP BY pro.id
        $orderSql LIMIT ?, ?";

$params[] = $start;
$params[] = $length;
$types .= "ii";

$stmt = $con->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
$sr_no = $start + 1;
while ($row = $result->fetch_assoc()) {
    $viewUrl = "candidate-details.php?id=" . $row['id'];
    $editUrl = "candidate-edit.php?id=" . $row['id'];

    // Action Buttons Logic (Logic preserved as requested)
    $callBtn = "";
    $admissionBtn = "";
    if (($row['call_count'] < $row['call_count'] && in_array($role_id, [16, 12, 15]) && !in_array($url_for, ['rejectedinq', 'approvedinq', 'closedinq'])) || $role_id == 57) {
        $callBtn .= '<a href="' . $viewUrl . '" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i></a> ';
        if ($role_id != 15)
            $callBtn .= '<a href="' . $editUrl . '" class="btn btn-sm btn-secondary"><i class="fa-solid fa-pen-to-square"></i></a> ';
        if (!in_array($url_for, ['rejectedinq', 'approvedinq']) && in_array($role_id, [15, 16])) {
            $callBtn .= '<a href="#" class="btn btn-sm btn-info" onclick="openCallStatusModal(' . $row['id'] . ',\'' . $row['inq_student_id'] . '\')"><i class="fa-solid fa-phone"></i></a> ';
        }
    }

    if ($role_id == 57 && $url_for == 'inq') {
        $callBtn .= '<a href="#" class="btn btn-sm btn-warning" onclick="openCallIncreaseModal(' . $row['id'] . ',\'' . $row['inq_student_id'] . '\')"><i class="fa-solid fa-phone"></i>+</a> ';
        $admissionBtn .= '<a href="#" class="btn btn-sm btn-success" onclick="admissionStatusUpdate(' . $row['id'] . ',\'' . $row['inq_student_id'] . '\', 1)"><i class="fa-solid fa-check"></i></a>';
    }

    $row['sr_no'] = $sr_no++;
    $row['last_exam'] = $lastExamOptions[$row['last_exam']] ?? 'N/A';
    $row['is_online'] = $isOnlineOptions[$row['is_online']] ?? 'N/A';
    $row['admission_status'] = ($row['is_admission_confirm'] == 1) ? 'Confirmed' : 'Pending';
    $row['action'] = '<div class="dropdown">' . $callBtn . '</div>';
    $row['admissionBtn'] = $admissionBtn;

    $data[] = $row;
}

echo json_encode([
    "draw" => $draw,
    "recordsTotal" => intval($totalRecords),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
]);