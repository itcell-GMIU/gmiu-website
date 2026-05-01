<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_GET['laboratories_id']) && !empty($_GET['laboratories_id'])) {

    $id = mysqli_real_escape_string($con, $_GET['laboratories_id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='laboratories_view.php'},1000)</script>"; 
        } // Get the value of 'laboratories_id' from the URL parameter

        $stmt = $con->prepare("UPDATE `tbl_laboratories` SET is_delete = 1 WHERE id = ? "); // Prepare the update statement
$stmt->bind_param("i", $id); // Bind the parameter for the prepared statement
$result = $stmt->execute(); // Execute the prepared statement

if ($result) {
    $_SESSION['status'] = "Laboratory Deleted Successfully";
    $_SESSION['status_code'] = "success";
    echo "<script>setTimeout(function(){window.location='laboratories_view.php'},1000);</script>";
} else {
    $_SESSION['status'] = "Laboratory Deletion Failed";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='laboratories_view.php'},1000);</script>";
}
}
?>
