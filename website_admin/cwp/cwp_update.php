<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
  
    $cwp_id = mysqli_real_escape_string($con, $_POST['cwp_id']);
    $title = $_POST['title'];
    $description = $_POST['description'];
   
    // Validate Data
    $cwp_id = validate_data($cwp_id);
    
    $stmt = $con->prepare("UPDATE `tbl_campus` SET  `title` = ?, `description`=? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $description, $cwp_id);
    $result = $stmt->execute();

    if ($_FILES['image_upload']['error'][0] == 0) {
        // Delete previous images from 'tbl_site_photos'
        $type = "cwp";
        $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? AND type = ?");
        $stmt->bind_param("ss", $cwp_id, $type);
        $result = $stmt->execute();

        // Check if photos are deleted successfully
        if ($result) {
            $targetDirectory = "../uploads/cwp/";
            $uploaded_images = upload_multiple_files($_FILES["image_upload"], $targetDirectory, 1);
            // Check if new images are uploaded successfully
            if ($uploaded_images['status'] == 200) {
                foreach ($uploaded_images['message'] as $file_name) {
                    $file_type = "image";
                    $file_name = implode("", $file_name);
                     // Prepare and execute SQL statement for inserting new image data into 'tbl_site_photos'
                    $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $cwp_id, $type, $file_name, $file_type);
                    $result = $stmt->execute();
                }
                // Set session status and code for success
                $_SESSION['status'] = "cwp updated successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='cwp_view.php'},1000);</script>";
            } else {
                // Set session status and code for error if image upload failed
                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='cwp_view.php'},1000)</script>";
            }
        }
    } else {
        if ($result) {
            // Set session status and code for success
            $_SESSION['status'] = "cwp updated successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='cwp_view.php'},1000);</script>";
        }
    }
}
?>
