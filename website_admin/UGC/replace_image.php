<?php
include '../include/checklogin.php';

header('Content-Type: application/json');

if (!isset($_POST['image_id']) || !isset($_FILES['new_image'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
    exit;
}

$image_id = mysqli_real_escape_string($con, $_POST['image_id']);
$file = $_FILES['new_image'];

// Get current image path
$query = "SELECT image_path FROM tbl_admission_merit_images WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $image_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $old_image = $row['image_path'];
    
    // Check file type
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'webp');
    
    if (!in_array($fileExtension, $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Allowed types: ' . implode(', ', $allowedTypes)]);
        exit;
    }
    
    // Check file size (5MB limit)
    if ($file['size'] > 5 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'File is too large. Maximum size is 5MB']);
        exit;
    }
    
    // Generate unique filename
    $uniqueFileName = uniqid() . '_' . time() . '.' . $fileExtension;
    $targetDirectory = "../../uploads/ugc/";
    $targetFilePath = $targetDirectory . $uniqueFileName;
    
    // Upload new file
    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        // Delete old file
        $old_file_path = $targetDirectory . $old_image;
        if (file_exists($old_file_path)) {
            unlink($old_file_path);
        }
        
        // Update database
        $stmt = $con->prepare("UPDATE tbl_admission_merit_images SET image_path = ? WHERE id = ?");
        $stmt->bind_param("si", $uniqueFileName, $image_id);
        
        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'new_path' => '../../uploads/ugc/' . $uniqueFileName
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload new image']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Image not found']);
}
?> 