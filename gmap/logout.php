<?php
session_start();

/* ================= DETERMINE REDIRECT BEFORE DESTROY ================= */

$redirectPage = 'login.php'; // default student login

if (isset($_SESSION['role_id'])) {
    $redirectPage = 'admin-login.php';
}

/* ================= DESTROY SESSION ================= */

$_SESSION = [];
session_destroy();

/* ================= START NEW SESSION FOR ALERT ================= */

session_start();

$_SESSION['alert'] = [
    'type' => 'success',
    'title' => 'Logged Out',
    'text' => 'You have been logged out successfully.',
    'redirect' => $redirectPage
];

header("Location: $redirectPage");
exit;
?>