<?php
session_start();

include '../../common/globalvariable.php';
include '../../database/connect.php';

// ----------------------------
// DataTables Request
// ----------------------------
$draw = (int) ($_POST['draw'] ?? 1);
$start = (int) ($_POST['start'] ?? 0);
$length = (int) ($_POST['length'] ?? 10);
$searchValue = trim($_POST['search']['value'] ?? '');

// Filters
$faculty_id = $_POST['faculty_id'] ?? null;
$program_id = $_POST['program_id'] ?? null;
$level_id = $_POST['level_id'] ?? null;
$role_id = $_POST['role_id'] ?? null;
$url_for = $_POST['url_for'] ?? null;

$staffId = (int) ($_SESSION['staff_id'] ?? 0);

// ----------------------------
// Column map (sorting)
// ----------------------------
$columnMap = [
    1 => 'pro.inq_student_id',
    2 => "CONCAT_WS(' ', pro.first_name, pro.middle_name, pro.last_name)",
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
    7 => 'Post Graduate',
    8 => 'Diploma',
    9 => 'ITI',
    10 => 'Diploma Pharmacy'
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
// WHERE builder
// ----------------------------
$where = [];
$params = [];
$types = "";

// mandatory
$where[] = "pro.is_delete = 0";
$where[] = "pro.is_active = 1";

// filters
if (!empty($faculty_id)) {
    $where[] = "pro.faculty_id = ?";
    $params[] = $faculty_id;
    $types .= "i";
}
if (!empty($program_id)) {
    $where[] = "pro.program_id = ?";
    $params[] = $program_id;
    $types .= "i";
}
if (!empty($level_id)) {
    $where[] = "pro.level_id = ?";
    $params[] = $level_id;
    $types .= "i";
}

// role based
$isOnline = "";
if ($role_id == 12) {
    $where[] = "pro.is_online != 6";
    $isOnline = " AND is_online != 6";
} elseif ($role_id == 13) {
    $where[] = "pro.is_online = 4";
    $isOnline = " AND is_online = 4";
}

// url_for logic (UNCHANGED)
switch ($url_for) {
    case 'inq':
        $where[] = "pro.staff_id IS NOT NULL";
        $where[] = "pro.staff_id != ''";
        $where[] = "pro.is_admission_confirm = 0";
        $where[] = "pro.is_closed = 0";
        break;

    case 'myinq':
        $where[] = "pro.staff_id = $staffId";
        $where[] = "pro.is_admission_confirm = 0";
        $where[] = "pro.is_closed = 0";
        break;

    case 'approvedinq':
        if (in_array($role_id, [15, 16])) {
            $where[] = "pro.confirm_by = $staffId";
        }
        $where[] = "pro.is_admission_confirm = 1";
        $where[] = "pro.is_closed = 0";
        break;

    case 'rejectedinq':
        if (in_array($role_id, [15, 16])) {
            $where[] = "pro.staff_id = $staffId";
        }
        $where[] = "pro.is_admission_confirm = -1";
        $where[] = "pro.is_closed = 0";
        break;

    case 'closedinq':
        if (in_array($role_id, [15, 16])) {
            $where[] = "pro.staff_id = $staffId";
        }
        $where[] = "pro.is_closed = 1";
        break;

    default:
        $where[] = "pro.is_admission_confirm = 0";
        $where[] = "pro.is_closed = 0";
}

// ----------------------------
// Global Search (UNCHANGED)
// ----------------------------
if ($searchValue !== '') {

    $searchValue = preg_replace('/\s+/', ' ', $searchValue);
    $keywords = explode(' ', $searchValue);

    foreach ($keywords as $word) {

        $like = '%' . strtolower($word) . '%';
        $numeric = preg_replace('/\D/', '', $word);
        $mobileLike = $numeric !== '' ? "%$numeric%" : $like;

        $where[] = "(
            LOWER(pro.first_name) LIKE ? OR
            LOWER(pro.middle_name) LIKE ? OR
            LOWER(pro.last_name) LIKE ? OR
            LOWER(pro.inq_student_id) LIKE ? OR
            LOWER(staff.name) LIKE ? OR
            LOWER(staff2.name) LIKE ? OR
            LOWER(faculty.name) LIKE ? OR
            LOWER(level.name) LIKE ? OR
            LOWER(program.name) LIKE ? OR
            LOWER(pro.gender) LIKE ? OR
            pro.mobile_number LIKE ? OR
            LOWER(pro.email) LIKE ?
        )";

        array_push(
            $params,
            $like,
            $like,
            $like,
            $like,
            $like,
            $like,
            $like,
            $like,
            $like,
            $like,
            $mobileLike,
            $like
        );
        $types .= str_repeat('s', 12);
    }
}

$whereSql = implode(' AND ', $where);

// ----------------------------
// Total Records (UNCHANGED LOGIC)
// ----------------------------
$totalRecords = $con->query(
    "SELECT COUNT(*) AS total
     FROM tbl_inquiry_student pro
     WHERE is_delete = 0 AND is_active = 1 $isOnline"
)->fetch_assoc()['total'];

// ----------------------------
// Total Filtered
// ----------------------------
$stmtCount = $con->prepare("
    SELECT COUNT(*)
    FROM tbl_inquiry_student pro
    LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id
    LEFT JOIN tbl_level level ON pro.level_id = level.id
    LEFT JOIN tbl_program program ON pro.program_id = program.id
    LEFT JOIN tbl_staff staff ON pro.staff_id = staff.id
    LEFT JOIN tbl_staff staff2 ON pro.confirm_by = staff2.id
    LEFT JOIN tbl_staff staff3 ON pro.assign_by = staff3.id
    WHERE $whereSql
");

if ($params) {
    $stmtCount->bind_param($types, ...$params);
}
$stmtCount->execute();
$totalFiltered = $stmtCount->get_result()->fetch_row()[0];

// ----------------------------
// ORDER BY
// ----------------------------
$orderSql = " ORDER BY pro.id DESC";
if (!empty($_POST['order'][0])) {
    $idx = (int) $_POST['order'][0]['column'];
    $dir = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
    if (isset($columnMap[$idx])) {
        $orderSql = " ORDER BY {$columnMap[$idx]} $dir";
    }
}

// pagination
$params[] = $start;
$params[] = $length;
$types .= "ii";

// ----------------------------
// Final Query (OPTIMIZED)
// ----------------------------
$sql = "
SELECT
    pro.*,
    staff.name  AS staff_name,
    staff2.name AS confirm_by_name,
    staff3.name AS assign_by_name,
    faculty.shortname AS faculty_name,
    level.short_name  AS level_name,
    program.name AS program_name,
    IFNULL(cl.call_count,0) AS call_count
FROM tbl_inquiry_student pro
LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id
LEFT JOIN tbl_level level ON pro.level_id = level.id
LEFT JOIN tbl_program program ON pro.program_id = program.id
LEFT JOIN tbl_staff staff ON pro.staff_id = staff.id
LEFT JOIN tbl_staff staff2 ON pro.confirm_by = staff2.id
LEFT JOIN tbl_staff staff3 ON pro.assign_by = staff3.id
LEFT JOIN (
    SELECT inq_student_id, COUNT(*) AS call_count
    FROM tbl_inquiry_call_logs
    WHERE is_active = 1 AND is_delete = 0
    GROUP BY inq_student_id
) cl ON cl.inq_student_id = pro.inq_student_id
WHERE $whereSql
$orderSql
LIMIT ?, ?
";

$stmt = $con->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// ----------------------------
// Build Response
// ----------------------------
$data = [];
$sr_no = $start + 1;

while ($row = $result->fetch_assoc()) {

    $row['sr_no'] = $sr_no++;
    $row['last_exam'] = $lastExamOptions[$row['last_exam']] ?? 'N/A';
    $row['is_online'] = $isOnlineOptions[$row['is_online']] ?? 'N/A';
    $row['admission_status'] = ($row['is_admission_confirm'] == 1) ? 'Confirmed' : 'Pending';

    $data[] = $row;
}

// ----------------------------
// Output
// ----------------------------
echo json_encode([
    "draw" => $draw,
    "recordsTotal" => (int) $totalRecords,
    "recordsFiltered" => (int) $totalFiltered,
    "data" => $data
]);
