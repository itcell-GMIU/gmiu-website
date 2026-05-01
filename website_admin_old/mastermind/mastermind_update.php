<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
  
    $mm_id = mysqli_real_escape_string($con, $_POST['mm_id']);
    $staff_id = $_POST['staff_id'];
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];
    // Validate Data
    $mm_id = validate_data($mm_id);
    
  
    $stmt = $con->prepare("UPDATE `tbl_campus` SET `staff_id`=?, `title`=?, `subtitle`=?, `description`=? WHERE id = ?");
 
    $stmt->bind_param("isssi", $staff_id, $title, $subtitle, $description, $mm_id);
    $result = $stmt->execute();

    if ($_FILES['image_upload']['error'][0] == 0) {
        // Delete previous images from 'tbl_site_photos'
        $type = "mastermind";
        $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? AND type = ?");
        $stmt->bind_param("ss", $mm_id, $type);
        $result = $stmt->execute();

        // Check if photos are deleted successfully
        if ($result) {
            $targetDirectory = "../uploads/mastermind/";
            $uploaded_images = upload_multiple_files($_FILES["image_upload"], $targetDirectory, 1);
            // Check if new images are uploaded successfully
            if ($uploaded_images['status'] == 200) {
                foreach ($uploaded_images['message'] as $file_name) {
                    $file_type = "image";
                    $file_name = implode("", $file_name);
                     // Prepare and execute SQL statement for inserting new image data into 'tbl_site_photos'
                    $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $mm_id, $type, $file_name, $file_type);
                    $result = $stmt->execute();
                }
                // Set session status and code for success
                $_SESSION['status'] = "mastermind updated successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='mastermind_view.php'},1000);</script>";
            } else {
                // Set session status and code for error if image upload failed
                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='mastermind_view.php'},1000)</script>";
            }
        }
     }
    else {
        if ($result) {
            // Set session status and code for success
            $_SESSION['status'] = "mastermind updated successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='mastermind_view.php'},1000);</script>";
        }
    }
}
?>
