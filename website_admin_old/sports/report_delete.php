<?php
include '../include/checklogin.php';


if (isset($_GET['ssports_id']) && !empty($_GET['ssports_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['ssports_id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='report_view.php'},1000)</script>";
    }
$stmt = $con->prepare("UPDATE `tbl_ssports` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
$stmt->bind_param("i", $id);
$result = $stmt->execute();

if ($result) {
    $status = 1;
    $cmd = $con->prepare("SELECT ssports.report_thumbnail as img_name, ssports.report as report FROM tbl_ssports as ssports WHERE ssports.is_delete = ? and ssports.id = ?");
    $cmd->bind_param("ii", $status, $id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $fetchedImgName = $row['img_name'];
            $report = $row['report'];
            $path = '../uploads/ssports/report';
            $path2 = '../uploads/ssports/report_thumbnail';
            delete_file($report, $path);
            // Delete file from directory
            if (delete_file($fetchedImgName, $path2)) {
                $_SESSION['status'] = "sports_report Deleted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='report_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "sports_report Deletion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='report_view.php'},1000);</script>";
            }
        }
    } else {
        $_SESSION['status'] = "sports_report Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='report_view.php'},1000);</script>";
    }
}
}
?>
