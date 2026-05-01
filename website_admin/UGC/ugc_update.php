<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (!isset($_POST['submit'])) {
    $_SESSION['status'] = "Invalid Request";
    $_SESSION['status_code'] = "error";
    header("Location: ugc_view.php");
    exit();
}

$id = mysqli_real_escape_string($con, $_POST['id']);
$type = mysqli_real_escape_string($con, $_POST['type']);
$year = mysqli_real_escape_string($con, $_POST['year']);

// Handle new image uploads if provided
if (isset($_FILES['file_input']) && !empty($_FILES['file_input']['name'][0])) {
    $uploaded_files = [];
    $upload_errors = [];
    
    // Loop through each uploaded file
    foreach($_FILES['file_input']['name'] as $key => $fileName) {
        if(empty($fileName)) continue;
        
        $fileTmpName = $_FILES['file_input']['tmp_name'][$key];
        $fileSize = $_FILES['file_input']['size'][$key];
        
        // Generate unique filename
       // Clean original filename – replace spaces with _
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileBaseName = pathinfo($fileName, PATHINFO_FILENAME);
        
        // Remove unwanted characters except letters, numbers, underscores, and hyphens
        $fileBaseName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $fileBaseName);
        
        // Final file name with original extension
        $uniqueFileName = $fileBaseName . '.' . $fileExtension;

        
        // Check file type
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        if (!in_array(strtolower($fileExtension), $allowedTypes)) {
            $upload_errors[] = "Invalid file type for $fileName. Allowed types: " . implode(', ', $allowedTypes);
            continue;
        }
        
        // Check file size (5MB limit)
        if ($fileSize > 5 * 1024 * 1024) {
            $upload_errors[] = "File $fileName is too large. Maximum size is 5MB";
            continue;
        }
        
        $targetDirectory = "../../uploads/ugc/";
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }
        
        $targetFilePath = $targetDirectory . $uniqueFileName;
        
        if (move_uploaded_file($fileTmpName, $targetFilePath)) {
            $uploaded_files[] = $uniqueFileName;
        } else {
            $upload_errors[] = "Failed to upload $fileName";
        }
    }
    
    if (!empty($uploaded_files)) {
        // Update the record
        $stmt = $con->prepare("UPDATE tbl_admission_merit SET type=?, year=? WHERE id=?");
        $stmt->bind_param("sii", $type, $year, $id);
        
        if ($stmt->execute()) {
            // Insert additional images
            foreach ($uploaded_files as $image) {
                $stmt2 = $con->prepare("INSERT INTO tbl_admission_merit_images (merit_id, image_path) VALUES (?, ?)");
                if ($stmt2) {
                    $stmt2->bind_param("is", $id, $image);
                    $stmt2->execute();
                }
            }
            
            $_SESSION['status'] = "UGC Updated Successfully";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Error Updating Record";
            $_SESSION['status_code'] = "error";
        }
    } else if (!empty($upload_errors)) {
        $_SESSION['status'] = implode("\n", $upload_errors);
        $_SESSION['status_code'] = "error";
        header("Location: ugc_edit.php?id=" . $id);
        exit();
    }
} else {
    // Just update type and year
    $stmt = $con->prepare("UPDATE tbl_admission_merit SET type=?, year=? WHERE id=?");
    $stmt->bind_param("sii", $type, $year, $id);
    
    if ($stmt->execute()) {
        $_SESSION['status'] = "UGC Updated Successfully";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Error Updating Record";
        $_SESSION['status_code'] = "error";
    }
}

header("Location: ugc_view.php");
exit();
?>