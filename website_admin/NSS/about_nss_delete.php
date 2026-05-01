<?php
include '../include/checklogin.php';

if (isset($_GET['nss_about_id']) && !empty($_GET['nss_about_id'])) {
    $nss_about_id = mysqli_real_escape_string($con, $_GET['nss_about_id']);
    $nss_about_id = only_digits($nss_about_id);
    if ($nss_about_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='about_nss_view.php'},1000)</script>";
    }
    $stmt = $con->prepare("UPDATE `tbl_nss_about` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
    $stmt->bind_param("i", $nss_about_id);
    $result = $stmt->execute();


    if ($result) {



        $_SESSION['status'] = "About NSS Deleted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='about_nss_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "About NSS Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='about_nss_view.php'},1000);</script>";
    }
}
