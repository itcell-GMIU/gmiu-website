<?php
include '../include/checklogin.php';

// GET faculty id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='training_and_placement_view.php'},1000)</script>";
    }

$stmt = $con->prepare("UPDATE `tbl_tpa_coordinator` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
$stmt->bind_param("i", $id);
$result = $stmt->execute();

if ($result) {
    $status = 1;
    $cmd = $con->prepare("SELECT training.img_name as img_name FROM tbl_tpa_coordinator as training WHERE training.is_delete = ? and training.id = ?");
    $cmd->bind_param("ii", $status, $id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $fetchedImgName = $row['img_name'];
            $path = '../uploads/training_and_placement/';
            // Delete file from directory
            if (delete_file($fetchedImgName, $path)) {
                $_SESSION['status'] = "Training and Placement Deleted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='training_and_placement_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Training and Placement Deletion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='training_and_placement_view.php'},1000);</script>";
            }
        }
    } else {
        $_SESSION['status'] = "Training and Placement Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='training_and_placement_view.php'},1000);</script>";
    }
}
}
else
{
    $_SESSION['status'] = "Invalid ID";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='training_and_placement_view.php'},1000)</script>";
}
?>
