<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// if submit button is clicked then code performs
if (isset($_POST['submit'])) {

    // Fetch data from edit form
    $staff_id = mysqli_real_escape_string($con, $_POST['staff_id']);
    $role_id2= mysqli_real_escape_string($con, $_POST['role_id']);
   
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
 
   
    // Validate Data
    $staff_id = validate_data($staff_id);
    $role_id2 = validate_data($role_id2);
    $email = validate_data($email);
    $password = validate_data($password);
    // This code performs if user don't change image when update data

    $stmt = $con->prepare("UPDATE `tbl_staff` SET `role_id`=?,`email`=?,`password`=? WHERE id = ?");
    $stmt->bind_param("issi", $role_id2, $email, $password, $staff_id);
    $result = $stmt->execute();

    //Sweet Alert of Success Message
    $_SESSION['status'] = "Assign Role Updated Successfully";
    $_SESSION['status_code'] = "success";
    echo "<script>setTimeout(function(){window.location='assign_faculty_view.php'},1000);</script>";
} else {

    //Sweet Alert of Error Message
    $_SESSION['status'] = "Assign Role Update Failed";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='assign_faculty_view.php'},1000)</script>";
}
