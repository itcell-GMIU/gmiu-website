<?php
session_start();
include './include/db.php';
/* ------------------------------------
   Required sessions
------------------------------------ */
$requiredSessions = [
    'staff_id',
    'name',
    'user_email',
    'role_id',
    'role_name',
];

foreach ($requiredSessions as $key) {
    if (empty($_SESSION[$key])) {
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
?>