<?php
session_start();

date_default_timezone_set('Asia/Kolkata');
$currentTime = new DateTime();
$startTime = new DateTime('07:00:00');
$endTime = new DateTime('18:00:00');
if ($currentTime < $startTime || $currentTime >= $endTime) {
    session_destroy();
    header("Location: login.php");
    exit;
}

include '../database/connect.php';

// if (!isset($_SESSION['staff_id']) || strlen($_SESSION['staff_id']) == 0) {
//     session_unset();
//     session_destroy();
//     header("Location: login.php");
//     exit();
// } else {
//     $staff_id = $_SESSION['staff_id'];

//     $cmd = "SELECT 
//                 role.id AS role_id, 
//                 role.name AS role_name, 
//                 staff.name AS name, 
//                 staff.email AS user_email, 
//                 staff.faculty_id AS faculty_id, 
//                 staff.level_id AS level_id, 
//                 staff.program_id AS program_id, 
//                 staff.under_staff_id AS u_staff_id
//             FROM tbl_staff AS staff
//             LEFT JOIN tbl_role AS role ON staff.role_id = role.id
//             WHERE staff.id = ?";

//     $stmt = $con->prepare($cmd);
//     $stmt->bind_param("i", $staff_id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $row = $result->fetch_assoc();

//     $user_email = isset($row['user_email']) ? $row['user_email'] : '';
//     $name = isset($row['name']) ? $row['name'] : '';
//     $role_id = isset($row['role_id']) ? $row['role_id'] : '';
//     $role_name = isset($row['role_name']) ? $row['role_name'] : '';
//     $faculty_id = isset($row['faculty_id']) ? $row['faculty_id'] : '';
//     $level_id = isset($row['level_id']) ? $row['level_id'] : '';
//     $program_id = isset($row['program_id']) ? $row['program_id'] : '';
//     $u_staff_id_value = isset($row['u_staff_id']) ? $row['u_staff_id'] : '';
//     $_SESSION['u_staff_id'] = $u_staff_id_value;
//     echo $_SESSION['u_staff_id'];
//     if (empty($user_email) || empty($name) || empty($role_id) || empty($role_name)) {
//         session_unset();
//         session_destroy();
//         header("Location: login.php");
//         exit();
//     }
// }


/* ------------------------------------
   Required sessions
------------------------------------ */
$requiredSessions = [
    'staff_id',
    'name',
    'user_email',
    'role_id',
    'role_name'
];

foreach ($requiredSessions as $key) {
    if (empty($_SESSION[$key])) {
        // echo "<script>console.log('" .$requiredSessions[$key] ." - ". $_SESSION[$key]."')</script>";
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit;
    }
}

$staff_id = $_SESSION['staff_id'];
$user_email = $_SESSION['user_email'];
$name = $_SESSION['name'];
$role_id = $_SESSION['role_id'];
$role_name = $_SESSION['role_name'];
$faculty_id = $_SESSION['faculty_id'];
$level_id = $_SESSION['level_id'];
$program_id = $_SESSION['program_id'];
$u_staff_id = $_SESSION['u_staff_id'];
?>