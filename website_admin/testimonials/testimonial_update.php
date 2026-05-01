<?php
include '../include/checklogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $image_file = $_FILES['img_input'];
    $id = mysqli_real_escape_string($con, $_POST['testimonial_id']);
    $file_type = mysqli_real_escape_string($con, $_POST['file_type']);
    $name = mysqli_real_escape_string($con, $_POST['testinomial_title']);
    $description = $_POST['testinomial_description'];
    $testimonial_type = mysqli_real_escape_string($con, $_POST['test_type']);

    if ($file_type == 'image') {
      

        $stmt = $con->prepare("UPDATE `tbl_testimonial` SET testimonial_type=?, file_type=?, name=?, description=? WHERE id=?");
        $stmt->bind_param("ssssi", $testimonial_type, $file_type, $name, $description, $id);
        $result = $stmt->execute();
        
        if ($result) {
            
            if ($_FILES['img_input']['error'] === 0) {
                
                // Check if new image is uploaded
                $targetDirectory = "../uploads/testimonial/";
                $file_upload_status = upload_single_file($_FILES["img_input"], $targetDirectory, 1);
                if ($file_upload_status['status'] == 200) {
                  
                    $file_name = $file_upload_status['message'];
                    $stmt = $con->prepare("UPDATE `tbl_testimonial` SET file = ? where id = ?");
                    $stmt->bind_param("si", $file_name, $id);
                    $result = $stmt->execute();
                    $_SESSION['status'] = "Testimonial Updated Successfully";
                    $_SESSION['status_code'] = "success";
                    echo "<script>setTimeout(function(){window.location='testimonial_view.php'}, 1000);</script>";
                } else {
                    $_SESSION['status'] = $uploaded_images['message'];
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='testimonial_view.php'},1000)</script>";
                }
            } else {
                if ($result) {
                    $_SESSION['status'] = "Testimonial Updated Successfully";
                    $_SESSION['status_code'] = "success";
                    echo "<script>setTimeout(function(){window.location='testimonial_view.php'}, 1000);</script>";
                } else {
                    $_SESSION['status'] = "Testimonial Update Failed";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='testimonial_view.php'}, 1000);</script>";
                }
            }
        }
    }
}
