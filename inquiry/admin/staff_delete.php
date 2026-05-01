<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// GET faculty id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $staff_id = mysqli_real_escape_string($con, $_GET['id']);
    $staff_id = only_digits($staff_id);
    if ($staff_id == false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='staff_view.php'},1000)</script>";
    }


        
            $stmt = $con->prepare(" UPDATE `tbl_staff` SET is_delete = 1, is_active = 0  WHERE id = ?");
            $stmt->bind_param("i", $staff_id);
            $result = $stmt->execute();

            if ($result) {

                // Sweet Alert of Success Message
                $_SESSION['status'] = "Faculty Details Deleted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='staff_view.php'},1000);</script>";
            } else {

                // Sweet Alert of Error Message
                $_SESSION['status'] = "Faculty Details Deletion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='staff_view.php'},1000);</script>";
            }
        
    
}
