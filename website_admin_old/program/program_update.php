<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// if submit button is clicked then code performs
if (isset($_POST['submit'])) {

    // Fetch data from edit form
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $program_name = mysqli_real_escape_string($con, $_POST['program_name']);
    $program_shortname = mysqli_real_escape_string($con, $_POST['program_shortname']);
    $program_code = mysqli_real_escape_string($con, $_POST['program_code']);
    $program_short_no = mysqli_real_escape_string($con, $_POST['program_short_no']);
    $program_intake = mysqli_real_escape_string($con, $_POST['program_intake']);
    $program_duration = mysqli_real_escape_string($con, $_POST['program_duration']);
    $program_regular = mysqli_real_escape_string($con, $_POST['program_regular']);
    $program_minor = mysqli_real_escape_string($con, $_POST['program_minor']);

  /*   $program_blended_mode = mysqli_real_escape_string($con, $_POST['program_blended_mode']);
    $program_honors = mysqli_real_escape_string($con, $_POST['program_honors']);
    $program_international = mysqli_real_escape_string($con, $_POST['program_international']); */
   
   
    $program_genius = mysqli_real_escape_string($con, $_POST['program_genius']);
    // $short_description = $_POST['short_description'];
    $program_description = $_POST['program_description'];
    $program_status = mysqli_real_escape_string($con, $_POST['program_status']);
    $program_video_link = mysqli_real_escape_string($con, $_POST['program_video_link']);
    $genius_token = mysqli_real_escape_string($con, $_POST['genius_token']);
   /*  $international_token = mysqli_real_escape_string($con, $_POST['international_token']);
    $honors_token = mysqli_real_escape_string($con, $_POST['honors_token']);
    $blended_mode_token = mysqli_real_escape_string($con, $_POST['blended_mode_token']); */
    $regular_token = mysqli_real_escape_string($con, $_POST['regular_token']);
    $minor_token = mysqli_real_escape_string($con, $_POST['minor_token']);


    // Validate Data
    $program_id = validate_data($program_id);
    $program_name = validate_data($program_name);
    // $program_shortname = validate_data($program_shortname);
    $program_code = validate_data($program_code);
    $program_intake = validate_data($program_intake);
    $program_duration = validate_data($program_duration);
    $program_regular = validate_data($program_regular);
    $program_minor = validate_data($program_minor);

 /*    $program_blended_mode = validate_data($program_blended_mode);
    $program_honors = validate_data($program_honors);
    $program_international = validate_data($program_international); */
  
    // $program_shortname = validate_data($program_shortname);
    $program_genius = validate_data($program_genius);
    $program_status = validate_data($program_status);
    $program_video_link = validate_data($program_video_link);
    $genius_token = validate_data($genius_token);
  /*   $international_token = validate_data($international_token);
    $honors_token = validate_data($honors_token);
    $blended_mode_token = validate_data($blended_mode_token); */
    $regular_token = validate_data($regular_token); 
    $minor_token = validate_data($minor_token); 


    // Prepare and execute the SQL statement to update a record in the tbl_program
   /*  $stmt = $con->prepare("UPDATE `tbl_program` SET `faculty_id`=?, `level_id`=?, `name`=?,`description`=?,`shortname`=?,`code`=?,`intake`=?,`duration`=?,`regular`=?,`blended_mode`=?,`honors`=?,`genius`=?,`international`=?,`is_active`=?,`video_link`=?,`token` = ?, `token_genius` = ?, `token_international` = ?, `token_honors` = ?, `token_blended_mode` = ? WHERE id = ? ");
    $stmt->bind_param("iissssisdddddisdddddi",$faculty_id,$level_id,$program_name,$program_description,$program_shortname,$program_code,$program_intake,$program_duration,$program_regular,$program_blended_mode,$program_honors,$program_genius,$program_international,$program_status,$program_video_link,$regular_token,$genius_token,$international_token,$honors_token,$blended_mode_token ,$program_id );
    */
    $stmt = $con->prepare("UPDATE `tbl_program` SET `minor`=?,`token_minor`=?,`faculty_id`=?, `level_id`=?, `name`=?,`description`=?,`shortname`=?,`code`=?,`intake`=?,`duration`=?,`regular`=?,`genius`=?,`is_active`=?,`video_link`=?,`token` = ?, `token_genius` = ? ,`short_no` = ?  WHERE id = ? ");
    $stmt->bind_param("ddiissssisddisddsi",$program_minor,$minor_token,$faculty_id,$level_id,$program_name,$program_description,$program_shortname,$program_code,$program_intake,$program_duration,$program_regular,$program_genius,$program_status,$program_video_link,$regular_token,$genius_token, $program_short_no,$program_id );
   
    
    $result = $stmt->execute();
    if ($result) {

        //Sweet Alert of Success Message
        $_SESSION['status'] = "Program Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='program_view.php'},1000);</script>";
    } else {

        //Sweet Alert of Error Message
        $_SESSION['status'] = "Program Updation Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='program_view.php'},1000)</script>";
    }
}