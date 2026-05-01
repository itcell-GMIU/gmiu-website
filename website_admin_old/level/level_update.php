<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// if submit button is clicked then code performs
if (isset($_POST['submit'])) {

    // Fetch data from edit form
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $level_name = mysqli_real_escape_string($con, $_POST['level_name']);
    $level_is_active = mysqli_real_escape_string($con, $_POST['level_is_active']);

    // Validate Data
    $level_id = validate_data($level_id);
    $level_name = validate_data($level_name);
    $level_is_active = validate_data($level_is_active);

    // Prepare and execute the SQL statement to update a record in the tbl_level
    $stmt = $con->prepare("UPDATE `tbl_level` SET name=?, is_active = ? WHERE id = ? ");
    $stmt->bind_param("sii",  $level_name,  $level_is_active, $level_id);
    $result = $stmt->execute();
    if ($result) {

        // Sweet Alert of Success Message
        $_SESSION['status'] = "Level Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='level_view.php'},1000);</script>";
    } else {

        // Sweet Alert of Error Message
        $_SESSION['status'] = "Level Updation Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='level_view.php'},1000)</script>";
    }
}
