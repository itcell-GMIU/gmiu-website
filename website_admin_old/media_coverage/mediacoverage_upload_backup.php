<?php
include '../include/checklogin.php';

$type_file = mysqli_real_escape_string($con, $_POST['type']);

if ($type_file == 'video') {
    $video_link = mysqli_real_escape_string($con, $_POST['videolink']);
    if (isset($_POST["submit"])) {
        $stmt = $con->prepare("INSERT INTO `tbl_media_coverage`(file_type,file)VALUES (?,?)");
        $stmt->bind_param("ss", $type_file, $video_link);
        $result = $stmt->execute();
    }
    if ($result) {
        if ($result) {
            $_SESSION['status'] = "Media Coverage Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Media Coverage Insertion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000)</script>";
        }
    }
} elseif ($type_file == 'image') {
    
        $path = "../uploads/media_coverage/";
        $file_upload_status = upload_single_file($_FILES["file_input"], $path, 1);
        if ($file_upload_status['status'] == 200) {
            $file_name = $file_upload_status['message'];
            $stmt = $con->prepare("INSERT INTO `tbl_media_coverage`(file_type,file) VALUES (?,?)");
            $stmt->bind_param("ss", $type_file, $file_name);
            $result = $stmt->execute();
                 if ($result) {
                   $_SESSION['status'] = "Media Coverage Inserted Successfully";
                     $_SESSION['status_code'] = "success";
                   echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000);</script>";
                 } else {
                    $_SESSION['status'] = "Media Coverage Insertion Failed";
                     $_SESSION['status_code'] = "error";
                     echo "<script>setTimeout(function(){window.location='mediacoverage_insert.php'},1000)</script>";
                 }

            
        } else {
                 $_SESSION['status'] = $file_upload_status['message'];
                 $_SESSION['status_code'] = "error";
              echo "<script>setTimeout(function(){window.location='mediacoverage_insert.php'},1000)</script>";
           //error message popup
        }
        // $file_name = $file_array[0]['name'];
        // print_r($file_array[0]['name']);
        
        
        // if ($result) {
        //     if ($result) {
        //         $_SESSION['status'] = "Media Coverage Inserted Successfully";
        //         $_SESSION['status_code'] = "success";
        //         echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000);</script>";
        //     } else {
        //         $_SESSION['status'] = "dailypost Insertion Failed";
        //         $_SESSION['status_code'] = "error";
        //         echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000)</script>";
        //     }
        // }

}