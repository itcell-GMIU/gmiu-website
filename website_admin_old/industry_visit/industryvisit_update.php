<?php
// Including a file for checking user login    and password
include '../include/checklogin.php';
if ($role_id == 8)
{
    if (isset($_POST["submit"])) {

        $id =  mysqli_real_escape_string($con,$_POST["id"]);
        $date = mysqli_real_escape_string($con ,$_POST['date']);
        $s = $date;
        $year = strtok($s, '-');
        $month = strtok('-');
        $description = $_POST['description'];
        $title = $title = mysqli_real_escape_string($con, $_POST['title']);
        $file= $_FILES['image_upload'];
       // $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
       $level_id = $_POST['level_id'];
       $level_id = implode(',', $level_id);
        $program_id =  $_POST['program_id'];
        $program_id = implode(',', $program_id);
       
        /// Update tbl_industrial_visit 
        $stmt = $con->prepare("UPDATE `tbl_industry_visit` SET faculty_id = ?,program_id = ?,level_id = ?,visit_year = ?,visit_name = ?,visit_description = ?, date = ? WHERE id = ? ");
        $stmt->bind_param("issssssi", $faculty_id,$program_id,$level_id,$year, $title, $description, $date, $id);
        $result = $stmt->execute();
        $type_id = $con->insert_id;
        if($result)
        {
            //industry image photos update
            if($_FILES['image_upload']['error'][0]  == 0)
            {
                    //delete tbl_site photos
                    $type = "industry_visit";
                    $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? and type = ?  ");
                    $stmt->bind_param("is", $id, $type);
                    $result = $stmt->execute();
                     // Check if photos are deleted
                    if($result)
                    {
                        $targetDirectory = "../uploads/industry_visit/image/";
                         // Upload new photos
                        $uploaded_images = upload_multiple_files($_FILES["image_upload"], $targetDirectory, 1);
            
                        if ($uploaded_images['status'] == 200) {
                            foreach ($uploaded_images['message'] as $file_name) {
                                $file_type = "image";
                                $type = "industry_visit";
                                $file_name = implode("", $file_name);
                                $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                                $stmt->bind_param("ssss", $id, $type, $file_name, $file_type);
                                $result = $stmt->execute(); // Upload new photos
    
                            }
    
                        } else {
                            $_SESSION['status'] = $uploaded_images['message'];
                            $_SESSION['status_code'] = "error";
                           echo "<script>setTimeout(function(){window.location='industryvisit_edit.php'},1000)</script>";
                        }
                    }
                    else
                    { 
                        $_SESSION['status'] = "Industry Visit Update Failed ";
                        $_SESSION['status_code'] = "error";
                        echo "<script>setTimeout(function(){window.location='industryvisit_edit.php'},1000);</script>";
                    }
            }
    
            //report update 
            if ($_FILES['report_upload']['error']  === 0) {
                $targetDirectory = "../uploads/industry_visit/report/";
                $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);// Upload report file
                if ($file_upload_status['status'] == 200) {
                    $file_name = $file_upload_status['message'];
                    $stmt = $con->prepare("UPDATE `tbl_industry_visit` SET report = ? WHERE id = ? ");
                    $stmt->bind_param("si",$file_name, $id);
                    $result = $stmt->execute();// Updating report file name
                    $type_id = $con->insert_id;
                   
                } else {
                    $_SESSION['status'] = $file_upload_status['message'];
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='industryvisit_insert.php'},1000)</script>";
                    //error message popup
                }
            }
            $_SESSION['status'] = "Industry Visit Updated Successfully";
            $_SESSION['status_code'] = "success";
             echo "<script>setTimeout(function(){window.location='industryvisit_view.php'},1000);</script>";
        }else
        {
            $_SESSION['status'] = "Industry Visit Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='industryvisit_edit.php'},1000)</script>";
        }
     
    }

}else
{
if (isset($_POST["submit"])) {

    $id =  mysqli_real_escape_string($con,$_POST["id"]);
    $date = mysqli_real_escape_string($con ,$_POST['date']);
    $s = $date;
    $year = strtok($s, '-');
    $month = strtok('-');
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $description = $_POST['description'];
    $title = $title = mysqli_real_escape_string($con, $_POST['title']);
    $file= $_FILES['image_upload'];
   
    /// Update tbl_industrial_visit 
    $stmt = $con->prepare("UPDATE `tbl_industry_visit` SET faculty_id = ?,program_id = ?,level_id = ?,visit_year = ?,visit_name = ?,visit_description = ?, date = ? WHERE id = ? ");
    $stmt->bind_param("issssssi", $faculty_id,$program_id,$level_id,$year, $title, $description, $date, $id);
    $result = $stmt->execute();
    $type_id = $con->insert_id;
    if($result)
    {
        //industry image photos update
        if($_FILES['image_upload']['error'][0]  == 0)
        {
                //delete tbl_site photos
                $type = "industry_visit";
                $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? and type = ?  ");
                $stmt->bind_param("is", $id, $type);
                $result = $stmt->execute();
                 // Check if photos are deleted
                if($result)
                {
                    $targetDirectory = "../uploads/industry_visit/image/";
                     // Upload new photos
                    $uploaded_images = upload_multiple_files($_FILES["image_upload"], $targetDirectory, 1);
        
                    if ($uploaded_images['status'] == 200) {
                        foreach ($uploaded_images['message'] as $file_name) {
                            $file_type = "image";
                            $type = "industry_visit";
                            $file_name = implode("", $file_name);
                            $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $id, $type, $file_name, $file_type);
                            $result = $stmt->execute(); // Upload new photos

                        }

                    } else {
                        $_SESSION['status'] = $uploaded_images['message'];
                        $_SESSION['status_code'] = "error";
                       echo "<script>setTimeout(function(){window.location='industryvisit_edit.php'},1000)</script>";
                    }
                }
                else
                { 
                    $_SESSION['status'] = "Industry Visit Update Failed ";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='industryvisit_edit.php'},1000);</script>";
                }
        }

        //report update 
        if ($_FILES['report_upload']['error']  === 0) {
            $targetDirectory = "../uploads/industry_visit/report/";
            $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);// Upload report file
            if ($file_upload_status['status'] == 200) {
                $file_name = $file_upload_status['message'];
                $stmt = $con->prepare("UPDATE `tbl_industry_visit` SET report = ? WHERE id = ? ");
                $stmt->bind_param("si",$file_name, $id);
                $result = $stmt->execute();// Updating report file name
                $type_id = $con->insert_id;
               
            } else {
                $_SESSION['status'] = $file_upload_status['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='industryvisit_insert.php'},1000)</script>";
                //error message popup
            }
        }
        $_SESSION['status'] = "Industry Visit Updated Successfully";
        $_SESSION['status_code'] = "success";
         echo "<script>setTimeout(function(){window.location='industryvisit_view.php'},1000);</script>";
    }else
    {
        $_SESSION['status'] = "Industry Visit Update Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='industryvisit_edit.php'},1000)</script>";
    }
 
}
}
?>


