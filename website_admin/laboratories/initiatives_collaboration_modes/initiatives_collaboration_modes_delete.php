<?php
include '../include/checklogin.php';
if (isset($_GET['ic_id']) && !empty($_GET['ic_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['ic_id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>seicimeout(function(){window.location='initiatives_collaboration_modes_view.php'},1000)</script>";
    }
$stmt = $con->prepare("UPDATE `tbl_international_cell` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
$stmt->bind_param("i", $id);
$result = $stmt->execute();
if ($result) {

    $status = 1;
    $cmd = $con->prepare("SELECT  ic.img_name as img_name  FROM tbl_international_cell as ic WHERE ic.is_delete = ? and ic.id = ?");
    $cmd->bind_param("ii", $status, $id);
    $cmd->execute();
    $result = $cmd->get_result();
    while ($row = $result->fetch_assoc()) {
        $img_name = $row['img_name'];
        $path = '../uploads/international_cell/';
        // Delete file from directory
        if (delete_file($img_name, $path)) {
            $_SESSION['status'] = "internation cell Delete Successfully";
    $_SESSION['status_code'] = "success";
    echo "<script>setTimeout(function(){window.location='initiatives_collaboration_modes_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "internation cell Deletion Failed";
    $_SESSION['status_code'] = "error";

    echo "<script>setTimeout(function(){window.location='initiatives_collaboration_modes_view.php'},1000);</script>";
        }
    }
} else {
    $_SESSION['status'] = "internation cell Deletion Failed";
    $_SESSION['status_code'] = "error";

    echo "<script>setTimeout(function(){window.location='initiatives_collaboration_modes_view.php'},1000);</script>";
}
}
?>
















   