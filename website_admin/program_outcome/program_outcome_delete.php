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
        echo "<script>setTimeout(function(){window.location='program_outcome_view.php'},1000)</script>"; 
        }
// Prepare and execute the SQL statement to delete a record in the tbl_program_outcome
$stmt = $con->prepare("UPDATE `tbl_program_outcome` SET is_delete = 1 WHERE id = ? ");
$stmt->bind_param("i", $id);
$result = $stmt->execute();
if ($result) {
    // Sweet Alert of Success Message
    $_SESSION['status'] = "Program Outcome Deleted Successfully";
        $_SESSION['status_code'] = "success";

        echo "<script>setTimeout(function(){window.location='program_outcome_view.php'},1000);</script>";
} else {
     // Sweet Alert of Error Message
    $_SESSION['status'] = "Faculty Deletion Failed";
        $_SESSION['status_code'] = "error";

        echo "<script>setTimeout(function(){window.location='program_outcome_view.php'},1000);</script>";
}
}
?>