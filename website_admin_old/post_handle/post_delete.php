<?php
include '../include/checklogin.php';

// GET post id from display table
if (isset($_GET['post_id']) && !empty($_GET['post_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['post_id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='post_view.php'},1000)</script>";
        exit;
    }
}

// Get type of the post
$cmd = $con->prepare("SELECT file_type FROM `tbl_post` WHERE id = ?");
$cmd->bind_param("i", $id);
$cmd->execute();
$type = $cmd->get_result();
$file_type = "";
while ($row = $type->fetch_assoc()) {
    $file_type = $row['file_type'];
}

// Delete post record
$stmt = $con->prepare("DELETE FROM `tbl_post` WHERE id = ?");
$stmt->bind_param("i", $id);
$result = $stmt->execute();

if ($file_type == "video") {
    if ($result) {
        $_SESSION['status'] = "Post deleted successfully";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Post deletion failed";
        $_SESSION['status_code'] = "error";
    }
    echo "<script>setTimeout(function(){window.location='post_view.php'},1000);</script>";
} elseif ($file_type == "image") {
    if ($result) {
        $type = "post";
        // Get file names from tbl_site_photos
        $cmd = $con->prepare("SELECT file_name FROM `tbl_site_photos` WHERE type = ? AND type_id = ?");
        $cmd->bind_param("si", $type, $id);
        $cmd->execute();
        $result2 = $cmd->get_result();

        while ($row = $result2->fetch_assoc()) {
            $file_name = $row['file_name'];
            $path = '../uploads/posts/';

            // Delete file from directory
            if (delete_file($file_name, $path)) {
                // Delete related records from tbl_site_photos
                $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE type_id = ? AND type = ?");
                $stmt->bind_param("is", $id, $type);
                $file_delete = $stmt->execute();

                if ($file_delete) {
                    $_SESSION['status'] = "Post deleted successfully";
                    $_SESSION['status_code'] = "success";
                } else {
                    $_SESSION['status'] = "Failed to delete post records";
                    $_SESSION['status_code'] = "error";
                }
            } else {
                $_SESSION['status'] = "Failed to delete post file";
                $_SESSION['status_code'] = "error";
            }
        }
    }
    echo "<script>setTimeout(function(){window.location='post_view.php'},1000);</script>";
}
?>