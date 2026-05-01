<?php
include '../include/checklogin.php';

if (isset($_GET['nss_unit_id']) && !empty($_GET['nss_unit_id'])) {
    $nss_unit_id = mysqli_real_escape_string($con, $_GET['nss_unit_id']);
    $nss_unit_id = only_digits($nss_unit_id);
    if ($nss_unit_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='about_nss_view.php'},1000)</script>";
    }
    $stmt = $con->prepare("UPDATE `tbl_nss_unit` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
    $stmt->bind_param("i", $nss_unit_id);
    $result = $stmt->execute();


    if ($result) {



        $_SESSION['status'] = " NSS Units Deleted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='nss_unit_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "NSS Units Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='nss_unit_view.php'},1000);</script>";
    }
}
