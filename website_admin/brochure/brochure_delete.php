<?php
include '../include/checklogin.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $brochure_id = mysqli_real_escape_string($con, $_GET['id']);
    $brochure_id = only_digits($brochure_id);
    if ($brochure_id == false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='brochure_view.php'},1000)</script>";
        exit; // Terminate the script execution
    }

    $stmt = $con->prepare("SELECT thumbnail, document FROM `tbl_brochure` WHERE id = ?");
    $stmt->bind_param("i", $brochure_id);
    $result = $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $thumbnail = $row['thumbnail'];
            $document = $row['document'];
        }

        $path = '../uploads/brochure/thumbnail/';
        $path2 = '../uploads/brochure/document/';

        if (delete_file($thumbnail, $path) && delete_file($document, $path2)) {
            $stmt = $con->prepare("UPDATE `tbl_brochure` SET is_delete = 1, is_active = 0 WHERE id = ?");
            $stmt->bind_param("i", $brochure_id);
            $result = $stmt->execute();

            if ($result) {
                $_SESSION['status'] = "E-Brochure is Deleted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='brochure_view.php'},1000);</script>";
                exit; // Terminate the script execution
            } else {
                $_SESSION['status'] = "E-Brochure Deletion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='brochure_view.php'},1000);</script>";
                exit; // Terminate the script execution
            }
        }
    }
}
?>
