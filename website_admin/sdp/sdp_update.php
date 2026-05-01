<?php
include '../include/checklogin.php';

if($role_id == 8 )
{
    if(isset($_POST["submit"])) 
    {   
        // Extract form data
        $id = $_POST["id"];
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $description = $_POST['description'];
        $date = $_POST['date'];
        $s = $date;
        $year = strtok($s, '-');
        $month = strtok('-');
        $level_id = $_POST['level_id'];

        $level_id = implode(',', $level_id);
 
         $program_id =  $_POST['program_id'];
 
         $program_id = implode(',', $program_id);
        //$level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    
        // Validate Data
       // $program_id = validate_data($program_id);
        $faculty_id = validate_data($faculty_id);
        //$level_id = validate_data($level_id);
        $title = validate_data($title);
         
        // Prepare and execute SQL statement for updating 'tbl_sdp' data
        $stmt = $con->prepare("UPDATE `tbl_sdp` SET  faculty_id = ?,program_id = ?,level_id = ?,year = ?,title = ?,description = ?,date = ? where id = ?");
        $stmt->bind_param("issssssi",$faculty_id,$program_id,$level_id,$year,$title,$description,$date,$id);
        $result = $stmt->execute();
        if($result)
        {
            if($_FILES['image_upload']['error'] === 0)
        {    
            // Check if new image is uploaded
            $targetDirectory = "../uploads/sdp/image/";
            $file_upload_status = upload_single_file($_FILES["image_upload"], $targetDirectory, 1);
            if ($file_upload_status['status'] == 200) {
                $file_name = $file_upload_status['message'];
                $stmt = $con->prepare("UPDATE `tbl_sdp` SET img_name = ? where id = ?");
                $stmt->bind_param("si",$file_name,$id);
                $result = $stmt->execute();
                
                  
            }else {
                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
               echo "<script>setTimeout(function(){window.location='sdp_edit.php'},1000)</script>";
            }
    
        } 
        
        
        if ($_FILES['report_upload']['error']  === 0) {
            // Check if new image is uploaded
            $targetDirectory = "../uploads/sdp/report/";
            $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);
            if ($file_upload_status['status'] == 200) {
                $file_name = $file_upload_status['message'];
                $stmt = $con->prepare("UPDATE `tbl_sdp` SET report = ? WHERE id = ? ");
                $stmt->bind_param("si",$file_name, $id);
                $result = $stmt->execute();
                $type_id = $con->insert_id;
               
            } else {
                $_SESSION['status'] = $file_upload_status['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='sdp_insert.php'},1000)</script>";
                //error message popup
            }
        }
    
                $_SESSION['status'] = "SDP Updated Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='sdp_view.php'},1000);</script>";
        }
        else
        {
            if ($result) {
                if ($result) {
                    $_SESSION['status'] = "SDP  Updated Successfully";
                    $_SESSION['status_code'] = "success";
        
                    echo "<script>setTimeout(function(){window.location='sdp_view.php'},1000);</script>";
                } else {
                    $_SESSION['status'] = "SDP Insertion Failed";
                    $_SESSION['status_code'] = "error";
                     echo "<script>setTimeout(function(){window.location='sdp_view.php'},1000)</script>";
                }
        }
    
       
        }
     }
}
else
{
if(isset($_POST["submit"])) 
{   
    // Extract form data
    $id = $_POST["id"];
    $program_id = $_POST['program_id'];
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = $_POST['description'];
    $date = $_POST['date'];
    $s = $date;
    $year = strtok($s, '-');
    $month = strtok('-');
   $program_id_str = implode(',', array_map('intval', $program_id));
    // Validate Data
    // $program_id = validate_data($program_id);
    $faculty_id = validate_data($faculty_id);
    $level_id = validate_data($level_id);
    $title = validate_data($title);
     
    // Prepare and execute SQL statement for updating 'tbl_sdp' data
    $stmt = $con->prepare("UPDATE `tbl_sdp` SET  faculty_id = ?,program_id = ?,level_id = ?,year = ?,title = ?,description = ?,date = ? where id = ?");
    $stmt->bind_param("issssssi",$faculty_id,$program_id_str,$level_id,$year,$title,$description,$date,$id);
    $result = $stmt->execute();
    if($result)
    {
        if($_FILES['image_upload']['error'] === 0)
    {    
        // Check if new image is uploaded
        $targetDirectory = "../uploads/sdp/image/";
        $file_upload_status = upload_single_file($_FILES["image_upload"], $targetDirectory, 1);
        if ($file_upload_status['status'] == 200) {
            $file_name = $file_upload_status['message'];
            $stmt = $con->prepare("UPDATE `tbl_sdp` SET img_name = ? where id = ?");
            $stmt->bind_param("si",$file_name,$id);
            $result = $stmt->execute();
            
              
        }else {
            $_SESSION['status'] = $uploaded_images['message'];
            $_SESSION['status_code'] = "error";
           echo "<script>setTimeout(function(){window.location='sdp_edit.php'},1000)</script>";
        }

    } 
    
    
    if ($_FILES['report_upload']['error']  === 0) {
        // Check if new image is uploaded
        $targetDirectory = "../uploads/sdp/report/";
        $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);
        if ($file_upload_status['status'] == 200) {
            $file_name = $file_upload_status['message'];
            $stmt = $con->prepare("UPDATE `tbl_sdp` SET report = ? WHERE id = ? ");
            $stmt->bind_param("si",$file_name, $id);
            $result = $stmt->execute();
            $type_id = $con->insert_id;
           
        } else {
            $_SESSION['status'] = $file_upload_status['message'];
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='sdp_insert.php'},1000)</script>";
            //error message popup
        }
    }

            $_SESSION['status'] = "SDP Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='sdp_view.php'},1000);</script>";
    }
    else
    {
        if ($result) {
            if ($result) {
                $_SESSION['status'] = "SDP  Updated Successfully";
                $_SESSION['status_code'] = "success";
    
                echo "<script>setTimeout(function(){window.location='sdp_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "SDP Updated Failed";
                $_SESSION['status_code'] = "error";
                 echo "<script>setTimeout(function(){window.location='sdp_view.php'},1000)</script>";
            }
    }

   
    }
 }
}
