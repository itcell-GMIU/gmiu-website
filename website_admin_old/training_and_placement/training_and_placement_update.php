<?php
include '../include/checklogin.php';


if (isset($_POST["submit"])) {
    // Extract form data
    $id = $_POST["id"];

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $department = mysqli_real_escape_string($con, $_POST['department']);

    // Validate Data
    $name = validate_data($name);
    $department = validate_data($department);

    // Prepare and execute SQL statement for updating 
    $stmt = $con->prepare("UPDATE `tbl_tpa_coordinator` SET `name` = ?, `department` = ? WHERE `tbl_tpa_coordinator`.`id` = ?");
    $stmt->bind_param("ssi", $name, $department, $id);
    $result = $stmt->execute();
    if ($result) {
        if ($_FILES['image_upload']['error'] === 0) {
            // Check if new image is uploaded
            $targetDirectory = "../uploads/training_and_placement/";
            $file_upload_status = upload_single_file($_FILES["image_upload"], $targetDirectory, 1);
            if ($file_upload_status['status'] == 200) {
                $file_name = $file_upload_status['message'];
                $stmt = $con->prepare("UPDATE `tbl_tpa_coordinator` SET img_name = ? where id = ?");
                $stmt->bind_param("si", $file_name, $id);
                $result = $stmt->execute();
                $_SESSION['status'] = "TPA Coordinator Updated Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='training_and_placement_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='training_and_placement_edit.php'},1000)</script>";
            }
        } else {
            if ($result) {
                if ($result) {
                    $_SESSION['status'] = "TPA Coordinator  Updated Successfully";
                    $_SESSION['status_code'] = "success";

                    echo "<script>setTimeout(function(){window.location='training_and_placement_view.php'},1000);</script>";
                } else {
                    $_SESSION['status'] = "TPA Coordinator Update Failed";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='training_and_placement_view.php'},1000)</script>";
                }
            }
        }
    }
}
