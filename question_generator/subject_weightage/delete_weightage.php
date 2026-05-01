<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// GET id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $id = only_digits($id);
    
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='view_weightage.php'},1000)</script>";
        exit();
    }
    
    // Prepare and execute the SQL statement to mark the tbl_weightage record as deleted
    $stmt_weightage = $con->prepare("UPDATE `tbl_weightage` SET is_delete = 1, is_active = 0, delete_by = ? WHERE subject_code = ?");
    $stmt_weightage->bind_param("ii", $web_admin_id, $id);
    $result_weightage = $stmt_weightage->execute();

    // Prepare and execute the SQL statement to mark the tbl_bl_level record as deleted
    $stmt_bl_level = $con->prepare("UPDATE `tbl_bl_level` SET is_delete = 1, is_active = 0, delete_by = ? WHERE subject_code = ?");
    $stmt_bl_level->bind_param("ii", $web_admin_id, $id);
    $result_bl_level = $stmt_bl_level->execute();

    // Check if both updates were successful
    if ($result_weightage && $result_bl_level) {
        $_SESSION['status'] = "Subject weightage and Bloom's level deleted successfully.";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='view_weightage.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Subject weightage and Bloom's level deletion failed.";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='view_weightage.php'},1000);</script>";
    }
}
?>
