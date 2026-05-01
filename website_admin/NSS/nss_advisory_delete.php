<?php
include '../include/checklogin.php';

if (isset($_GET['nss_advisory_id']) && !empty($_GET['nss_advisory_id'])) {
    $nss_advisory_id = mysqli_real_escape_string($con, $_GET['nss_advisory_id']);
    $nss_advisory_id = only_digits($nss_advisory_id);
    if ($nss_advisory_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='about_advisory_view.php'},1000)</script>";
    }
    $stmt = $con->prepare("UPDATE `tbl_nss_advisory` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
    $stmt->bind_param("i", $nss_advisory_id);
    $result = $stmt->execute();


    if ($result) {



        $_SESSION['status'] = " Advisory Committe Deleted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='nss_advisory_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Advisory Committe Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='nss_advisory_view.php'},1000);</script>";
    }
}
