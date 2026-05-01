<?php
include '../include/checklogin.php';

// GET faculty id from display table
if (isset($_GET['ach_id']) && !empty($_GET['ach_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['ach_id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='achievement_view.php'},1000)</script>";
        exit; // Terminate the script execution
    }
}

$stmt = $con->prepare("DELETE FROM `tbl_achievement` WHERE id = ?");
$stmt->bind_param("i", $id);
$result = $stmt->execute();

if ($result) {
    $status = 0;
    $type = "achievement";
    
    // Get file names from tbl_site_photos
    $cmd = $con->prepare("SELECT photos.file_name as file_name FROM `tbl_site_photos` as photos WHERE photos.type = ? AND photos.type_id = ?");
    $cmd->bind_param("si", $type, $id);
    $cmd->execute();
    $result2 = $cmd->get_result();
   
    while ($row = $result2->fetch_assoc()) {
        $file_name = $row['file_name'];
        $path = '../uploads/achievement/';
        
        // Delete file from directory
        if (delete_file($file_name, $path)) {
            // Delete tbl_site_photos records
            $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE type_id = ? AND type = ?");
            $stmt->bind_param("is", $id, $type);
            $file_delete = $stmt->execute();

            if ($file_delete) {
                $_SESSION['status'] = "Achievement is Deleted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='achievement_view.php'},1000);</script>";
                exit; // Terminate the script execution
            } else {
                $_SESSION['status'] = "Achievement Deletion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='achievement_view.php'},1000);</script>";
                exit; // Terminate the script execution
            }
        } else {
            $_SESSION['status'] = "Achievement Deletion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='achievement_view.php'},1000);</script>";
            exit; // Terminate the script execution
        }
    }
} else {
    $_SESSION['status'] = "Achievement Deletion Failed";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='achievement_view.php'},1000);</script>";
    exit; // Terminate the script execution
}
?>