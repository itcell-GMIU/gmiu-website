<?php
include './validation.php';
include './function.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

        $stmt = $con->prepare("UPDATE `tbl_competetion` SET is_active = 0 WHERE id = ?");
        $stmt->bind_param("i", $brochure_id);
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['status'] = "Deleted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='brochure_view.php'},1000);</script>";
            exit; // Terminate the script execution
        } else {
            $_SESSION['status'] = "Deletion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='brochure_view.php'},1000);</script>";
            exit; // Terminate the script execution
        }
}

?>
