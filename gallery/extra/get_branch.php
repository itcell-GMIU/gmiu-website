<?php
session_start();

include '../../common/globalvariable.php';
include '../../database/connect.php';
include '../../common/function.php';
include '../../common/validation.php';

header('Content-Type: application/json');

if (!isset($_GET['ac_level_id'])) {
    echo '<option value="">Select Branch</option>';
    exit;
}
if (!isset($_GET['ed_level_id'])) {
    echo '<option value="">Select Branch</option>';
    exit;
}

$ac_level_id = intval($_GET['ac_level_id']);
$ed_level_id = intval($_GET['ed_level_id']);

$stmt = $con->prepare("
    SELECT id, branch_name 
    FROM gallery_branches 
    WHERE academic_level = ? AND education_level = ? AND is_delete = 0 AND is_active = 1
    ORDER BY id ASC
");
$stmt->bind_param("ii", $ac_level_id, $ed_level_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<option value="">Select Branch</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['branch_name']) . '</option>';
    }
} else {
    echo '<option value="">No Branch Found</option>';
}

$stmt->close();
?>