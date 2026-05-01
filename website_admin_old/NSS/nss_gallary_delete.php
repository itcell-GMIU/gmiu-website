<?php
include '../include/checklogin.php';

// GET the expert talk ID from the URL
if (isset($_GET['NSS_id']) && !empty($_GET['NSS_id'])) {
  $startup_id = $_GET['NSS_id'];
  
  // Validate the ID to ensure it only contains digits
  if (!ctype_digit($startup_id)) {
    $_SESSION['status'] = "Invalid data in URL";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='nss-gallary_view.php'}, 1000)</script>";
    exit(); // Exit the script to prevent further execution
  }
  
  // Prepare and execute the UPDATE statement
  $stmt = $con->prepare("UPDATE `tbl_nss_gallary` SET is_delete = 1, is_active = 0 WHERE id = ?");
  $stmt->bind_param("i", $startup_id);
  $result = $stmt->execute();
  
  if ($result) {
    // Get file names from tbl_nss_gallary
    $cmd = $con->prepare("SELECT photos.file_name FROM `tbl_nss_gallary` photos WHERE photos.id = ?");
    $cmd->bind_param("i", $startup_id);
    $cmd->execute();
    $result2 = $cmd->get_result();
    
    while ($row = $result2->fetch_assoc()) {
      $file_name = $row['file_name'];
      $path = '../uploads/nss_gallary/image/';
  
      // Delete file from directory
      if (delete_file($file_name, $path)) {
        // Delete tbl_nss_gallary records
        $_SESSION['status'] = "Our NSS Post Deleted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='nss-gallary_view.php'},1000);</script>";
        exit(); // Exit the script after redirecting

      } else {
        $_SESSION['status'] = "File deletion failed";
        $_SESSION['status_code'] = "error";
      }
    }
  } else {
    $_SESSION['status'] = "Our NSS Post deletion failed";
    $_SESSION['status_code'] = "error";
  }
} else {
  $_SESSION['status'] = "Invalid data in URL";
  $_SESSION['status_code'] = "error";
  echo "<script>setTimeout(function(){window.location='nss-gallary_view.php'}, 1000);</script>";
  exit(); // Exit the script after redirecting
}
?>
