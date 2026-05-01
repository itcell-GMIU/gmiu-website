<?php
session_start();

include '../../common/globalvariable.php';
include '../../database/connect.php';
include '../../common/function.php';
include '../../common/validation.php';

header('Content-Type: application/json');

if (!isset($_GET['ac_level_id'])) {
    echo '<option value="">Select Education Level</option>';
    exit;
}

$ac_level_id = intval($_GET['ac_level_id']);

$stmt = $con->prepare("
    SELECT id, name 
    FROM gallery_education_level 
    WHERE ac_level_id = ? AND is_delete = 0 AND is_active = 1
    ORDER BY id ASC
");
$stmt->bind_param("i", $ac_level_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<option value="">Select Education Level</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
    }
} else {
    echo '<option value="">No Education Levels Found</option>';
}

$stmt->close();
?>