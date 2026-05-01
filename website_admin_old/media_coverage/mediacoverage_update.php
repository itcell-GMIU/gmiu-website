<?php
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $alt_text = mysqli_real_escape_string($con, $_POST['alt_text']);
    $faculty = mysqli_real_escape_string($con, $_POST['faculty']);
    $level = mysqli_real_escape_string($con, $_POST['level']);
    $program = mysqli_real_escape_string($con, $_POST['program']);
    $is_common = mysqli_real_escape_string($con, $_POST['is_common']);
    $is_common = isset($is_common) && $is_common ? 1 : 0;
    $video_link = mysqli_real_escape_string($con, $_POST['videolink']);

    $stmt = $con->prepare("UPDATE `tbl_media_coverage` SET  alt_text = ?, file = ?, faculty_id = ?, level_id = ?, program_id = ?, is_common_reel = ?  WHERE id = ?");
    $stmt->bind_param("ssissii", $alt_text, $video_link, $faculty, $level, $program, $is_common, $id);
    $result = $stmt->execute();
}

if ($result) {
    $_SESSION['status'] = "Media Coverage Updated Successfully";
    $_SESSION['status_code'] = "success";
} else {
    $_SESSION['status'] = "Media Coverage Update Failed";
    $_SESSION['status_code'] = "error";
}
header("Location: mediacoverage_view.php");
exit;

?>