<?php
include '../include/checklogin.php';
if (isset($_GET['tt_id']) && !empty($_GET['tt_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['tt_id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='timetable_view.php'},1000)</script>";
    }
$stmt = $con->prepare("UPDATE `tbl_timetable` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
$stmt->bind_param("i", $id);
$result = $stmt->execute();
if ($result) {

    $status = 1;
    $cmd = $con->prepare("SELECT  tt.img_name as img_name  FROM tbl_timetable as tt WHERE tt.is_delete = ? and tt.id = ?");
    $cmd->bind_param("ii", $status, $id);
    $cmd->execute();
    $result = $cmd->get_result();
    while ($row = $result->fetch_assoc()) {
        $img_name = $row['img_name'];
        $path = '../uploads/timetable/';
        // Delete file from directory
        if (delete_file($img_name, $path)) {
            $_SESSION['status'] = "Time Table Delete Successfully";
    $_SESSION['status_code'] = "success";
    echo "<script>setTimeout(function(){window.location='timetable_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Time Table Deletion Failed";
    $_SESSION['status_code'] = "error";

    echo "<script>setTimeout(function(){window.location='timetable_view.php'},1000);</script>";
        }
    }
} else {
    $_SESSION['status'] = "Time Table Deletion Failed";
    $_SESSION['status_code'] = "error";

    echo "<script>setTimeout(function(){window.location='timetable_view.php'},1000);</script>";
}
}
?>
















   