<?php
include '../include/checklogin.php';
if (isset($_GET['workshop_id']) && !empty($_GET['workshop_id'])) {
  $id = mysqli_real_escape_string($con, $_GET['workshop_id']);
  $id = only_digits($id);
  if ($id == false) {
      $_SESSION['status'] = "Invalid data in url";
      $_SESSION['status_code'] = "error";
      echo "<script>setTimeout(function(){window.location='workshop_view.php'},1000)</script>";
  }

$stmt = $con->prepare("UPDATE `tbl_workshop` SET updated_by = ? , is_delete = 1 ,is_active = 0 WHERE id = ? ");
$stmt->bind_param("ii", $web_admin_id,$id);
$result = $stmt->execute();
if ($result) {

    $status = 0;
    $type = "workshop";
    // Get file names from tbl_site_photos
    $cmd = $con->prepare("SELECT photos.file_name as file_name FROM `tbl_site_photos` as photos WHERE photos.type = ? AND photos.type_id = ?");
    $cmd->bind_param("ss", $type, $id);
    $cmd->execute();
    $result2 = $cmd->get_result();
     
    while ($row = $result2->fetch_assoc()) {
      $file_name = $row['file_name'] ;
      $path = '../uploads/workshop/';
      // Delete file from directory
      if (delete_file($file_name, $path)) {
        
        
        // Delete tbl_site_photos records
        $type = "workshop";
        $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE type_id = ? AND type = ?");
        $stmt->bind_param("is", $id, $type);
        $file_delete = $stmt->execute();
  
        if ($file_delete) {
            $_SESSION['status'] = "workshop Deleted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='workshop_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "workshop Deletion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='workshop_view.php'},1000);</script>";
        }
      } else {
        $_SESSION['status'] = "workshop Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='workshop_view.php'},1000);</script>";
      }
    }
  }
}
?>
