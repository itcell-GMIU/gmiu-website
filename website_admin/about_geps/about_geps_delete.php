<?php
include '../include/checklogin.php';
if (isset($_GET['geps_id']) && !empty($_GET['geps_id'])) {
    $geps_id = mysqli_real_escape_string($con, $_GET['geps_id']);
    $geps_id = only_digits($geps_id);
    if ($geps_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='about_geps_view.php'},1000)</script>";
    }
$stmt = $con->prepare("UPDATE `tbl_site_photos` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
$stmt->bind_param("i",$geps_id);
$result = $stmt->execute();
if ($result) {

    $status = 1;
    $cmd = $con->prepare("SELECT geps.file_type as file_type,geps.file_name as file_name  FROM tbl_site_photos as geps WHERE geps.is_delete = ? and geps.id = ?");
    $cmd->bind_param("ii", $status, $geps_id);
    $cmd->execute();
    $result = $cmd->get_result();
    while ($row = $result->fetch_assoc()) {
        $file_name = $row['file_name'];
        $path = '../uploads/geps/image/';
        // Delete file from directory
        if (delete_file($file_name, $path)) {
            $_SESSION['status'] = "GEPS Delete Successfully";
    $_SESSION['status_code'] = "success";
    echo "<script>setTimeout(function(){window.location='about_geps_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "GEPS Deletion Failed";
    $_SESSION['status_code'] = "error";

    echo "<script>setTimeout(function(){window.location='about_geps_view.php'},1000);</script>";
        }
    }
} else {
    $_SESSION['status'] = "GEPS Deletion Failed";
    $_SESSION['status_code'] = "error";

    echo "<script>setTimeout(function(){window.location='about_geps_view.php'},1000);</script>";
}
}
?>
















   