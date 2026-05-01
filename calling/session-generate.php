<?php
session_start();

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

include '../database/connect.php';

/* ------------------------------------
   0. Required sessions
------------------------------------ */
$requiredSessions = [
    'staff_id',
    'name',
    'user_email',
    'role_id',
    'role_name',
    'faculty_id',
    'level_id',
    'program_id',
    'u_staff_id'
];

/* ------------------------------------
   1. If ALL sessions already exist → index
------------------------------------ */
$allExist = true;
foreach ($requiredSessions as $key) {
    if (empty($_SESSION[$key])) {
        $allExist = false;
        break;
    }
}

if ($allExist) {
    header("Location: index.php");
    exit;
}

/* ------------------------------------
   2. staff_id MUST exist (set earlier)
------------------------------------ */
if (empty($_SESSION['staff_id'])) {
    // Staff id session missing = invalid flow
    // echo "<script>console.log('staff id is empty')</script>";
    header("Location: staff-view.php");
    exit;
}

$staff_id = (int) $_SESSION['staff_id'];

/* ------------------------------------
   3. Fetch remaining staff data
------------------------------------ */
$sql = "SELECT 
            staff.id AS staff_id,
            staff.name,
            staff.email,
            staff.faculty_id,
            staff.level_id,
            staff.program_id,
            staff.under_staff_id,
            role.id AS role_id,
            role.name AS role_name
        FROM tbl_staff AS staff
        LEFT JOIN tbl_role AS role ON staff.role_id = role.id
        WHERE staff.id = ?
        LIMIT 1";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Invalid staff session
    // echo "<script>console.log('No Data Found')</script>";
    session_unset();
    session_destroy();
    header("Location: staff-view.php");
    exit;
}

$row = $result->fetch_assoc();

/* ------------------------------------
   4. Validate critical fields
------------------------------------ */
if (
    empty($row['name']) ||
    empty($row['email']) ||
    empty($row['role_id']) ||
    empty($row['role_name'])
) {
    // echo "<script>console.log('Miising Criticle Field')</script>";
    session_unset();
    session_destroy();
    header("Location: staff-view.php");
    exit;
}

/* ------------------------------------
   5. Generate remaining sessions
------------------------------------ */
session_regenerate_id(true); // keep staff_id, secure

$_SESSION['name'] = $row['staff_id'];
$_SESSION['name'] = $row['name'];
$_SESSION['user_email'] = $row['email'];
$_SESSION['role_id'] = $row['role_id'];
$_SESSION['role_name'] = $row['role_name'];
$_SESSION['faculty_id'] = isset($row['faculty_id']) && $row['faculty_id'] !== ''
    ? (string) $row['faculty_id']
    : 'NA';
$_SESSION['level_id'] = isset($row['level_id']) && $row['level_id'] !== ''
    ? (string) $row['level_id']
    : 'NA';
$_SESSION['program_id'] = isset($row['program_id']) && $row['program_id'] !== ''
    ? (string) $row['program_id']
    : 'NA';
    
// $u_staff_id_value = isset($row['under_staff_id']) ? trim($row['under_staff_id']) : '';
// $_SESSION['u_staff_id'] = ($u_staff_id_value !== '' && strtolower($u_staff_id_value) !== 'na')
//     ? $u_staff_id_value
    // : 'NA';
$u_staff_id_value = isset($row['under_staff_id']) ? $row['under_staff_id'] : '';
$_SESSION['u_staff_id'] = $u_staff_id_value;
// $_SESSION['u_staff_id'] = isset($row['under_staff_id']) && $row['under_staff_id'] !== ''
//     ? (string) $row['under_staff_id']
//     : 'NA';


/* ------------------------------------
   6. Redirect
------------------------------------ */
// echo "<script>console.log('all parameter are safe')</script>";
header("Location: index.php");
exit;
