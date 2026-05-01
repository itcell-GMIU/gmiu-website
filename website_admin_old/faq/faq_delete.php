<?php
include '../include/checklogin.php';

// GET faculty id from display table
if (isset($_GET['faq_id']) && !empty($_GET['faq_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['faq_id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='faq_view.php'},1000)</script>";
    }
    $stmt = $con->prepare("UPDATE `tbl_faq_management` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    if ($result) {
        $_SESSION['status'] = " FAQ Visit Delete Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='faq_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = " FAQ Visit Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='faq_view.php'},1000);</script>";
    }
}
