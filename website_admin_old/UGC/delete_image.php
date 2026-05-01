<?php
include '../include/checklogin.php';

header('Content-Type: application/json');

if (!isset($_POST['image_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No image ID provided']);
    exit;
}

$image_id = mysqli_real_escape_string($con, $_POST['image_id']);

// Get image path before deleting
$query = "SELECT image_path FROM tbl_admission_merit_images WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $image_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Delete physical file
    $image_path = "../../uploads/ugc/" . $row['image_path'];
    if (file_exists($image_path)) {
        unlink($image_path);
    }
    
    // Soft delete the record
    $stmt = $con->prepare("UPDATE tbl_admission_merit_images SET is_delete = '1' WHERE id = ?");
    $stmt->bind_param("i", $image_id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Image not found']);
}
?> 