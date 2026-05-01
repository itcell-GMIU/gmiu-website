<?php
include '../include/checklogin.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $id = only_digits($id); // Function to ensure it's only digits
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='dailytask_view.php'},1000)</script>";
        exit();
    }

    // Mark task as deleted
    $stmt = $con->prepare("UPDATE `tbl_daily_task` SET is_delete = 1, is_active = 0 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    if ($result) {
        // Get file names from tbl_inquiry_photos
        $type = "dailytask_add";
        $cmd = $con->prepare("SELECT photos.file_name FROM `tbl_inquiry_photos` AS photos 
                              WHERE photos.type = ? AND photos.type_id = ?");
        $cmd->bind_param("si", $type, $id);
        $cmd->execute();
        $result2 = $cmd->get_result();

        while ($row = $result2->fetch_assoc()) {
            $file_name = $row['file_name'];
            $path = '../uploads/task_images/';

            // Delete file from directory
            if (delete_file($file_name, $path)) {
                // Delete records from tbl_inquiry_photos
                $stmt = $con->prepare("DELETE FROM `tbl_inquiry_photos` WHERE type_id = ? AND type = ?");
                $stmt->bind_param("is", $id, $type);
                $file_delete = $stmt->execute();

                if ($file_delete) {
                    $_SESSION['status'] = "Task deleted successfully";
                    $_SESSION['status_code'] = "success";
                } else {
                    $_SESSION['status'] = "Task deletion failed";
                    $_SESSION['status_code'] = "error";
                }
            } else {
                $_SESSION['status'] = "Task deletion failed";
                $_SESSION['status_code'] = "error";
            }
        }

        // Redirect after processing
        echo "<script>setTimeout(function(){window.location='dailytask_view.php'}, 1000);</script>";
        exit();
    } else {
        $_SESSION['status'] = "Task deletion failed";
        $_SESSION['status_code'] = "error";
    }
} else {
    $_SESSION['status'] = "Invalid data in URL";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='dailytask_view.php'}, 1000);</script>";
}
?>
