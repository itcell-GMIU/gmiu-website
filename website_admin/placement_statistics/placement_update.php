<?php
include '../include/checklogin.php';
if ($role_id == 8)
{
    if (isset($_POST["submit"])) {

        $placement_year = mysqli_real_escape_string($con, $_POST['year']);
        $placement_id = mysqli_real_escape_string($con, $_POST['placement_id']);
        $placement_student_name = mysqli_real_escape_string($con, $_POST['student_name']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    
        $placement_year = validate_data($placement_year);
        $placement_student_name = validate_data($placement_student_name);
        $placement_id = validate_data($placement_id);
        
        $faculty_id = $_SESSION['faculty_id'];
        $program_id = $_SESSION['program_id'];
        $faculty_id = validate_data($faculty_id);
        $program_id = validate_data($program_id);
        $level_id = validate_data($level_id);
    
     
        $placement_student_image = $_FILES['student_image'];
         
        $placement_company_logo = $_FILES['company_logo'];
       // Check if new student image is uploaded
        if (!empty($placement_student_image['name'])) {
            $targetDirectory = "../uploads/placement/student_image/";
            $file_upload_status = upload_single_file($_FILES["student_image"], $targetDirectory, 1);
            $placement_student_image = $file_upload_status['message'];
        } else {
            $placement_student_image = $_POST['old_student_image'];
        }
    // Check if new company logo is uploaded
        if (!empty($placement_company_logo['name'])) {
            $targetDirectory = "../uploads/placement/company_logo/";
            $file_upload_status = upload_single_file($_FILES["company_logo"], $targetDirectory, 1);
            $placement_company_logo = $file_upload_status['message'];
        } else {
             // Use the existing company logo
            $placement_company_logo = $_POST['old_company_logo'];
        }
    
        
        // Prepare and execute SQL statement for updating 'tbl_placement' data
        $stmt = $con->prepare("UPDATE `tbl_placement` SET faculty_id = ?,level_id = ?,program_id = ?,student_name  = ?,year = ?,student_image=?,company_logo=? WHERE id = ? ");
        $stmt->bind_param("iisssssi", $faculty_id, $level_id, $program_id, $placement_student_name, $placement_year, $placement_student_image, $placement_company_logo, $placement_id);
        $result = $stmt->execute();
        if ($result) {
    
            // Sweet Alert of Success Message
            $_SESSION['status'] = "Placement Details Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='placement_view.php'},1000);</script>";
        } else {
    
            // Sweet Alert of Error Message
            $_SESSION['status'] = "Placement Details  Updation Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='placement_view.php'},1000)</script>";
        }
    }
}else
{
if (isset($_POST["submit"])) {

    $placement_year = mysqli_real_escape_string($con, $_POST['year']);
    $placement_id = mysqli_real_escape_string($con, $_POST['placement_id']);
    $placement_student_name = mysqli_real_escape_string($con, $_POST['student_name']);
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $placement_year = validate_data($placement_year);
    $placement_student_name = validate_data($placement_student_name);
    $placement_id = validate_data($placement_id);
    $faculty_id = validate_data($faculty_id);
    
    $program_ids = $_POST['program_id']; // Array from multiple select
    $program_id_str = implode(',', array_map('intval', $program_ids));
    $program_id_str = validate_data($program_id_str);
    
    $level_id = validate_data($level_id);

 
    $placement_student_image = $_FILES['student_image'];
     
    $placement_company_logo = $_FILES['company_logo'];
   // Check if new student image is uploaded
    if (!empty($placement_student_image['name'])) {
        $targetDirectory = "../uploads/placement/student_image/";
        $file_upload_status = upload_single_file($_FILES["student_image"], $targetDirectory, 1);
        $placement_student_image = $file_upload_status['message'];
    } else {
        $placement_student_image = $_POST['old_student_image'];
    }
// Check if new company logo is uploaded
    if (!empty($placement_company_logo['name'])) {
        $targetDirectory = "../uploads/placement/company_logo/";
        $file_upload_status = upload_single_file($_FILES["company_logo"], $targetDirectory, 1);
        $placement_company_logo = $file_upload_status['message'];
    } else {
         // Use the existing company logo
        $placement_company_logo = $_POST['old_company_logo'];
    }

    
    // Prepare and execute SQL statement for updating 'tbl_placement' data
    $stmt = $con->prepare("UPDATE `tbl_placement` SET faculty_id = ?,level_id = ?,program_id = ?,student_name  = ?,year = ?,student_image=?,company_logo=? WHERE id = ? ");
    $stmt->bind_param("iisssssi", $faculty_id, $level_id, $program_id_str, $placement_student_name, $placement_year, $placement_student_image, $placement_company_logo, $placement_id);
    $result = $stmt->execute();
    if ($result) {

        // Sweet Alert of Success Message
        $_SESSION['status'] = "Placement Details Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='placement_view.php'},1000);</script>";
    } else {

        // Sweet Alert of Error Message
        $_SESSION['status'] = "Placement Details  Updation Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='placement_view.php'},1000)</script>";
    }
}
}
?>