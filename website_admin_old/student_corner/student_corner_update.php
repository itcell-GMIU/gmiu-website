<?php
include '../include/checklogin.php';
if($role_id == 8) {

    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $sem = $_POST['sem'];
        $subject_code = $_POST['subject_code'];
        $subject_name = $_POST['subject_name'];
        $subject_short_name = $_POST['subject_short_name'];
        $lectures = $_POST['lectures'];
        $tutorial = $_POST['tutorial'];
        $practical = $_POST['practical'];
        $credit = $_POST['credit'];
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        // Validate Data
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);
        $program_id = validate_data($program_id);
    
        $stmt = $con->prepare("UPDATE `tbl_std_corner` SET `faculty_id`=?, `level_id`=?, `program_id`=?, `sem`=? , `subject_code`=? , `subject_name`=? , `subject_short_name`=?,  `lectures`=?,  `tutorial`=?,  `practical`=?,  `credit`=? WHERE id = ?");
        $stmt->bind_param("iiiisssiiiii", $faculty_id, $level_id, $program_id, $sem, $subject_code, $subject_name, $subject_short_name, $lectures, $tutorial, $practical, $credit,  $id);
        $result = $stmt->execute();
        if ($result) {
    
    
    
            if ($_FILES['report_upload']['error']  === 0) {
                // Check if new image is uploaded
                $targetDirectory = "../uploads/Syllabus/";
                $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);
                if ($file_upload_status['status'] == 200) {
                    $file_name = $file_upload_status['message'];
                    $stmt = $con->prepare("UPDATE `tbl_std_corner` SET Syllabus = ? WHERE id = ? ");
                    $stmt->bind_param("si",$file_name, $id);
                    $result = $stmt->execute();
                    $type_id = $con->insert_id;
                   
                } else {
                    $_SESSION['status'] = $file_upload_status['message'];
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000)</script>";
                    //error message popup
                }
            }
        
                    $_SESSION['status'] = "SDP Inserted Successfully";
                    $_SESSION['status_code'] = "success";
                    echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000);</script>";
            }
    
            if ($result){
            $_SESSION['status'] = "Student Corner Updated Successfully";
            $_SESSION['status_code'] = "success";
           echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Student Corner Updation Failed: " . $stmt->error;
            $_SESSION['status_code'] = "error";
           echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000)</script>";
        }
    
        $stmt->close();
    }

}
    else
    {
    
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $faculty_id = $_POST['faculty_id'];
    $level_id = $_POST['level_id'];
    $program_id = $_POST['program_id'];
    $sem = $_POST['sem'];
    $subject_code = $_POST['subject_code'];
    $subject_name = $_POST['subject_name'];
    $subject_short_name = $_POST['subject_short_name'];
    $lectures = $_POST['lectures'];
    $tutorial = $_POST['tutorial'];
    $practical = $_POST['practical'];
    $credit = $_POST['credit'];

    // Validate Data
    $faculty_id = validate_data($faculty_id);
    $level_id = validate_data($level_id);
    $program_id = validate_data($program_id);

    $stmt = $con->prepare("UPDATE `tbl_std_corner` SET `faculty_id`=?, `level_id`=?, `program_id`=?, `sem`=? , `subject_code`=? , `subject_name`=? , `subject_short_name`=?,  `lectures`=?,  `tutorial`=?,  `practical`=?,  `credit`=? WHERE id = ?");
    $stmt->bind_param("iiiisssiiiii", $faculty_id, $level_id, $program_id, $sem, $subject_code, $subject_name, $subject_short_name, $lectures, $tutorial, $practical, $credit,  $id);
    $result = $stmt->execute();
    if ($result) {



        if ($_FILES['report_upload']['error']  === 0) {
            // Check if new image is uploaded
            $targetDirectory = "../uploads/Syllabus/";
            $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);
            if ($file_upload_status['status'] == 200) {
                $file_name = $file_upload_status['message'];
                $stmt = $con->prepare("UPDATE `tbl_std_corner` SET Syllabus = ? WHERE id = ? ");
                $stmt->bind_param("si",$file_name, $id);
                $result = $stmt->execute();
                $type_id = $con->insert_id;
               
            } else {
                $_SESSION['status'] = $file_upload_status['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='sdp_insert.php'},1000)</script>";
                //error message popup
            }
        }
    
                $_SESSION['status'] = "SDP Inserted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='sdp_view.php'},1000);</script>";
        }

        if ($result){
        $_SESSION['status'] = "Student Corner Updated Successfully";
        $_SESSION['status_code'] = "success";
       echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Student Corner Updation Failed: " . $stmt->error;
        $_SESSION['status_code'] = "error";
       echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000)</script>";
    }

    $stmt->close();
}
    }
?>
