<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    
    // First get the image path
    $query = "SELECT image FROM tbl_admission_merit WHERE id = ?";
    
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        // Delete image file
        $image_path = "../../uploads/ugc/" . $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        // Delete record from database
        $stmt = $con->prepare("UPDATE tbl_admission_merit SET is_delete = '1' WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['status'] = "UGC Deleted Successfully";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Error Deleting Record";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "Record Not Found";
        $_SESSION['status_code'] = "error";
    }
} else {
    $_SESSION['status'] = "Invalid Request";
    $_SESSION['status_code'] = "error";
}

// Redirect back to view page
header("Location: ugc_view.php");
exit();
?>
