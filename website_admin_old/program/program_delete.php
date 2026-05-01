<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// GET level id from display table
if (isset($_GET['program_id']) && !empty($_GET['program_id'])) {

    $program_id = mysqli_real_escape_string($con, $_GET['program_id']);
    $program_id = only_digits($program_id);
    if ($program_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='program_view.php'},1000)</script>"; 
        }
    // Prepare and execute the SQL statement to delete a record in the tbl_program
    $stmt = $con->prepare("UPDATE `tbl_program` SET is_delete = 1 WHERE id = ? ");
    $stmt->bind_param("i", $program_id);
    $result = $stmt->execute();
    if ($result) {

        // Sweet Alert of Success Message
        $_SESSION['status'] = "Program Deleted Successfully";
        $_SESSION['status_code'] = "success";

        echo "<script>setTimeout(function(){window.location='program_view.php'},1000);</script>";
    } else {

        // Sweet Alert of Error Message
        $_SESSION['status'] = "Faculty Deletion Failed";
        $_SESSION['status_code'] = "error";

        echo "<script>setTimeout(function(){window.location='program_view.php'},1000);</script>";
    }
}
