<?php
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
    $id =  mysqli_real_escape_string($con, $_POST['id']);    // Fetch data from HTML Form
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $sem = mysqli_real_escape_string($con, $_POST['sem']);
    $subject_code = mysqli_real_escape_string($con, $_POST['subject_code']);
    $subject_name = mysqli_real_escape_string($con, $_POST['subject_name']);

    // Validate Data
    $faculty_id = validate_data($faculty_id);
    $level_id = validate_data($level_id);
    $program_id = validate_data($program_id);

    // Check if subject code already exists (excluding the current record)
    // $stmt = $con->prepare("SELECT id FROM `tbl_std_corner_exam` WHERE subject_code = ? AND id != ? And is_delete = '0' ");
    // $stmt->bind_param("si", $subject_code, $id);
    // Check if subject code already exists (excluding the current record and matching faculty, level, and program)
    $stmt = $con->prepare("SELECT id FROM tbl_std_corner_exam WHERE subject_code = ? AND id != ? AND faculty_id = ? AND level_id = ? AND program_id = ? AND is_delete = '0'");
    $stmt->bind_param("siiii", $subject_code, $id, $faculty_id, $level_id, $program_id);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Subject code already exists, set error message
        $_SESSION['status'] = "Subject Code already exists!";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='subject_view.php'},1000);</script>";
    } else {
        // Proceed with the update
        $stmt = $con->prepare("UPDATE `tbl_std_corner_exam` SET `faculty_id`=?, `level_id`=?, `program_id`=?, `sem`=?, `subject_code`=?, `subject_name`=? WHERE id = ?");
        $stmt->bind_param("iiiissi", $faculty_id, $level_id, $program_id, $sem, $subject_code, $subject_name, $id);
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['status'] = "Subject Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='subject_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Subject Update Failed: " . $stmt->error;
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='subject_view.php'},1000);</script>";
        }
    }
    $stmt->close();
}
?>
