<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// if submit button is clicked then code performs
if (isset($_POST['submit'])) {

    // Fetch data from edit form
    $staff_id = mysqli_real_escape_string($con, $_POST['staff_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Validate Data
    $staff_id = validate_data($staff_id);
    $name = validate_data($name);
    $mobile_number = validate_data($mobile_number);
    $email = validate_data($email);


    $stmt = $con->prepare("UPDATE `tbl_staff` SET  `name`=?,`mobile_number`=?,`email`=? ,`password`=?  WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $mobile_number, $email, $password, $staff_id);
    $result = $stmt->execute();

    if ($result) {
        //Sweet Alert of Success Message
        $_SESSION['status'] = "Faculty Details Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='staff_view.php'},1000);</script>";
    } else {

        //Sweet Alert of Error Message
        $_SESSION['status'] = "Faculty Details Update Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='staff_view.php'},1000)</script>";
    }
}
