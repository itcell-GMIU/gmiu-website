<?php
include '../include/checklogin.php';
if (isset($_GET['mm_id']) && !empty($_GET['mm_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['mm_id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='advance_laboratories_view.php'},1000)</script>";
    }
$stmt = $con->prepare("UPDATE `tbl_campus` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
$stmt->bind_param("i", $id);
$result = $stmt->execute();
if ($result) {
    $type = "advance_laboratories";
  
    // Get file names from tbl_site_photos
    $cmd = $con->prepare("SELECT photos.file_name FROM `tbl_site_photos` AS photos INNER JOIN `tbl_campus` AS mm 
    ON photos.type_id = mm.id WHERE photos.type = ? AND photos.type_id = ?");
    $cmd->bind_param("si", $type, $id);
    $cmd->execute();
    $result2 = $cmd->get_result();
  
    while ($row = $result2->fetch_assoc()) {
      $file_name = $row['file_name'];
     
      $path = '../uploads/advance_laboratories/';
  
      // Delete file from directory
      if (delete_file($file_name, $path)) {
        // Delete tbl_site_photos records
        $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE type_id = ? AND type = ?");
        $stmt->bind_param("is", $id, $type);
        $file_delete = $stmt->execute();
  
        if ($file_delete) {
          $_SESSION['status'] = "Advance Laboratories Activity is deleted successfully";
          $_SESSION['status_code'] = "success";
          
          // Delete the report file if it exists
          if (!empty($report_name)) {
            $report_path = '../uploads/advance_laboratories/';
            if (delete_file($report_name, $report_path)) {
             
            }
          }
        } else {
          $_SESSION['status'] = "Advance Laboratories Activity deletion failed";
          $_SESSION['status_code'] = "error";
        }
      } else {
        $_SESSION['status'] = "Advance Laboratories Activity deletion failed";
        $_SESSION['status_code'] = "error";
      }
    }

    // Redirect to advance_laboratories Activity view page after processing
    echo "<script>setTimeout(function(){window.location='advance_laboratories_view.php'}, 1000);</script>";
    exit(); // Exit the script after redirecting
  } else {
    $_SESSION['status'] = "Advance Laboratories Activity deletion failed";
    $_SESSION['status_code'] = "error";
  }
} else {
  $_SESSION['status'] = "Invalid data in URL";
  $_SESSION['status_code'] = "error";
  echo "<script>setTimeout(function(){window.location='advance_laboratories_view.php'}, 1000);</script>";
}
?>