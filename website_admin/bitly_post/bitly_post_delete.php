<?php
include '../include/checklogin.php';

$id = mysqli_real_escape_string($con, $_GET['id']);
$stmt = $con->prepare("UPDATE `tbl_bitly_post` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
$stmt->bind_param("i", $id);
$result = $stmt->execute();
if ($result) {

    $_SESSION['status'] = "Bitly Post Delete Successfully";
    $_SESSION['status_code'] = "success";

    echo "<script>setTimeout(function(){window.location='bitly_post_view.php'},1000);</script>";
} else {
    $_SESSION['status'] = "Bitly Post Deletion Failed";
    $_SESSION['status_code'] = "error";

    echo "<script>setTimeout(function(){window.location='bitly_post_view.php'},1000);</script>";
}
