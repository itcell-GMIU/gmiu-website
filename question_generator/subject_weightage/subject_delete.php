<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// GET  id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='subject_view.php'},1000)</script>";
    }
    // Prepare and execute the SQL statement to delete a record in the tbl_program_outcome
    $stmt = $con->prepare("UPDATE `tbl_std_corner_exam` SET is_delete = 1,is_active = 0 WHERE id = ? ");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    if ($result) {
        $_SESSION['status'] = "Subject Deleted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='subject_view.php'},1000);</script>";
    }
} else {
    $_SESSION['status'] = "Subject Deletion Failed";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='subject_view.php'},1000);</script>";
}
    // Sweet Alert of Success Message
