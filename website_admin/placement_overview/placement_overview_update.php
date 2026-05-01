<?php
include '../include/checklogin.php';
if($role_id == 8)
{
    if (isset($_POST['submit'])) {

        $id = mysqli_real_escape_string($con, $_POST['id']);
        $average_package = mysqli_real_escape_string($con, $_POST['average_package']);
        $highest_package = mysqli_real_escape_string($con, $_POST['highest_package']);
        $placement_rat = mysqli_real_escape_string($con, $_POST['placement_rat']);
        $placed_students = mysqli_real_escape_string($con, $_POST['placed_students']);
        $registered_students = mysqli_real_escape_string($con, $_POST['registered_students']);
        $year = mysqli_real_escape_string($con, $_POST['year']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        // Validate Data
    
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);
        $program_id = validate_data($program_id);
        
        
        // $program_description = validate_data($program_description);
        // update data into database
        $stmt = $con->prepare("UPDATE `tbl_placement_overview` SET `faculty_id`=?, `level_id`=?, `program_id`=?, `year` = ?, average_package=?,highest_package=?,placement_rat=?,placed_students=?,registered_students=? WHERE id = ?");
        $stmt->bind_param("iiiiiiiiii", $faculty_id, $level_id,$program_id,$year,$average_package, $highest_package,  $placement_rat, $placed_students,$registered_students,$id);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['status'] = "Placement Overview Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='placement_overview_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Placement Overview Updation Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='placement_overview_edit.php'},1000)</script>";
        }
    }

}else{


if (isset($_POST['submit'])) {

    $id = mysqli_real_escape_string($con, $_POST['id']);
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $average_package = mysqli_real_escape_string($con, $_POST['average_package']);
    $highest_package = mysqli_real_escape_string($con, $_POST['highest_package']);
    $placement_rat = mysqli_real_escape_string($con, $_POST['placement_rat']);
    $placed_students = mysqli_real_escape_string($con, $_POST['placed_students']);
    $registered_students = mysqli_real_escape_string($con, $_POST['registered_students']);
    $year = mysqli_real_escape_string($con, $_POST['year']);
   
    // Validate Data

    $faculty_id = validate_data($faculty_id);
    $level_id = validate_data($level_id);
    $program_id = validate_data($program_id);
    
    
    // $program_description = validate_data($program_description);
    // update data into database
    $stmt = $con->prepare("UPDATE `tbl_placement_overview` SET `faculty_id`=?, `level_id`=?, `program_id`=?, `year` = ?, average_package=?,highest_package=?,placement_rat=?,placed_students=?,registered_students=? WHERE id = ?");
    $stmt->bind_param("iiiiiiiiii", $faculty_id, $level_id,$program_id,$year,$average_package, $highest_package,  $placement_rat, $placed_students,$registered_students,$id);
    $result = $stmt->execute();
    if ($result) {
        $_SESSION['status'] = "Placement Overview Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='placement_overview_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Placement Overview Updation Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='placement_overview_edit.php'},1000)</script>";
    }
}
}
?>