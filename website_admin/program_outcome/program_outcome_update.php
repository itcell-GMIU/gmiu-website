<?php
// Include the checklogin.php file
include '../include/checklogin.php';



if ($role_id == 8) {
    if (isset($_POST['submit'])) {

        // Fetch data from edit form
        $id = $_POST['id'];
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $program_description = $_POST['program_description'];
        $program_status = $_POST['program_status'];
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);

        // Validate Data
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);
        $program_id = validate_data($program_id);
        $title = validate_data($title);
        // $program_description = validate_data($program_description);

        // Prepare and execute the SQL statement to update a record in the tbl_program_outcome
        $stmt = $con->prepare("UPDATE `tbl_program_outcome` SET `faculty_id`=?, `level_id`=?, `program_id`=?,`title`=?,`content`=?,`is_active`=? WHERE id = ?");
        $stmt->bind_param("iiissii", $faculty_id, $level_id, $program_id, $title, $program_description, $program_status, $id);
        $result = $stmt->execute();
        if ($result) {
            //Sweet Alert of Success Message
            $_SESSION['status'] = "Program Outcome Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='program_outcome_view.php'},1000);</script>";
        } else {
            //Sweet Alert of Error Message
            $_SESSION['status'] = "Program Outcome Updation Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='program_outcome_view.php'},1000)</script>";
        }
    }
} else {
    // if submit button is clicked then code performs
    if (isset($_POST['submit'])) {

        // Fetch data from edit form
        $id = $_POST['id'];
        $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        $program_ids = $_POST['program_id'];
        $title = mysqli_real_escape_string($con, $_POST['title']);
        // $short_description = $_POST['short_description'];
        $program_description = $_POST['program_description'];
        $program_status = $_POST['program_status'];

        // Validate Data
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);
        $title = validate_data($title);

        $program_id_str = implode(',', array_map('intval', $program_ids));
        // $program_description = validate_data($program_description);

        // Prepare and execute the SQL statement to update a record in the tbl_program_outcome
        $stmt = $con->prepare("UPDATE `tbl_program_outcome` SET `faculty_id`=?, `level_id`=?, `program_id`=?,`title`=?,`content`=?,`is_active`=? WHERE id = ?");
        $stmt->bind_param("iisssii", $faculty_id, $level_id, $program_id_str, $title, $program_description, $program_status, $id);
        $result = $stmt->execute();
        if ($result) {
            //Sweet Alert of Success Message
            $_SESSION['status'] = "Program Outcome Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='program_outcome_view.php'},1000);</script>";
        } else {
            //Sweet Alert of Error Message
            $_SESSION['status'] = "Program Outcome Updation Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='program_outcome_view.php'},1000)</script>";
        }
    }
}
