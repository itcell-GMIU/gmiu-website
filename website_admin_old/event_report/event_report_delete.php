<?php
include '../include/checklogin.php';

// GET faculty id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = mysqli_real_escape_string($con, $_GET['id']);
  $id = only_digits($id);
  if ($id == false) {
    $_SESSION['status'] = "Invalid data in url";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000)</script>";
  }


  $stmt = $con->prepare("UPDATE `tbl_event_report` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
  $stmt->bind_param("i", $id);
  $result = $stmt->execute();
  if ($result) {
    $status = 0;
    $type = "event_report";

    // Get file names from tbl_site_photos
    $cmd = $con->prepare("SELECT photos.file_name as file_name FROM `tbl_site_photos` as photos  WHERE photos.type = ? AND photos.type_id = ?");
    $cmd->bind_param("ss", $type, $id);
    $cmd->execute();
    $result2 = $cmd->get_result();

    // get report name form database
    $cmd = $con->prepare("SELECT report  FROM `tbl_event_report` WHERE id = ?");
    $cmd->bind_param("i", $id);
    $cmd->execute();
    $report = $cmd->get_result();

    if ($report) {
      while ($row = $report->fetch_assoc()) {
        if (!empty($row['report'])) {
          $report_name = $row['report'];
          $path = '../uploads/event_report/report';

          // Call your delete_file function to delete the file
          delete_file($report_name, $path);
        }
      }
    }


    while ($row = $result2->fetch_assoc()) {
      $file_name = $row['file_name'];
      $path = '../uploads/event_report/image/';
      // Delete images from directory
      if (!empty($row['file_name'])) {
        if (delete_file($file_name, $path)) {
          $type = "event_report";
          $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? and type = ?  ");
          $stmt->bind_param("is", $id, $type);
          $file_delete = $stmt->execute();

          if ($file_delete) {
            $_SESSION['status'] = " Event Report Delete Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
          } else {
            $_SESSION['status'] = " Event Report Deletion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
          }
        } else {
          $_SESSION['status'] = " Event Report Deletion Failed";
          $_SESSION['status_code'] = "error";
          echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
        }
      }
    }
  }
}
