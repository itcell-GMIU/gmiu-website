<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// GET level id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $level_id = mysqli_real_escape_string($con, $_GET['id']);
    $level_id = only_digits($level_id);
    if ($level_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='level_view.php'},1000)</script>"; 
        }
    
    // Prepare and execute the SQL statement to delete a record in the tbl_level
    $stmt = $con->prepare("UPDATE `tbl_level` SET is_delete = 1 WHERE id = ? ");
    $stmt->bind_param("i", $level_id);
    $result = $stmt->execute();

    if ($result) {

        // Sweet Alert of Success Message
        $_SESSION['status'] = "Level Deleted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='level_view.php'},1000);</script>";
    } else {

        // Sweet Alert of Error Message
        $_SESSION['status'] = "Level Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='level_view.php'},1000);</script>";
    }
}
