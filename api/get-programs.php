<?php
include '../include/config.php';

$faculty_id = isset($_GET['faculty_id']) ? (int)$_GET['faculty_id'] : 0;
$level_id = isset($_GET['level_id']) ? (int)$_GET['level_id'] : 0;

if ($faculty_id > 0 && $level_id > 0) {
    $sql = "SELECT id, name FROM tbl_program WHERE faculty_id = ? AND level_id = ? AND is_active = 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $faculty_id, $level_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $programs = [];
    while ($row = $result->fetch_assoc()) {
        $programs[] = $row;
    }
    
    echo json_encode(['status' => 'success', 'data' => $programs]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
}
?>
