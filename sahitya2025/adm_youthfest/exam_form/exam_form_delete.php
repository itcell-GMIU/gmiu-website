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
        echo "<script>setTimeout(function(){window.location='exam_form_view.php'},100)</script>";
    }
    // Prepare and execute the SQL statement to delete a record in the tbl_program_outcome
    $stmt = $con->prepare("UPDATE `tbl_exam_form` SET is_delete = 1, is_active = 0 WHERE id = ? ");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    if ($result) {
        $_SESSION['status'] = "Exam Form Deletion Failed";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='exam_form_view.php'},100);</script>";
    }
}
