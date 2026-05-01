<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// GET faculty id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $faculty_id = mysqli_real_escape_string($con, $_GET['id']);
    $faculty_id = only_digits($faculty_id);
    if ($faculty_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='faculty_view.php'},1000)</script>"; 
        }
        
    // Prepare and execute the SQL statement to delete a record in the tbl_faculty
    $stmt = $con->prepare("UPDATE `tbl_faculty` SET is_delete = 1 WHERE id = ? ");
    $stmt->bind_param("i", $faculty_id);
    $result = $stmt->execute();

    if ($result) {

        // Sweet Alert of Success Message
        $_SESSION['status'] = "Faculty Delete Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='faculty_view.php'},1000);</script>";
    } else {

        // Sweet Alert of Error Message
        $_SESSION['status'] = "Faculty Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='faculty_view.php'},1000);</script>";
    }
}
