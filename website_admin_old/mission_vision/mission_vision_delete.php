<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// GET mission_vission id from display table
if (isset($_GET['mission_vision_id']) && !empty($_GET['mission_vision_id'])) {
    $mission_vision_id = mysqli_real_escape_string($con, $_GET['mission_vision_id']);
    $mission_vision_id = only_digits($mission_vision_id);
    if ($mission_vision_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='mission_vision_view.php'},1000)</script>"; 
        } 
 
// Prepare and execute the SQL statement to delete a record in the tbl_mission_vision        
$stmt = $con->prepare("UPDATE `tbl_mission_vision` SET is_delete = 1 WHERE id = ? ");
$stmt->bind_param("i", $mission_vision_id);
$result = $stmt->execute();
if ($result) {
    // Sweet Alert of Success Message
    $_SESSION['status'] = "Mission & Vision Deleted Successfully";
        $_SESSION['status_code'] = "success";

        echo "<script>setTimeout(function(){window.location='mission_vision_view.php'},1000);</script>";
} else {
    // Sweet Alert of Error Message
    $_SESSION['status'] = "Mission & Vision Deletion Failed";
        $_SESSION['status_code'] = "error";

        echo "<script>setTimeout(function(){window.location='mission_vision_view.php'},1000);</script>";
}
}