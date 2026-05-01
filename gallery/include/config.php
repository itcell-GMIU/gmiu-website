<?php
session_start();

// include '../common/globalvariable.php';
include 'include/connect.php';
// include '../common/function.php';
// include '../common/validation.php';

// ✅ If not logged in → redirect
if (!isset($_SESSION['staff_id']) || strlen($_SESSION['staff_id']) == 0) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
} else {
    $staff_id = $_SESSION['staff_id'];

    $cmd = "SELECT 
                staff.id AS role_id, 
                staff.name AS role_name, 
                staff.name AS name, 
                staff.email AS user_email 
            FROM gallery_admin AS staff
            WHERE staff.id = ?";

    $stmt = $con->prepare($cmd);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // ✅ Safely extract values
    $user_email = isset($row['user_email']) ? $row['user_email'] : '';
    $name = isset($row['name']) ? $row['name'] : '';
    $role_id = isset($row['role_id']) ? $row['role_id'] : '';
    $role_name = isset($row['role_name']) ? $row['role_name'] : '';

    // ✅ Check if any critical values are missing
    if (empty($user_email) || empty($name) || empty($role_id) || empty($role_name)) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
?>