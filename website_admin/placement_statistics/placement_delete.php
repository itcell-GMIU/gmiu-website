<?php
include '../include/checklogin.php';

$placement_id = $_GET['placement_id'];
$stmt = $con->prepare("UPDATE `tbl_placement` SET is_delete = 1 WHERE id = ? ");
$stmt->bind_param("i", $placement_id);
$result = $stmt->execute();
if ($result) {
    $_SESSION['status'] = "Placement Deleted Successfully";
        $_SESSION['status_code'] = "success";

        echo "<script>setTimeout(function(){window.location='placement_view.php'},1000);</script>";
} else {
    $_SESSION['status'] = "placement Deletion Failed";
        $_SESSION['status_code'] = "error";

        echo "<script>setTimeout(function(){window.location='placement_view.php'},1000);</script>";
}
