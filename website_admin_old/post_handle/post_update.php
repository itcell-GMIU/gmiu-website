<?php
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $url = mysqli_real_escape_string($con, $_POST['url']);
    $alt_text = mysqli_real_escape_string($con, $_POST['alt_text']);

    $stmt = $con->prepare("UPDATE `tbl_website_post` SET 'type' = ? 'url' = ?   'alt_text' = ? WHERE id = ?");
    $stmt->bind_param(types: "si", $alt_text, $id);
    $result = $stmt->execute();
}

if ($result) {
    $_SESSION['status'] = "Post Updated Successfully";
    $_SESSION['status_code'] = "success";
} else {
    $_SESSION['status'] = "Post Update Failed";
    $_SESSION['status_code'] = "error";
}
header("Location: post_view.php");
exit;

?>