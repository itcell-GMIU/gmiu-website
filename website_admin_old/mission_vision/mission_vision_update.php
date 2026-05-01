<?php
// Include the checklogin.php file
include '../include/checklogin.php';
// if submit button is clicked then code performs
if (isset($_POST['submit'])) {
    
    // Fetch data from edit form
    $program_id = $_POST['program_id'];
    $program_id = implode(',', $program_id);
    $mission_vision_id = mysqli_real_escape_string($con, $_POST['mission_vision_id']);
    $mission = $_POST['mission'];
    $vision = $_POST['vision'];
    $mission_vision_status = mysqli_real_escape_string($con, $_POST['mission_vision_status']);
    
    // Validate Data
    $mission = validate_data($mission);
    $vision = validate_data($vision);
    $mission_vision_status = validate_data($mission_vision_status);
// Prepare and execute the SQL statement to update a record in the tbl_mission_vision
    $stmt = $con->prepare("UPDATE `tbl_mission_vision` SET program_id = ?, `mission`=?,`vision`=?, `is_active`=? WHERE id = ? ");
    $stmt->bind_param("sssii",$program_id, $mission, $vision,$mission_vision_status,$mission_vision_id);
    $result = $stmt->execute();
    if ($result) {
         //Sweet Alert of Success Message
        $_SESSION['status'] = "Mission & Vision Updated Successfully";
        $_SESSION['status_code'] = "success";

        echo "<script>setTimeout(function(){window.location='mission_vision_view.php'},1000);</script>";
    } else {
        //Sweet Alert of Error Message
        $_SESSION['status'] = "Mission & Vision Updation Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='mission_vision_view.php'},1000)</script>";
    }
}
