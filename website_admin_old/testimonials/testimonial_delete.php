<?php
include '../include/checklogin.php';

$id = $_GET['testimonial_id'];
$stmt = $con->prepare("UPDATE `tbl_testimonial` SET is_delete = 1 WHERE id = ? ");
$stmt->bind_param("i", $id);
$result = $stmt->execute();
if ($result) {

    $_SESSION['status'] = "Daily Post Delete Successfully";
    $_SESSION['status_code'] = "success";

    echo "<script>setTimeout(function(){window.location='testimonial_view.php'},1000);</script>";
} else {
    $_SESSION['status'] = "Daily Post Deletion Failed";
    $_SESSION['status_code'] = "error";

    echo "<script>setTimeout(function(){window.location='testimonial_view.php'},1000);</script>";
}
