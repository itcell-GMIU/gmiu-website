<?php
include '../include/checklogin.php';

$id = $_GET['id'];
$stmt = $con->prepare("UPDATE `tbl_placement_overview` SET is_delete = 1 WHERE id = ? ");
$stmt->bind_param("i", $id);
$result = $stmt->execute();
if ($result) {
    $_SESSION['status'] = "Placement Overview Deleted Successfully";
        $_SESSION['status_code'] = "success";

        echo "<script>setTimeout(function(){window.location='placement_overview_view.php'},1000);</script>";
} else {
    $_SESSION['status'] = "Placement Overview Failed";
        $_SESSION['status_code'] = "error";

        echo "<script>setTimeout(function(){window.location='placement_overview_view.php'},1000);</script>";
}
