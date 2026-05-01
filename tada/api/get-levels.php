<?php
include '../include/config.php';

$faculty_id = isset($_GET['faculty_id']) ? (int)$_GET['faculty_id'] : 0;

if ($faculty_id > 0) {
    $sql = "SELECT DISTINCT l.id, l.name 
            FROM tbl_level l 
            JOIN tbl_program p ON l.id = p.level_id 
            WHERE p.faculty_id = ? AND l.is_active = 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $faculty_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $levels = [];
    while ($row = $result->fetch_assoc()) {
        $levels[] = $row;
    }
    
    echo json_encode(['status' => 'success', 'data' => $levels]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid faculty ID']);
}
?>
