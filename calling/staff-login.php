<?php
session_start();

include '../database/connect.php';

if (!$_SESSION['staff_id'] == 60) {
    $_SESSION['status'] = "Unauthorized Access. ";
    $_SESSION['status_code'] = "error";
    header("Location: staff-view.php");
    exit;
}

/* ------------------------------------
   1. Validate GET parameter
------------------------------------ */
if (!isset($_GET['staff_id']) || empty($_GET['staff_id'])) {
    header("Location: staff-view.php");

    exit;
}

$staff_id = (int) $_GET['staff_id']; // force integer

/* ------------------------------------
   2. Fetch staff + role data
------------------------------------ */
$query = "SELECT 
            staff.id AS staff_id,
            staff.name AS name,
            staff.email AS user_email,
            staff.faculty_id AS faculty_id,
            staff.level_id AS level_id,
            staff.program_id AS program_id,
            staff.under_staff_id AS u_staff_id,
            role.id AS role_id,
            role.name AS role_name
          FROM tbl_staff AS staff
          LEFT JOIN tbl_role AS role ON staff.role_id = role.id
          WHERE staff.id = ?
          LIMIT 1";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();

/* ------------------------------------
   3. Invalid staff → back to staff-view
------------------------------------ */
if ($result->num_rows === 0) {
    $_SESSION['status'] = "Invalid Staff Id.";
    $_SESSION['status_code'] = "error";
    header("Location: staff-view.php");
    exit;
}

$row = $result->fetch_assoc();

/* ------------------------------------
   4. Validate critical fields
------------------------------------ */
if (
    empty($row['staff_id']) ||
    empty($row['name']) ||
    empty($row['user_email']) ||
    empty($row['role_id']) ||
    empty($row['role_name'])
) {
    session_unset();
    session_destroy();
    header("Location: staff-view.php");
    exit;
}

/* ------------------------------------
   5. Destroy old session & regenerate
------------------------------------ */
session_unset();
session_regenerate_id(true);

/* ------------------------------------
   6. Generate ALL required sessions
------------------------------------ */
$_SESSION['staff_id'] = $row['staff_id'];
$_SESSION['name'] = $row['name'];
$_SESSION['user_email'] = $row['user_email'];
$_SESSION['role_id'] = $row['role_id'];
$_SESSION['role_name'] = $row['role_name'];
$_SESSION['faculty_id'] =
    (isset($row['faculty_id']) && $row['faculty_id'] !== '' && $row['faculty_id'] != 0)
    ? (string) $row['faculty_id']
    : 'NA';

$_SESSION['level_id'] =
    (isset($row['level_id']) && $row['level_id'] !== '' && $row['level_id'] != 0)
    ? (string) $row['level_id']
    : 'NA';

$_SESSION['program_id'] =
    (isset($row['program_id']) && $row['program_id'] !== '' && $row['program_id'] != 0)
    ? (string) $row['program_id']
    : 'NA';
$_SESSION['u_staff_id'] = isset($row['u_staff_id']) && $row['u_staff_id'] !== ''
    ? (string) $row['u_staff_id']
    : 'NA';

/* ------------------------------------
   7. Redirect to dashboard
------------------------------------ */
header("Location: index.php");
exit;
