<?php
include '../include/checklogin.php';

// GET faculty id from display table
if (isset($_GET['daily_post_id']) && !empty($_GET['daily_post_id'])) {
  $id = mysqli_real_escape_string($con, $_GET['daily_post_id']);
  $id = only_digits($id);
  if ($id == false) {
      $_SESSION['status'] = "Invalid data in url";
      $_SESSION['status_code'] = "error";
      echo "<script>setTimeout(function(){window.location='daily_post_view.php'},1000)</script>";
  }
}
// get type to daily post 
$cmd = $con->prepare("SELECT file_type FROM `tbl_daily_post` WHERE id = ?");
$cmd->bind_param("i",$id);
$cmd->execute();
$type = $cmd->get_result();
while ($row = $type->fetch_assoc()) {
  $file_type = $row['file_type'];
}

$stmt = $con->prepare("DELETE FROM `tbl_daily_post` WHERE id = ?");
$stmt->bind_param("i", $id);
// Delete tbl_daily_post record
$result = $stmt->execute();
if($file_type == "video"){
  if($result)
  {
    $_SESSION['status'] = "Daily Post deleted successfully";
    $_SESSION['status_code'] = "success";
    echo "<script>setTimeout(function(){window.location='daily_post_view.php'},1000);</script>";
  }
  else {
    $_SESSION['status'] = "Daily Post deletion failed";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='daily_post_view.php'},1000);</script>";
  }
}
elseif($file_type == "image")
{
if ($result) {
  $status = 0;
  $type = "daily_post";
  // Get file names from tbl_site_photos
  $cmd = $con->prepare("SELECT photos.file_name as file_name FROM `tbl_site_photos` as photos WHERE photos.type = ? AND photos.type_id = ?");
  $cmd->bind_param("ss", $type, $id);
  $cmd->execute();
  $result2 = $cmd->get_result();
   
  while ($row = $result2->fetch_assoc()) {
    $file_name = $row['file_name'] ;
    $path = '../uploads/daily_post/';
    // Delete file from directory
    if (delete_file($file_name, $path)) {
      
      
      // Delete tbl_site_photos records
      $type = "daily_post";
      $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE type_id = ? AND type = ?");
      $stmt->bind_param("is", $id, $type);
      $file_delete = $stmt->execute();

      if ($file_delete) {
        $_SESSION['status'] = "Daily Post deleted successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='daily_post_view.php'},1000);</script>";
      } else {
        $_SESSION['status'] = "Daily Post deletion failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='daily_post_view.php'},1000);</script>";
      }
    } else {
      $_SESSION['status'] = "Daily Post deletion failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='daily_post_view.php'},1000);</script>";
    }
  }
}
}
?>