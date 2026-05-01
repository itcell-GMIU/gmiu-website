<?php
include '../include/checklogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $stmt = $con->prepare("UPDATE tbl_weightage SET is_active = 0, is_delete = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo json_encode(['success' => $stmt->affected_rows > 0]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>