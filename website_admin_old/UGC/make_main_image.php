<?php
include '../include/checklogin.php';

header('Content-Type: application/json');

if (!isset($_POST['merit_id']) || !isset($_POST['image_path'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
    exit;
}

$merit_id = mysqli_real_escape_string($con, $_POST['merit_id']);
$image_path = mysqli_real_escape_string($con, $_POST['image_path']);

// Update the main image in tbl_admission_merit
$stmt = $con->prepare("UPDATE tbl_admission_merit SET image = ? WHERE id = ?");
$stmt->bind_param("si", $image_path, $merit_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database error']);
}
?> 