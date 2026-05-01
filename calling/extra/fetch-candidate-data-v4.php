<?php
session_start();

include '../../common/globalvariable.php';
include '../../database/connect.php';
// include '../include/config.php';
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
    18 => 'mobile_number',
    19 => 'mobile_number2',
    20 => 'email'
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
    10 => 'Diploma Pharmacy',
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
LEFT JOIN tbl_staff staff2 ON pro.confirm_by = staff2.id
LEFT JOIN tbl_staff staff3 ON pro.assign_by = staff3.id
LEFT JOIN tbl_inquiry_logs til ON pro.inq_student_id = til.inq_student_id
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
    if ($role_id == 57 || $role_id == 11 || $role_id == 60) {
        // // if the leadman can see only confidential inquiries
        // $baseSql .= " AND pro.is_online = 6";
        // $isOnline .= " AND is_online = 6";
    } elseif ($role_id == 12) {
        $baseSql .= " AND pro.is_online != 6";
        $isOnline .= " AND is_online != 6";
    } elseif ($role_id == 13) {
        $baseSql .= " AND pro.is_online = 4";
        $isOnline .= " AND is_online = 4";
    }
}

// URL for filter
$urlForQue = "";
if (!empty($url_for)) {
    if ($url_for == 'inq') {
        if ($role_id == 14) {
            $baseSql .= " AND pro.staff_id IS NOT NULL AND pro.staff_id IN ( " . $_SESSION['u_staff_id'] . ") AND is_admission_confirm = 0 AND is_closed = 0";
            $urlForQue .= " AND pro.staff_id IS NOT NULL AND pro.staff_id IN ( " . $_SESSION['u_staff_id'] . ") AND is_admission_confirm = 0 AND is_closed = 0";
        } else {
            $baseSql .= " AND pro.staff_id IS NOT NULL AND pro.staff_id != '' AND is_admission_confirm = 0 AND is_closed = 0";
            $urlForQue .= " AND pro.staff_id IS NOT NULL AND pro.staff_id != '' AND is_admission_confirm = 0 AND is_closed = 0";
        }
    } elseif ($url_for == 'myinq') {
        $baseSql .= " AND pro.staff_id = " . $_SESSION['staff_id'] . " AND is_admission_confirm = 0 AND is_closed = 0";
        $urlForQue .= " AND pro.staff_id = " . $_SESSION['staff_id'] . " AND is_admission_confirm = 0 AND is_closed = 0";
    } elseif ($url_for == 'approvedinq') {
        if ($role_id == 15 || $role_id == 16) {
            $baseSql .= " AND pro.confirm_by = " . $_SESSION['staff_id'] . " AND is_admission_confirm = 1";
            $urlForQue .= " AND pro.confirm_by = " . $_SESSION['staff_id'] . " AND is_admission_confirm = 1";
        } elseif ($role_id == 57 || $role_id == 11 || $role_id == 60) {
            // // if the leadman can see only confidential admissions
            $baseSql .= " AND is_admission_confirm = 1";
            $urlForQue .= " AND is_admission_confirm = 1";

            // // if the leadman can see all confirmed admissions including confidential
            // $baseSql .= " AND is_admission_confirm = 1 AND pro.is_online = 6";
            // $urlForQue .= " AND is_admission_confirm = 1 AND is_online = 6";
        } elseif ($role_id == 12) {
            $baseSql .= " AND is_admission_confirm = 1";
            $urlForQue .= " AND is_admission_confirm = 1";
        } elseif ($role_id == 14) {
            $baseSql .= " AND is_admission_confirm = 1 AND pro.confirm_by IN ( " . $_SESSION['u_staff_id'] . ")";
            $urlForQue .= " AND is_admission_confirm = 1 AND pro.confirm_by IN ( " . $_SESSION['u_staff_id'] . ")";
        }
    } elseif ($url_for == 'rejectedinq') {
        if ($role_id == 15 || $role_id == 16) {
            $baseSql .= " AND pro.staff_id = " . $_SESSION['staff_id'] . " AND is_admission_confirm = -1 AND is_closed = 0";
            $urlForQue .= " AND pro.staff_id = " . $_SESSION['staff_id'] . " AND is_admission_confirm = -1 AND is_closed = 0";
        } elseif ($role_id == 57 || $role_id == 11 || $role_id == 60) {
            // // if the leadman can see only confidential rejections
            $baseSql .= " AND is_admission_confirm = -1 AND is_closed = 0";
            $urlForQue .= " AND is_admission_confirm = -1 AND is_closed = 0";

            // // if the leadman can see all rejected admissions including confidential
            // $baseSql .= " AND is_admission_confirm = -1 AND pro.is_online = 6";
            // $urlForQue .= " AND is_admission_confirm = -1 AND is_online = 6";
        } elseif ($role_id == 12) {
            $baseSql .= " AND is_admission_confirm = -1 AND is_closed = 0";
            $urlForQue .= " AND is_admission_confirm = -1 AND is_closed = 0";
        } elseif ($role_id == 14) {
            $baseSql .= " AND is_admission_confirm = -1 AND is_closed = 0 AND pro.staff_id IN ( " . $_SESSION['u_staff_id'] . ")";
            $urlForQue .= " AND is_admission_confirm = -1 AND is_closed = 0 AND pro.staff_id IN ( " . $_SESSION['u_staff_id'] . ")";
        }
    } elseif ($url_for == 'closedinq') {
        if ($role_id == 15 || $role_id == 16) {
            $baseSql .= " AND pro.staff_id = " . $_SESSION['staff_id'] . " AND pro.closed_by = " . $_SESSION['staff_id'] . " AND is_closed = 1";
            $urlForQue .= " AND pro.staff_id = " . $_SESSION['staff_id'] . " AND pro.closed_by = " . $_SESSION['staff_id'] . " AND is_closed = 1";
        } elseif ($role_id == 57 || $role_id == 11 || $role_id == 60) {
            // // if the leadman can see only confidential closed inquiries
            $baseSql .= " AND is_closed = 1";
            $urlForQue .= " AND is_closed = 1";

            // // if the leadman can see all closed inquiries including confidential
            // $baseSql .= " AND pro.is_online = 6 AND is_closed = 1";
            // $urlForQue .= " AND is_online = 6 AND is_closed = 1";
        } elseif ($role_id == 12) {
            $baseSql .= " AND is_closed = 1";
            $urlForQue .= " AND is_closed = 1";
        } elseif ($role_id == 14) {
            $baseSql .= " AND is_closed = 1 AND pro.staff_id IN ( " . $_SESSION['u_staff_id'] . ") AND pro.closed_by IN ( " . $_SESSION['u_staff_id'] . ")";
            $urlForQue .= " AND is_closed = 1 AND pro.staff_id IN ( " . $_SESSION['u_staff_id'] . ") AND pro.closed_by IN ( " . $_SESSION['u_staff_id'] . ")";
        }
    } elseif ($url_for == 'approvedbyother') {
        if ($role_id == 15 || $role_id == 16) {
            $baseSql .= " AND pro.staff_id = " . $_SESSION['staff_id'] . " AND pro.confirm_by != " . $_SESSION['staff_id'] . " AND is_admission_confirm = 1";
            $urlForQue .= " AND pro.staff_id = " . $_SESSION['staff_id'] . " AND pro.confirm_by != " . $_SESSION['staff_id'] . " AND is_admission_confirm = 1";
        } elseif ($role_id == 57) {
            // // if the leadman can see only confidential closed inquiries
            // $baseSql .= " AND is_closed = 1";
            // $urlForQue .= " AND is_closed = 1";

            // // if the leadman can see all closed inquiries including confidential
            // $baseSql .= " AND pro.is_online = 6 AND is_closed = 1";
            // $urlForQue .= " AND is_online = 6 AND is_closed = 1";
        } elseif ($role_id == 12) {
            // $baseSql .= " AND is_closed = 1";
            // $urlForQue .= " AND is_closed = 1";
        } elseif ($role_id == 14) {
            // $baseSql .= " AND is_closed = 1 AND pro.staff_id IN ( " . $_SESSION['u_staff_id'] . ") AND pro.closed_by IN ( " . $_SESSION['u_staff_id'] . ")";
            // $urlForQue .= " AND is_closed = 1 AND pro.staff_id IN ( " . $_SESSION['u_staff_id'] . ") AND pro.closed_by IN ( " . $_SESSION['u_staff_id'] . ")";
        }
    }
} else {
    $baseSql .= "  AND is_admission_confirm = 0 AND is_closed = 0";
    $urlForQue .= " AND is_admission_confirm = 0 AND is_closed = 0";
}

// Global search
// if (!empty($searchValue)) {
//     $baseSql .= " AND (
//         pro.first_name LIKE ? OR pro.middle_name LIKE ? OR pro.last_name LIKE ? OR
//         pro.inq_student_id LIKE ? OR
//         staff.name LIKE ? OR staff2.name LIKE ? OR
//         faculty.name LIKE ? OR level.name LIKE ? OR program.name LIKE ? OR
//         pro.gender LIKE ? OR pro.mobile_number LIKE ? OR pro.email LIKE ?
//     )";
//     $like = "%$searchValue%";
//     $params = array_merge($params, array_fill(0, 12, $like));
//     $types .= str_repeat("s", 12);
// }

if (!empty($searchValue)) {

    // Normalize spaces
    $searchValue = trim($searchValue);
    $searchValue = preg_replace('/\s+/', ' ', $searchValue);

    $tempSearch = $searchValue;

    // First, check if any of the "Last Exam" names are present in the search string
    // Sort options by length DESC to match longer names first (e.g. '12th Arts' before '12th')
    $examOptionsCopy = $lastExamOptions;
    uasort($examOptionsCopy, function ($a, $b) {
        return strlen($b) - strlen($a);
    });

    foreach ($examOptionsCopy as $id => $name) {
        $nameLower = strtolower(trim($name));
        // Use lookarounds instead of \b to correctly handle names ending with non-word characters like ')'
        $pattern = '/(?<!\w)' . preg_quote($nameLower, '/') . '(?!\w)/i';
        if (preg_match($pattern, $tempSearch)) {
            // Found a match for an exam name!
            $baseSql .= " AND pro.last_exam = ?";
            $params[] = $id;
            $types .= "i";
            // Remove the matched name from the search string so it's not searched broadly
            $tempSearch = preg_replace($pattern, '', $tempSearch);
        }
    }

    // Split into words: "akshar rathod" => ["akshar", "rathod"]
    $keywords = explode(' ', trim(preg_replace('/\s+/', ' ', $tempSearch)));

    foreach ($keywords as $word) {
        $word = trim($word);
        if ($word === '') {
            continue;
        }

        // Case-insensitive word for general fields
        $like = '%' . strtolower($word) . '%';

        // For mobile: strip non-digits
        $numeric = preg_replace('/\D/', '', $word);
        $mobileLike = $numeric !== '' ? '%' . $numeric . '%' : $like;

        // Custom logic for email: if word contains '@', we only search the email field to avoid noise
        if (strpos($word, '@') !== false) {
            // Check if it looks like a full email (has a dot after the @)
            $isFullEmail = (strpos($word, '.', strpos($word, '@')) !== false);
            if ($isFullEmail) {
                // Exact match for full email
                $baseSql .= " AND LOWER(TRIM(pro.email)) = ?";
                $params[] = strtolower($word);
                $types .= "s";
            } else {
                // Partial match only on email field
                $baseSql .= " AND LOWER(pro.email) LIKE ?";
                $params[] = $like;
                $types .= "s";
            }
            continue; // Skip the broad multi-field search for this word
        }

        // For EACH word we add an AND (...) block
        $baseSql .= " AND (
            LOWER(pro.first_name)     LIKE ? OR 
            LOWER(pro.middle_name)    LIKE ? OR 
            LOWER(pro.last_name)      LIKE ? OR
            LOWER(pro.inq_student_id) LIKE ? OR
            LOWER(staff.name)         LIKE ? OR 
            LOWER(staff2.name)        LIKE ? OR
            LOWER(staff3.name)        LIKE ? OR
            LOWER(faculty.name)       LIKE ? OR 
            LOWER(level.name)         LIKE ? OR 
            LOWER(program.name)       LIKE ? OR
            LOWER(pro.gender)         LIKE ? OR
            pro.mobile_number         LIKE ? OR
            LOWER(pro.email)          LIKE ?
        )";

        // 13 placeholders → push 13 params in same order
        $params[] = $like; // first_name
        $params[] = $like; // middle_name
        $params[] = $like; // last_name
        $params[] = $like; // inq_student_id
        $params[] = $like; // staff.name
        $params[] = $like; // staff2.name
        $params[] = $like; // staff3.name (Assigned By)
        $params[] = $like; // faculty.name
        $params[] = $like; // level.name
        $params[] = $like; // program.name
        $params[] = $like; // gender
        $params[] = $mobileLike; // mobile_number (numeric-friendly)
        $params[] = $like; // email

        // 13 "s" types (one per ?)
        $types .= str_repeat('s', 13);
    }
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

// the old one 
// $baseSql .= " ORDER BY pro.id DESC LIMIT ?, ?";

$orderSql = " ORDER BY pro.id DESC"; // default

if (!empty($_POST['order'][0]['column'])) {
    $colIndex = intval($_POST['order'][0]['column']);
    $dir = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';

    if (isset($columnMap[$colIndex])) {
        $orderSql = " ORDER BY {$columnMap[$colIndex]} $dir";
    }
}

$baseSql .= $orderSql . " LIMIT ?, ?";

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
        pro.is_admission_confirm as admission_status ,
        pro.id as id,pro.staff_id as staff_id ,
        staff.name as staff_name,
        staff2.name as confirm_by_name,
        staff3.name as assign_by_name,
        pro.inq_student_id as inq_student_id,
        pro.first_name as first_name ,
        pro.middle_name as middle_name,
        pro.last_name as last_name,
        CONCAT_WS(' ', pro.first_name, pro.middle_name, pro.last_name) AS full_name,
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
        pro.call_count as max_call_count,
        pro.is_closed as is_closed,
        pro.closed_by as closed_by,
        (
            SELECT COUNT(*) 
            FROM tbl_inquiry_call_logs AS cl 
            WHERE cl.inq_student_id = pro.inq_student_id
              AND cl.is_active = 1
              AND cl.is_delete = 0
        ) AS call_count,

        pro.specify_degree as specify_degree,
        -- faculty.name as faculty_name,
        faculty.shortname as faculty_name,
        -- level.name as level_name,
        level.short_name as level_name,
        program.name as program_name,
        til.remark as log_remark
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

    // Show CALL button only if call_count < 3 AND role_id = 13
    $callBtn = "";
    $admissionBtn = "";
    // You can pass parameters to action buttons using query strings
    $viewUrl = "candidate-details.php?id=" . urlencode($row['id']);
    $editUrl = "candidate-edit.php?id=" . urlencode($row['id']);

    if (($row['call_count'] < $row['max_call_count'] && ($role_id == 16 || $role_id == 12 || $role_id == 15) && ($url_for != 'rejectedinq' && $url_for != 'approvedinq' && $url_for != 'closedinq')) || $role_id == 57) {
        $callBtn .= '<a href="' . $viewUrl . '" class="btn btn-sm btn-primary" title="View Details">
                <i class="fa-solid fa-eye"></i></a> ';
        if ($role_id != 15) {
            $callBtn .= '<a href="' . $editUrl . '" class="btn btn-sm btn-secondary" title="Edit Details">
                <i class="fa-solid fa-pen-to-square"></i></a> ';
        }
        if (($url_for != 'rejectedinq' && $url_for != 'approvedinq') && ($role_id == 15 || $role_id == 16)) {
            $callBtn .= '<a href="#" class="btn btn-sm btn-info" title="Add New Call Status"
                onclick="openCallStatusModal(' . $row['id'] . ', \'' . $row['inq_student_id'] . '\')">
                <i class="fa-solid fa-phone"></i></a> ';
        }
    }
    if ($role_id == 57 && $url_for == 'inq') {
        $callBtn .= '<a href="#" class="btn btn-sm btn-warning" title="Increase Number of Max Call"
                    onclick="openCallIncreaseModal(' . $row['id'] . ', \'' . $row['inq_student_id'] . '\')">
                    <i class="fa-solid fa-phone"></i><i class="fa-solid fa-plus"></i></a> ';
        $admissionBtn .= '<a href="#" class="btn btn-sm btn-success" title="Confirm Admission"
    onclick="admissionStatusUpdate(' . $row['id'] . ', \'' . $row['inq_student_id'] . '\', 1)">
    <i class="fa-solid fa-check"></i></a>
    <a href="#" class="btn btn-sm btn-danger" title="Reject Admission"
    onclick="admissionStatusUpdate(' . $row['id'] . ', \'' . $row['inq_student_id'] . '\', 0)">
    <i class="fa-solid fa-xmark"></i></a>';
    }

    $row['sr_no'] = $sr_no++;
    $row['last_exam'] = isset($lastExamOptions[$row['last_exam']]) ? $lastExamOptions[$row['last_exam']] : 'N/A';
    $row['is_online'] = isset($isOnlineOptions[$row['is_online']]) ? $isOnlineOptions[$row['is_online']] : 'N/A';
    $row['admission_status'] = ($row['is_admission_confirm'] == 1) ? 'Confirmed' : 'Pending';
    $row['action'] = '<div class="dropdown">' . $callBtn . '</div>';

    $row['admissionBtn'] = $admissionBtn;
    $row['followupRemarkBtn'] = '<a href="#" class="btn btn-sm btn-primary" title="Confirm Admission"
    onclick="followupRemarkModal(' . $row['id'] . ', \'' . $row['inq_student_id'] . '\')">
    <i class="fa-solid fa-arrows-to-eye"></i></a>';

    $row['unCloseInq'] = '<a href="#" class="btn btn-sm btn-success" title="Unclose Inquiry"
    onclick="unCloseInqModal(' . $row['id'] . ', \'' . $row['inq_student_id'] . '\')">
    <i class="fa-solid fa-unlock"></i></a>';

    $row['openInq'] = '<a href="#" class="btn btn-sm btn-success" title="Open Inquiry"
    onclick="openInqModal(' . $row['id'] . ', \'' . $row['inq_student_id'] . '\')">
    <i class="fa-solid fa-lock-open"></i></a>';

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
