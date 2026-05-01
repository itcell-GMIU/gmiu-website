<?php
session_start();

include '../../common/globalvariable.php';
include '../../database/connect.php';

// ----------------------------
// DataTables Request
// ----------------------------
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

// Optional filters from frontend
$faculty_id = isset($_POST['faculty_id']) ? $_POST['faculty_id'] : null;
$program_id = isset($_POST['program_id']) ? $_POST['program_id'] : null;
$level_id = isset($_POST['level_id']) ? $_POST['level_id'] : null;
$role_id = isset($_POST['role_id']) ? $_POST['role_id'] : null;
$url_for = isset($_POST['url_for']) ? $_POST['url_for'] : null;
$assigned_date = isset($_POST['assigned_date']) ? trim($_POST['assigned_date']) : null;
$call_count = isset($_POST['call_count']) ? trim($_POST['call_count']) : null;
$inquiry_type = isset($_POST['inquiry_type']) ? trim($_POST['inquiry_type']) : null;

/**
 * Column mapping for DataTables server-side sorting.
 * Indices must match the table columns in candidate-view.php.
 */
$columnMap = [
    1 => 'pro.inq_student_id',
    2 => "CONCAT_WS(' ', pro.first_name, pro.middle_name, pro.last_name)",
    3 => 'pro.gender',
    4 => 'pro.mobile_number',
    5 => 'pro.mobile_number2',
    6 => 'pro.email',
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
    17 => 'call_count'
];

// Mapping for display
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
// Base Query Construction
// ----------------------------
$fromSql = "FROM tbl_inquiry_student as pro";
$joinSql = " LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id 
             LEFT JOIN tbl_level level ON pro.level_id = level.id 
             LEFT JOIN tbl_program program ON pro.program_id = program.id
             LEFT JOIN tbl_staff staff ON pro.staff_id = staff.id  
             LEFT JOIN tbl_staff staff2 ON pro.confirm_by = staff2.id
             LEFT JOIN tbl_staff staff3 ON pro.assign_by = staff3.id ";

$whereSql = " WHERE pro.is_delete = 0 AND pro.is_active = 1 ";
$params = [];
$types = "";

// Filters
if (!empty($faculty_id)) {
    $whereSql .= " AND pro.faculty_id = ?";
    $params[] = $faculty_id;
    $types .= "i";
}
if (!empty($program_id)) {
    $whereSql .= " AND pro.program_id = ?";
    $params[] = $program_id;
    $types .= "i";
}
if (!empty($level_id)) {
    $whereSql .= " AND pro.level_id = ?";
    $params[] = $level_id;
    $types .= "i";
}
if (!empty($assigned_date) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $assigned_date)) {
    $joinSql .= " LEFT JOIN tbl_inquiry_assign_log_pivot assign_log_piv ON assign_log_piv.inq_student_id = pro.inq_student_id";
    $whereSql .= " AND DATE(assign_log_piv.created_at) = ?";
    $params[] = $assigned_date;
    $types .= "s";
}
if (!empty($call_count)) {
    // 'call_count' is a SELECT-level alias — it cannot be referenced in WHERE.
    // Use a correlated subquery directly in the WHERE clause instead.
    $callLogSubQuery = "(SELECT COUNT(*) FROM tbl_inquiry_call_logs cl WHERE cl.inq_student_id = pro.inq_student_id AND cl.is_active = 1 AND cl.is_delete = 0)";
    if ($call_count === '3+') {
        // More than or equal to 3 actual calls logged
        $whereSql .= " AND $callLogSubQuery > 3";
    } elseif (is_numeric($call_count)) {
        $whereSql .= " AND $callLogSubQuery = ?";
        $params[] = (int) $call_count;
        $types .= "i";
    }
}

if (!empty($role_id)) {
    if (!empty($inquiry_type) && !in_array($role_id, [15, 16])) {
        $whereSql .= " AND pro.is_online = ?";
        $params[] = $inquiry_type;
        $types .= "i";
    }
}

$isOnline = "";
// Role-based visiblity
if (!empty($role_id)) {
    if ($role_id == 12) {
        $whereSql .= " AND pro.is_online != 6";
        $isOnline .= " AND pro.is_online != 6";
    } elseif ($role_id == 13) {
        $whereSql .= " AND pro.is_online = 4";
        $isOnline .= " AND pro.is_online = 4";
    }
}

// URL for filter
$urlForQue = "";
if (!empty($url_for)) {
    $condition = "";
    $role_id_group = in_array($role_id, [11, 12, 57, 60]);

    if ($url_for == 'inq') {
        if ($role_id == 14) {
            $condition = " AND pro.staff_id IN (" . $_SESSION['u_staff_id'] . ") AND is_admission_confirm = 0 AND is_closed = 0";
        } else {
            $condition = " AND pro.staff_id IS NOT NULL AND pro.staff_id != '' AND is_admission_confirm = 0 AND is_closed = 0";
        }
    } elseif ($url_for == 'myinq') {
        $condition = " AND pro.staff_id = " . $_SESSION['staff_id'] . " AND is_admission_confirm = 0 AND is_closed = 0";
    } elseif ($url_for == 'approvedinq') {
        if ($role_id == 15 || $role_id == 16) {
            $condition = " AND pro.confirm_by = " . $_SESSION['staff_id'] . " AND is_admission_confirm = 1";
        } elseif ($role_id_group) {
            $condition = " AND is_admission_confirm = 1";
        } elseif ($role_id == 14) {
            $condition = " AND is_admission_confirm = 1 AND pro.confirm_by IN (" . $_SESSION['u_staff_id'] . ")";
        }
    } elseif ($url_for == 'rejectedinq') {
        if ($role_id == 15 || $role_id == 16) {
            $condition = " AND pro.staff_id = " . $_SESSION['staff_id'] . " AND is_admission_confirm = -1 AND is_closed = 0";
        } elseif ($role_id_group) {
            $condition = " AND is_admission_confirm = -1 AND is_closed = 0";
        } elseif ($role_id == 14) {
            $condition = " AND is_admission_confirm = -1 AND is_closed = 0 AND pro.staff_id IN (" . $_SESSION['u_staff_id'] . ")";
        }
    } elseif ($url_for == 'closedinq') {
        if ($role_id == 15 || $role_id == 16) {
            $condition = " AND pro.staff_id = " . $_SESSION['staff_id'] . " AND pro.closed_by = " . $_SESSION['staff_id'] . " AND is_closed = 1";
        } elseif ($role_id_group) {
            $condition = " AND is_closed = 1";
        } elseif ($role_id == 14) {
            $condition = " AND is_closed = 1 AND pro.staff_id IN (" . $_SESSION['u_staff_id'] . ") AND pro.closed_by IN (" . $_SESSION['u_staff_id'] . ")";
        }
    } elseif ($url_for == 'approvedbyother') {
        if ($role_id == 15 || $role_id == 16) {
            $condition = " AND pro.staff_id = " . $_SESSION['staff_id'] . " AND pro.confirm_by != " . $_SESSION['staff_id'] . " AND is_admission_confirm = 1";
        }
    } elseif ($url_for == 'notassignedinq') {
        $condition = " AND (pro.staff_id IS NULL OR pro.staff_id = 0 OR pro.staff_id = '')";
    }
    $whereSql .= $condition;
    $urlForQue .= $condition;
} else {
    $whereSql .= " AND is_admission_confirm = 0 AND is_closed = 0";
    $urlForQue .= " AND is_admission_confirm = 0 AND is_closed = 0";
}

// Global search optimization
if (!empty($searchValue)) {
    $searchValue = trim(preg_replace('/\s+/', ' ', $searchValue));
    $tempSearch = $searchValue;
    $examOptionsCopy = $lastExamOptions;
    uasort($examOptionsCopy, function ($a, $b) {
        return strlen($b) - strlen($a);
    });

    foreach ($examOptionsCopy as $id => $name) {
        $pattern = '/(?<!\w)' . preg_quote(strtolower(trim($name)), '/') . '(?!\w)/i';
        if (preg_match($pattern, $tempSearch)) {
            $whereSql .= " AND pro.last_exam = ?";
            $params[] = $id;
            $types .= "i";
            $tempSearch = preg_replace($pattern, '', $tempSearch);
        }
    }

    $keywords = explode(' ', trim($tempSearch));
    foreach ($keywords as $word) {
        if (($word = trim($word)) === '')
            continue;
        $like = '%' . $word . '%';
        $numeric = preg_replace('/\D/', '', $word);
        $mobileLike = $numeric !== '' ? '%' . $numeric . '%' : $like;

        if (strpos($word, '@') !== false) {
            if (strpos($word, '.', strpos($word, '@')) !== false) {
                $whereSql .= " AND TRIM(pro.email) = ?";
                $params[] = strtolower($word);
                $types .= "s";
            } else {
                $whereSql .= " AND pro.email LIKE ?";
                $params[] = $like;
                $types .= "s";
            }
            continue;
        }

        $whereSql .= " AND (pro.first_name LIKE ? OR pro.middle_name LIKE ? OR pro.last_name LIKE ? OR pro.inq_student_id LIKE ? OR staff.name LIKE ? OR staff2.name LIKE ? OR staff3.name LIKE ? OR faculty.name LIKE ? OR level.name LIKE ? OR program.name LIKE ? OR pro.gender LIKE ? OR pro.mobile_number LIKE ? OR pro.email LIKE ?)";
        array_push($params, $like, $like, $like, $like, $like, $like, $like, $like, $like, $like, $like, $mobileLike, $like);
        $types .= str_repeat('s', 13);
    }
}

// ----------------------------
// Counts
// ----------------------------
$totalRecords = $con->query("SELECT COUNT(*) as total FROM tbl_inquiry_student as pro WHERE is_delete=0 AND is_active=1 $isOnline $urlForQue")->fetch_assoc()['total'];

if (!empty($searchValue) || !empty($assigned_date)) {
    $stmtCount = $con->prepare("SELECT COUNT(*) as total $fromSql $joinSql $whereSql");
} else {
    $stmtCount = $con->prepare("SELECT COUNT(*) as total $fromSql $whereSql");
}
if (!empty($params)) {
    $stmtCount->bind_param($types, ...$params);
}
$stmtCount->execute();
$totalFiltered = $stmtCount->get_result()->fetch_assoc()['total'];

// ----------------------------
// Sorting and Pagination
// ----------------------------
$orderSql = " ORDER BY pro.id DESC";
if (!empty($_POST['order'][0]['column'])) {
    $colIndex = intval($_POST['order'][0]['column']);
    $dir = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
    if (isset($columnMap[$colIndex])) {
        $orderSql = " ORDER BY {$columnMap[$colIndex]} $dir";
    }
}

$limitSql = " LIMIT ?, ?";
$params[] = $start;
$params[] = $length;
$types .= "ii";

// ----------------------------
// Final Data Query
// ----------------------------
$sql = "SELECT 
        pro.id, pro.inq_student_id, pro.first_name, pro.middle_name, pro.last_name,
        CONCAT_WS(' ', pro.first_name, pro.middle_name, pro.last_name) AS full_name,
        pro.gender, pro.mobile_number, pro.mobile_number2, pro.email,
        pro.last_exam, pro.last_exam_status as exam_status, pro.last_exam_marks as last_exam_mark,
        pro.is_admission_confirm, pro.is_admission_confirm as admission_status, 
        pro.is_online, pro.call_count as max_call_count, pro.is_closed, pro.closed_by,
        pro.faculty_id, pro.level_id, pro.program_id, pro.staff_id,
        pro.specify_degree,
        faculty.shortname as faculty_name,
        level.short_name as level_name,
        program.name as program_name,
        staff.name as staff_name,
        staff2.name as confirm_by_name,
        staff3.name as assign_by_name,
        (SELECT COUNT(*) FROM tbl_inquiry_call_logs WHERE inq_student_id = pro.inq_student_id AND is_active = 1 AND is_delete = 0) AS call_count,
        (SELECT remark FROM tbl_inquiry_logs WHERE inq_student_id = pro.inq_student_id ORDER BY id DESC LIMIT 1) AS log_remark
        $fromSql $joinSql $whereSql $orderSql $limitSql";

$stmt = $con->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$data = [];
$sr_no = $start + 1;
$isRoleGroup = in_array($role_id, [12, 15, 16]);
$isNotSpecialUrl = !in_array($url_for, ['rejectedinq', 'approvedinq', 'closedinq']);
$isNotApprRejUrl = !in_array($url_for, ['rejectedinq', 'approvedinq']);
$showBaseCallBtn = ($isRoleGroup && $isNotSpecialUrl);
$showEditBtn = ($role_id != 15);
$showCallStatusBtn = ($isNotApprRejUrl && in_array($role_id, [15, 16]));
$isLeadmanInqBtn = ($role_id == 57 && $url_for == 'inq');

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $inq_id = $row['inq_student_id'];
    $callBtn = "";
    $admissionBtn = "";

    if (($row['call_count'] < $row['max_call_count'] && $showBaseCallBtn) || $role_id == 57) {
        $callBtn .= '<a href="candidate-details.php?id=' . $id . '" class="btn btn-sm btn-primary" title="View Details"><i class="fa-solid fa-eye"></i></a> ';
        if ($showEditBtn) {
            $callBtn .= '<a href="candidate-edit.php?id=' . $id . '" class="btn btn-sm btn-secondary" title="Edit Details"><i class="fa-solid fa-pen-to-square"></i></a> ';
        }
        if ($showCallStatusBtn) {
            $callBtn .= '<a href="#" class="btn btn-sm btn-info" title="Add New Call Status" onclick="openCallStatusModal(' . $id . ', \'' . $inq_id . '\')"><i class="fa-solid fa-phone"></i></a> ';
        }
    }

    if ($isLeadmanInqBtn) {
        $callBtn .= '<a href="#" class="btn btn-sm btn-warning" title="Increase Max Call" onclick="openCallIncreaseModal(' . $id . ', \'' . $inq_id . '\')"><i class="fa-solid fa-phone"></i><i class="fa-solid fa-plus"></i></a> ';
        $admissionBtn .= '<a href="#" class="btn btn-sm btn-success" onclick="admissionStatusUpdate(' . $id . ', \'' . $inq_id . '\', 1)"><i class="fa-solid fa-check"></i></a> <a href="#" class="btn btn-sm btn-danger" onclick="admissionStatusUpdate(' . $id . ', \'' . $inq_id . '\', 0)"><i class="fa-solid fa-xmark"></i></a>';
    }

    $row['sr_no'] = $sr_no++;
    $row['last_exam'] = $lastExamOptions[$row['last_exam']] ?? 'N/A';
    $row['is_online'] = $isOnlineOptions[$row['is_online']] ?? 'N/A';
    $row['admission_status'] = ($row['is_admission_confirm'] == 1) ? 'Confirmed' : 'Pending';
    $row['action'] = '<div class="dropdown">' . $callBtn . '</div>';
    $row['admissionBtn'] = $admissionBtn;
    $row['followupRemarkBtn'] = '<a href="#" class="btn btn-sm btn-primary" onclick="followupRemarkModal(' . $id . ', \'' . $inq_id . '\')"><i class="fa-solid fa-arrows-to-eye"></i></a>';
    $row['unCloseInq'] = '<a href="#" class="btn btn-sm btn-success" onclick="unCloseInqModal(' . $id . ', \'' . $inq_id . '\')"><i class="fa-solid fa-unlock"></i></a>';
    $row['openInq'] = '<a href="#" class="btn btn-sm btn-success" onclick="openInqModal(' . $id . ', \'' . $inq_id . '\')"><i class="fa-solid fa-lock-open"></i></a>';
    $data[] = $row;
}

echo json_encode(["draw" => $draw, "recordsTotal" => intval($totalRecords), "recordsFiltered" => intval($totalFiltered), "data" => $data]);
?>