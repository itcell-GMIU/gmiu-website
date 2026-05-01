<?php
include '../include/checklogin.php';

// GET the expert talk ID from the URL
if (isset($_GET['startup_id']) && !empty($_GET['startup_id'])) {
  $startup_id = $_GET['startup_id'];
  
  // Validate the ID to ensure it only contains digits
  if (!ctype_digit($startup_id)) {
    $_SESSION['status'] = "Invalid data in URL";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='our_startup_view.php'}, 1000)</script>";
    exit(); // Exit the script to prevent further execution
  }
  
  // Prepare and execute the UPDATE statement
  $stmt = $con->prepare("UPDATE `tbl_our_startup` SET is_delete = 1, is_active = 0 WHERE id = ?");
  $stmt->bind_param("i", $startup_id);
  $result = $stmt->execute();
  
  if ($result) {
    $type = "startup";
  
    // Get file names from tbl_site_photos
    $cmd = $con->prepare("SELECT photos.file_name FROM `tbl_site_photos` AS photos INNER JOIN `tbl_our_startup` AS startup ON photos.type_id = startup.id WHERE photos.type = ? AND photos.type_id = ?");
    $cmd->bind_param("ss", $type,$startup_id);
    $cmd->execute();
    $result2 = $cmd->get_result();
  
    while ($row = $result2->fetch_assoc()) {
      $file_name = $row['file_name'];
      $path = '../uploads/our_startup/image/';
  
      // Delete file from directory
      if (delete_file($file_name, $path)) {
        // Delete tbl_site_photos records
      
        $_SESSION['status'] = "Our Startup Delete Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='our_startup_view.php'},1000);</script>";

      } else {
        $_SESSION['status'] = "Our startup deletion failed";
        $_SESSION['status_code'] = "error";
      }
    }

    // Redirect to expert talk view page after processing
    echo "<script>setTimeout(function(){window.location='our_startup_view.php'}, 1000);</script>";
    exit(); // Exit the script after redirecting
  } else {
    $_SESSION['status'] = "Our startup deletion failed";
    $_SESSION['status_code'] = "error";
  }
} else {
  $_SESSION['status'] = "Invalid data in URL";
  $_SESSION['status_code'] = "error";
  echo "<script>setTimeout(function(){window.location='our_startup_view.php'}, 1000);</script>";
}
?>
