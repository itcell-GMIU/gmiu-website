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
        echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000)</script>"; 
        }
// Prepare and execute the SQL statement to delete a record in the tbl_program_outcome
$stmt = $con->prepare("UPDATE `tbl_std_corner` SET is_delete = 1,is_active = 0 WHERE id = ? ");
$stmt->bind_param("i", $id);
$result = $stmt->execute();
if ($result) {

    $status = 1;
    $cmd = $con->prepare("SELECT  sdt.Syllabus as Syllabus FROM tbl_std_corner as sdt WHERE sdt.is_delete = ? and sdt.id = ?");
    $cmd->bind_param("ii", $status, $id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $Syllabus = $row['Syllabus'];
            $path = '../uploads/Syllabus/';
            // Delete file from directory
            if (delete_file($Syllabus, $path)) {
                $_SESSION['status'] = "Student Corner  Deleted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Student Corner Deletion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000);</script>";
            }
        }
    } else {
        $_SESSION['status'] = "Student Corner Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000);</script>";
    }
    // Sweet Alert of Success Message
}
}
