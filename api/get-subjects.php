<?php
include '../include/config.php';

$program_id = isset($_GET['program_id']) ? (int)$_GET['program_id'] : 0;
$sem = isset($_GET['sem']) ? (int)$_GET['sem'] : 0;

if ($program_id > 0) {
    // Fetch unique subject codes and names
    if ($sem > 0) {
        $sql = "SELECT DISTINCT subject_code, subject_name FROM tbl_std_corner_exam WHERE program_id = ? AND sem = ? AND is_active = 1 ORDER BY subject_code ASC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $program_id, $sem);
    } else {
        $sql = "SELECT DISTINCT subject_code, subject_name FROM tbl_std_corner_exam WHERE program_id = ? AND is_active = 1 ORDER BY subject_code ASC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $program_id);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    
    $subjects = [];
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
    
    echo json_encode(['status' => 'success', 'data' => $subjects]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
}
?>
