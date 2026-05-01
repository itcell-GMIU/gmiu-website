<?php
include '../include/checklogin.php';

if (isset($_GET['about_startup_id']) && !empty($_GET['about_startup_id'])) {
    $about_startup_id = mysqli_real_escape_string($con, $_GET['about_startup_id']);
    $about_startup_id = only_digits($about_startup_id);
    if ($about_startup_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='about_startup_view.php'},1000)</script>";
    }
    $stmt = $con->prepare("UPDATE `tbl_about_startup` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
    $stmt->bind_param("i", $about_startup_id);
    $result = $stmt->execute();


    if ($result) {



        $_SESSION['status'] = "About Startup Deleted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='about_startup_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "About Startup Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='about_startup_view.php'},1000);</script>";
    }
}
