<?php
include '../include/checklogin.php';

if (isset($_GET['nss_contact_us_id']) && !empty($_GET['nss_contact_us_id'])) {
    $nss_contact_us_id = mysqli_real_escape_string($con, $_GET['nss_contact_us_id']);
    $nss_contact_us_id = only_digits($nss_contact_us_id);
    if ($nss_contact_us_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='nss_contact_us_view.php'},1000)</script>";
    }
    $stmt = $con->prepare("UPDATE `tbl_nss_contact_us` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
    $stmt->bind_param("i", $nss_contact_us_id);
    $result = $stmt->execute();


    if ($result) {



        $_SESSION['status'] = " Contact Us Deleted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='nss_contact_us_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Contact Us Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='nss_contact_us_view.php'},1000);</script>";
    }
}
