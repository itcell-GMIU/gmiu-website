<?php
include 'include/checklogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pac_id'])) {
    $pac_id = $_POST['pac_id'];

    // Duplicate check
    if (!isset($_POST['get_token_amount'])) {
        // This block runs when you're just checking for duplicates
        $stmt = $con->prepare("SELECT id FROM tbl_branch_transfer_requests WHERE student_id = ? AND is_active = 1 AND is_delete = 0");
        $stmt->bind_param("i", $pac_id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo ($result->num_rows > 0) ? '1' : '0';
        exit;
    }
}
