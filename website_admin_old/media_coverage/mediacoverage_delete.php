<?php
include '../include/checklogin.php';

$id = mysqli_real_escape_string($con, $_GET['mediacoverage_id']);
$stmt = $con->prepare("UPDATE `tbl_media_coverage` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
$stmt->bind_param("i", $id);
$result = $stmt->execute();
if ($result) {

    $_SESSION['status'] = "Media Coverage Delete Successfully";
    $_SESSION['status_code'] = "success";

    echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000);</script>";
} else {
    $_SESSION['status'] = "Media Coverage Deletion Failed";
    $_SESSION['status_code'] = "error";

    echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000);</script>";
}
