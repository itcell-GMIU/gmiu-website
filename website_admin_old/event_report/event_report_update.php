<?php
// Including a file for checking user login    and password
include '../include/checklogin.php';
{
if (isset($_POST["submit"])) {

    $id =  mysqli_real_escape_string($con,$_POST["id"]);
    $date = mysqli_real_escape_string($con ,$_POST['date']);
    $s = $date;
    $year = strtok($s, '-');
    $month = strtok('-');
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con,$_POST['description']);
   
    $file= $_FILES['image_upload'];
   
    /// Update tbl_industrial_visit 
    $stmt = $con->prepare("UPDATE `tbl_event_report` SET event_year = ?,visit_name = ?,visit_description = ? WHERE id = ? ");
    $stmt->bind_param("sssi",$year, $title, $description, $id);
    $result = $stmt->execute();
    $type_id = $con->insert_id;
    if($result)
    {
        //industry image photos update
        if($_FILES['image_upload']['error'][0]  == 0)
        {
                //delete tbl_site photos
                $type = "event_report";
                $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? and type = ?  ");
                $stmt->bind_param("is", $id, $type);
                $result = $stmt->execute();
                 // Check if photos are deleted
                if($result)
                {
                    $targetDirectory = "../uploads/event_report/image/";
                     // Upload new photos
                    $uploaded_images = upload_multiple_files($_FILES["image_upload"], $targetDirectory, 1);
        
                    if ($uploaded_images['status'] == 200) {
                        foreach ($uploaded_images['message'] as $file_name) {
                            $file_type = "image";
                            $type = "event_report";
                            $file_name = implode("", $file_name);
                            $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $id, $type, $file_name, $file_type);
                            $result = $stmt->execute(); // Upload new photos

                        }

                    } else {
                        $_SESSION['status'] = $uploaded_images['message'];
                        $_SESSION['status_code'] = "error";
                       echo "<script>setTimeout(function(){window.location='event_report_edit.php'},1000)</script>";
                    }
                }
                else
                { 
                    $_SESSION['status'] = "Industry Visit Update Failed ";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='event_report_edit.php'},1000);</script>";
                }
        }

        //report update 
        if ($_FILES['report_upload']['error']  === 0) {
            $targetDirectory = "../uploads/event_report/report/";
            $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);// Upload report file
            if ($file_upload_status['status'] == 200) {
                $file_name = $file_upload_status['message'];
                $stmt = $con->prepare("UPDATE `tbl_event_report` SET report = ? WHERE id = ? ");
                $stmt->bind_param("si",$file_name, $id);
                $result = $stmt->execute();// Updating report file name
                $type_id = $con->insert_id;
               
            } else {
                $_SESSION['status'] = $file_upload_status['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='event_report_insert.php'},1000)</script>";
                //error message popup
            }
        }
        $_SESSION['status'] = "Event Report Updated Successfully";
        $_SESSION['status_code'] = "success";
         echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
    }else
    {
        $_SESSION['status'] = "Event Report Update Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='event_report_edit.php'},1000)</script>";
    }
 
}
}
?>


