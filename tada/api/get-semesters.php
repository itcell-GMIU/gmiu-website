<?php
include '../include/config.php';

$program_id = isset($_GET['program_id']) ? (int)$_GET['program_id'] : 0;

if ($program_id > 0) {
    $sql = "SELECT DISTINCT sem FROM tbl_std_corner_exam WHERE program_id = ? AND is_active = 1 AND sem IS NOT NULL ORDER BY sem ASC";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $program_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $semesters = [];
    while ($row = $result->fetch_assoc()) {
        $semesters[] = $row;
    }
    
    echo json_encode(['status' => 'success', 'data' => $semesters]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
}
?>
