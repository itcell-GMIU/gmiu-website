<?php
include '../include/checklogin.php';


if (isset($_GET['NSS_id']) && !empty($_GET['NSS_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['NSS_id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='NSS_view.php'},1000)</script>";
    }
$stmt = $con->prepare("UPDATE `tbl_NSS` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
$stmt->bind_param("i", $id);
$result = $stmt->execute();

if ($result) {
    $status = 1;
    $cmd = $con->prepare("SELECT NSS.report_thumbnail as img_name, NSS.report as report FROM tbl_NSS as NSS WHERE NSS.is_delete = ? and NSS.id = ?");
    $cmd->bind_param("ii", $status, $id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $fetchedImgName = $row['img_name'];
            $report = $row['report'];
            $path = '../uploads/NSS/report';
            $path2 = '../uploads/NSS/report_thumbnail';
            delete_file($report, $path);
            // Delete file from directory
            if (delete_file($fetchedImgName, $path2)) {
                $_SESSION['status'] = "NSS Deleted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='NSS_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "NSS Deletion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='NSS_view.php'},1000);</script>";
            }
        }
    } else {
        $_SESSION['status'] = "NSS Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='NSS_view.php'},1000);</script>";
    }
}
}
?>
