<?php
include '../include/checklogin.php';

if (isset($_GET['tbl_site_photos_file_id']) && !empty($_GET['tbl_site_photos_file_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['tbl_site_photos_file_id']);
    $id = only_digits($id);
    
    if ($id === false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='startup_gallery_view.php'},1000)</script>";
        exit;
    }

    $type = "startup_gallery_image";
    // Prepare and execute the select query
    $cmd = $con->prepare("SELECT photos.file_name as file_name FROM `tbl_site_photos` as photos WHERE photos.type = ? AND photos.id = ?");
    $cmd->bind_param("si", $type, $id);

    if ($cmd->execute()) {
        $result2 = $cmd->get_result();
        
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                $file_name = $row['file_name'];
                $path = '../uploads/startup_gallery_image/';
                
                // Delete file from directory
                if (delete_file($file_name, $path)) {
                    // Prepare and execute the delete query
                    $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE id = ? AND type = ?");
                    $stmt->bind_param("is", $id, $type);
                    
                    if ($stmt->execute()) {
                        $_SESSION['status'] = "Startup Gallery Image Deleted Successfully";
                        $_SESSION['status_code'] = "success";
                    } else {
                        $_SESSION['status'] = "Startup Gallery Image Deletion Failed";
                        $_SESSION['status_code'] = "error";
                    }
                } else {
                    $_SESSION['status'] = "Failed to delete the file from the directory";
                    $_SESSION['status_code'] = "error";
                }
                
                echo "<script>setTimeout(function(){window.location='startup_gallery_view.php'},1000);</script>";
                exit;
            }
        } else {
            $_SESSION['status'] = "No matching record found";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='startup_gallery_view.php'},1000);</script>";
            exit;
        }
    } else {
        $_SESSION['status'] = "Database query failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='startup_gallery_view.php'},1000);</script>";
        exit;
    }
}
?>
