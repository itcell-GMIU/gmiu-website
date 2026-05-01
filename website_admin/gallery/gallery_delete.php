<?php
include '../include/checklogin.php';

if (isset($_GET['tbl_site_photos_file_id']) && !empty($_GET['tbl_site_photos_file_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['tbl_site_photos_file_id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='gallery_view.php'},1000)</script>";
        exit; // Terminate the script execution
    }


    $status = 0;
    $type = "gallery_image";
    // Get file names from tbl_site_photos
    $cmd = $con->prepare("SELECT photos.file_name as file_name FROM `tbl_site_photos` as photos WHERE photos.type = ? AND photos.id = ?");
    $cmd->bind_param("ss", $type, $id);
    $cmd->execute();
    $result2 = $cmd->get_result();

    while ($row = $result2->fetch_assoc()) {
        $file_name = $row['file_name'];
        $path = '../uploads/gallery_image/';
        // Delete file from directory
        if (delete_file($file_name, $path)) {


            // Delete tbl_site_photos records
            $type = "gallery_image";
            $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE id = ? AND type = ?");
            $stmt->bind_param("is", $id, $type);
            $file_delete = $stmt->execute();

            if ($file_delete) {
                $_SESSION['status'] = "Gallery Image Delete Successfully";
                $_SESSION['status_code'] = "success";

                echo "<script>setTimeout(function(){window.location='gallery_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Gallery Image Deletion Failed";
                $_SESSION['status_code'] = "error";

                echo "<script>setTimeout(function(){window.location='gallery_view.php'},1000);</script>";
            }
        } else {
            $_SESSION['status'] = "Gallery Image Deletion Failed";
            $_SESSION['status_code'] = "error";

            echo "<script>setTimeout(function(){window.location='gallery_view.php'},1000);</script>";
        }
    }
}
?>