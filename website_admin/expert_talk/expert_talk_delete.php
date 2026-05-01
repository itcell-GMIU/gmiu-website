<?php
include '../include/checklogin.php';

// GET the expert talk ID from the URL
if (isset($_GET['exp_id']) && !empty($_GET['exp_id'])) {
  $exp_id = $_GET['exp_id'];
  
  // Validate the ID to ensure it only contains digits
  if (!ctype_digit($exp_id)) {
    $_SESSION['status'] = "Invalid data in URL";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='expert_talk_view.php'}, 1000)</script>";
    exit(); // Exit the script to prevent further execution
  }
  
  // Prepare and execute the UPDATE statement
  $stmt = $con->prepare("UPDATE `tbl_expert_talk` SET is_delete = 1, is_active = 0 WHERE id = ?");
  $stmt->bind_param("i", $exp_id);
  $result = $stmt->execute();
  
  if ($result) {
    $type = "expert_talk";
  
    // Get file names from tbl_site_photos
    $cmd = $con->prepare("SELECT photos.file_name, expert_talk.report_file as report FROM `tbl_site_photos` AS photos INNER JOIN `tbl_expert_talk` AS expert_talk ON photos.type_id = expert_talk.id WHERE photos.type = ? AND photos.type_id = ?");
    $cmd->bind_param("si", $type, $exp_id);
    $cmd->execute();
    $result2 = $cmd->get_result();
  
    while ($row = $result2->fetch_assoc()) {
      $file_name = $row['file_name'];
      $report_name = $row['report'];
      $path = '../uploads/expert_talk/image/';
  
      // Delete file from directory
      if (delete_file($file_name, $path)) {
        // Delete tbl_site_photos records
        $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE type_id = ? AND type = ?");
        $stmt->bind_param("is", $exp_id, $type);
        $file_delete = $stmt->execute();
  
        if ($file_delete) {
          $_SESSION['status'] = "Expert Talk is deleted successfully";
          $_SESSION['status_code'] = "success";
          
          // Delete the report file if it exists
          if (!empty($report_name)) {
            $report_path = '../uploads/expert_talk/report/';
            if (delete_file($report_name, $report_path)) {
             
            }
          }
        } else {
          $_SESSION['status'] = "Expert Talk deletion failed";
          $_SESSION['status_code'] = "error";
        }
      } else {
        $_SESSION['status'] = "Expert Talk deletion failed";
        $_SESSION['status_code'] = "error";
      }
    }

    // Redirect to expert talk view page after processing
    echo "<script>setTimeout(function(){window.location='expert_talk_view.php'}, 1000);</script>";
    exit(); // Exit the script after redirecting
  } else {
    $_SESSION['status'] = "Expert Talk deletion failed";
    $_SESSION['status_code'] = "error";
  }
} else {
  $_SESSION['status'] = "Invalid data in URL";
  $_SESSION['status_code'] = "error";
  echo "<script>setTimeout(function(){window.location='expert_talk_view.php'}, 1000);</script>";
}
?>
