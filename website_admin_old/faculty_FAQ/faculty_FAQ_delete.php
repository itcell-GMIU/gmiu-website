<?php
include '../include/checklogin.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $FAQ_id = mysqli_real_escape_string($con, $_GET['id']);
    $FAQ_id = only_digits($FAQ_id);
    if ($FAQ_id == false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='faculty_FAQ_view.php'},1000)</script>";
        exit; // Terminate the script execution
    }

    $stmt = $con->prepare("SELECT document FROM `tbl_faculty_FAQ` WHERE id = ?");
    $stmt->bind_param("i", $FAQ_id);
    $result = $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // $faculty_id = $row['faculty_id'];
            // $level_id = $row['level_id'];
            $document = $row['document'];
        }

        $path2 = '../uploads/faculty_FAQ/document/';

        if (delete_file($document, $path2)) {
            $stmt = $con->prepare("UPDATE `tbl_faculty_faq` SET is_delete = 1, is_active = 0 WHERE id = ?");
            $stmt->bind_param("i", $FAQ_id);
            $result = $stmt->execute();

            if ($result) {
                $_SESSION['status'] = "FAQ is Deleted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='faculty_FAQ_view.php'},1000);</script>";
                exit; // Terminate the script execution
            } else {
                $_SESSION['status'] = "FAQ Deletion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='faculty_FAQ_view.php'},1000);</script>";
                exit; // Terminate the script execution
            }
        }
    }
}
?>
