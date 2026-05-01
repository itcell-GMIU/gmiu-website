<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
    $program_id =  $_POST['program_id'];
    $program_id = implode(',', $program_id);
    $laboratories_id = mysqli_real_escape_string($con, $_POST['laboratories_id']);
    $description = $_POST['description'];
    $title = mysqli_real_escape_string($con, $_POST['title']);

    // Validate Data
    $program_id = validate_data($program_id);
    $laboratories_id = validate_data($laboratories_id);
    $title = validate_data($title);
    $stmt = $con->prepare("UPDATE `tbl_laboratories` SET program_id = ?, `title`=?,`description`=? WHERE id = ? ");
    $stmt->bind_param("sssi", $program_id, $title, $description, $laboratories_id);
    $result = $stmt->execute();
    $type_id = $con->insert_id;
    if ($_FILES['image_upload']['error'][0]  == 0) {
       // Delete previous images from 'tbl_site_photos'
        $type = "lab";
        $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? and type = ?  ");
        $stmt->bind_param("ss", $laboratories_id, $type);
        $result = $stmt->execute();
       // Check if photos are deleted successfully
        if ($result) {
            $targetDirectory = "../uploads/laboratory/";
            $uploaded_images = upload_multiple_files($_FILES["image_upload"], $targetDirectory, 1);
            // Check if new images are uploaded successfully
            if ($uploaded_images['status'] == 200) {
                foreach ($uploaded_images['message'] as $file_name) {
                    $file_type = "image";
                    $type = "lab";
                    $file_name = implode("", $file_name);
                     // Prepare and execute SQL statement for inserting new image data into 'tbl_site_photos'
                    $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $laboratories_id, $type, $file_name, $file_type);
                    $result = $stmt->execute();
                }
                 // Set session status and code for success
                $_SESSION['status'] = "Laboratory Update Successfully ";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='laboratories_view.php'},1000);</script>";
            } else {
                  // Set session status and code for error if image upload failed
                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='laboratories_view.php'},1000)</script>";
            }
        }
    } else {
        if ($result) {
                // Set session status and code for success
            $_SESSION['status'] = "Laboratory Updated successfully ";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='laboratories_view.php'},1000);</script>";
        }
    }
}
?>