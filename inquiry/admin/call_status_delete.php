<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// GET faculty id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = mysqli_real_escape_string($con, $_GET['id']);
    $id = only_digits($id);
    if ($staff_id == false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='call_status_view.php'},1000)</script>";
    }


        
            $stmt = $con->prepare("DELETE FROM `tbl_call_status` WHERE id = ?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();

            if ($result) {

                // Sweet Alert of Success Message
                $_SESSION['status'] = "Faculty Details Deleted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='call_status_view.php'},1000);</script>";
            } else {

                // Sweet Alert of Error Message
                $_SESSION['status'] = "Faculty Details Deletion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='call_status_view.php'},1000);</script>";
            }
        
    
}
