<?php
include '../include/checklogin.php';


if (isset($_GET['sdp_id']) && !empty($_GET['sdp_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['sdp_id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='sdp_view.php'},1000)</script>";
    }
$stmt = $con->prepare("UPDATE `tbl_sdp` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
$stmt->bind_param("i", $id);
$result = $stmt->execute();

if ($result) {
    $status = 1;
    $cmd = $con->prepare("SELECT sdp.img_name as img_name, sdp.report as report FROM tbl_sdp as sdp WHERE sdp.is_delete = ? and sdp.id = ?");
    $cmd->bind_param("ii", $status, $id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $fetchedImgName = $row['img_name'];
            $report = $row['report'];
            $path = '../uploads/sdp/image/';
            $path2 = '../uploads/sdp/report/';
            delete_file($report, $path2);
            // Delete file from directory
            if (delete_file($fetchedImgName, $path)) {
                $_SESSION['status'] = "SDP Deleted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='sdp_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "SDP Deletion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='sdp_view.php'},1000);</script>";
            }
        }
    } else {
        $_SESSION['status'] = "SDP Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='sdp_view.php'},1000);</script>";
    }
}
}
?>
