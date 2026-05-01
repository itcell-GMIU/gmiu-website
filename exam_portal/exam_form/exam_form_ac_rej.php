<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// GET  id from display table
if (isset($_GET['ac_id']) && !empty($_GET['ac_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['ac_id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='exam_form_actions.php'},100)</script>";
    }
    // Prepare and execute the SQL statement to delete a record in the tbl_program_outcome
    $stmt = $con->prepare("UPDATE `tbl_exam_student` SET status = 1 WHERE id = ? ");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    if ($result) {
        $_SESSION['status'] = "Exam Form Approved";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='exam_form_actions.php'},100);</script>";
    }
}
if (isset($_GET['rej_id']) && !empty($_GET['rej_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['rej_id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='exam_form_actions.php'},100)</script>";
    }
    // Prepare and execute the SQL statement to delete a record in the tbl_program_outcome
    $stmt = $con->prepare("UPDATE `tbl_exam_student` SET status = 2 WHERE id = ? ");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    if ($result) {
        $_SESSION['status'] = "Exam Form Rejected";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='exam_form_actions.php'},100);</script>";
    }
}