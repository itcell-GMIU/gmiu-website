<?php
include '../include/checklogin.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='circular_view.php'},1000)</script>";
    }
  
    $status = 0;
    // Get file names from tbl_site_photos
    $cmd = $con->prepare("SELECT clr.file_name as file_name FROM `tbl_circular` as clr WHERE  clr.id = ?");
    $cmd->bind_param("i", $id);
    $cmd->execute();
    $result2 = $cmd->get_result();

    while ($row = $result2->fetch_assoc()) {
        $file_name = $row['file_name'];
        $path = '../uploads/circular/';
        // Delete file from directory
        if (delete_file($file_name, $path)) {
            // Delete tbl_site_photos records
            $stmt = $con->prepare("DELETE FROM `tbl_circular` WHERE id = ?");
            $stmt->bind_param("i", $id);
            $file_delete = $stmt->execute();

            if ($file_delete) {
                $_SESSION['status'] = "Circular Delete Successfully";
                $_SESSION['status_code'] = "success";

                echo "<script>setTimeout(function(){window.location='circular_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Circular Deletion Failed";
                $_SESSION['status_code'] = "error";

                echo "<script>setTimeout(function(){window.location='circular_view.php'},1000);</script>";
            }
        } else {
            $_SESSION['status'] = "Circular Deletion Failed";
            $_SESSION['status_code'] = "error";

            echo "<script>setTimeout(function(){window.location='circular_view.php'},1000);</script>";
        }
    }
}
?>