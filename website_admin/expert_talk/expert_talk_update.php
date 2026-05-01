<?php
include '../include/checklogin.php';
if ($role_id == 8) {
    if (isset($_POST["submit"])) {
        $id = mysqli_real_escape_string($con, $_POST['id']);
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $description = $_POST['description'];
        $date = mysqli_real_escape_string($con, $_POST['date']);
       // $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
       $level_id = $_POST['level_id'];
       $level_id = implode(',', $level_id);
        $program_id =  $_POST['program_id'];
        $program_id = implode(',', $program_id);


        // validate data
        $faculty_id = validate_data($faculty_id);
       // $level_id = validate_data($level_id);
        $title = validate_data($title);
        $date = validate_data($date);
        //$program_id = validate_data($program_id);




        $stmt = $con->prepare("UPDATE `tbl_expert_talk` SET faculty_id = ?,program_id = ?,level_id = ?,date = ?, title = ?,description = ? WHERE id = ? ");
        $stmt->bind_param("isssssi", $faculty_id, $program_id, $level_id, $date, $title, $description,  $id);
        $result = $stmt->execute();




        if ($result) {
            //expert talk photos update
            if ($_FILES['images']['error'][0]  == 0) {
                //delete tbl_site photos
                $type = "expert_talk";
                $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? and type = ?  ");
                $stmt->bind_param("is", $id, $type);
                $result = $stmt->execute();
                // check photos are deleted 
                if ($result) {
                    $targetDirectory = "../uploads/expert_talk/image/";
                    $uploaded_images = upload_multiple_files($_FILES["images"], $targetDirectory, 1);

                    if ($uploaded_images['status'] == 200) {
                        foreach ($uploaded_images['message'] as $file_name) {
                            $file_type = "image";
                            $type = "expert_talk";
                            $file_name = implode("", $file_name);
                            $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $id, $type, $file_name, $file_type);
                            $result = $stmt->execute();
                        }
                    } else {
                        $_SESSION['status'] = $uploaded_images['message'];
                        $_SESSION['status_code'] = "error";
                        echo "<script>setTimeout(function(){window.location='expert_talk_edit.php'},1000)</script>";
                    }
                } else {
                    $_SESSION['status'] = "expert talk Update Failed ";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='expert_talk_edit.php'},1000);</script>";
                }
            }

            //report update 
            if ($_FILES['report_upload']['error']  === 0) {
                $targetDirectory = "../uploads/expert_talk/report/";
                $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);
                if ($file_upload_status['status'] == 200) {
                    $file_name = $file_upload_status['message'];
                    $stmt = $con->prepare("UPDATE `tbl_expert_talk` SET report_file = ? WHERE id = ? ");
                    $stmt->bind_param("si", $file_name, $id);
                    $result = $stmt->execute();
                    $type_id = $con->insert_id;
                } else {
                    $_SESSION['status'] = $file_upload_status['message'];
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='expert_talk_insert.php'},1000)</script>";
                    //error message popup
                }
            }
            $_SESSION['status'] = "Expert talk Updated Successfully";
            $_SESSION['status_code'] = "success";
           echo "<script>setTimeout(function(){window.location='expert_talk_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Expert talk Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='expert_talk_edit.php'},1000)</script>";
        }
    }
} else {
    if (isset($_POST["submit"])) {

        $id = mysqli_real_escape_string($con, $_POST['id']);
        $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $description = $_POST['description'];
        $date = mysqli_real_escape_string($con, $_POST['date']);


        // validate data
        $faculty_id = validate_data($faculty_id);
       // $level_id = validate_data($level_id);
        $title = validate_data($title);
        $date = validate_data($date);
        //$program_id = validate_data($program_id);




        $stmt = $con->prepare("UPDATE `tbl_expert_talk` SET faculty_id = ?,program_id = ?,level_id = ?,date = ?, title = ?,description = ? WHERE id = ? ");
        $stmt->bind_param("isssssi", $faculty_id, $program_id, $level_id, $date, $title, $description,  $id);
        $result = $stmt->execute();




        if ($result) {
            //expert talk photos update
            if ($_FILES['images']['error'][0]  == 0) {
                //delete tbl_site photos
                $type = "expert_talk";
                $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? and type = ?  ");
                $stmt->bind_param("is", $id, $type);
                $result = $stmt->execute();
                // check photos are deleted 
                if ($result) {
                    $targetDirectory = "../uploads/expert_talk/image/";
                    $uploaded_images = upload_multiple_files($_FILES["images"], $targetDirectory, 1);

                    if ($uploaded_images['status'] == 200) {
                        foreach ($uploaded_images['message'] as $file_name) {
                            $file_type = "image";
                            $type = "expert_talk";
                            $file_name = implode("", $file_name);
                            $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $id, $type, $file_name, $file_type);
                            $result = $stmt->execute();
                        }
                    } else {
                        $_SESSION['status'] = $uploaded_images['message'];
                        $_SESSION['status_code'] = "error";
                        echo "<script>setTimeout(function(){window.location='expert_talk_edit.php'},1000)</script>";
                    }
                } else {
                    $_SESSION['status'] = "expert talk Update Failed ";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='expert_talk_edit.php'},1000);</script>";
                }
            }

            //report update 
            if ($_FILES['report_upload']['error']  === 0) {
                $targetDirectory = "../uploads/expert_talk/report/";
                $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);
                if ($file_upload_status['status'] == 200) {
                    $file_name = $file_upload_status['message'];
                    $stmt = $con->prepare("UPDATE `tbl_expert_talk` SET report_file = ? WHERE id = ? ");
                    $stmt->bind_param("si", $file_name, $id);
                    $result = $stmt->execute();
                    $type_id = $con->insert_id;
                } else {
                    $_SESSION['status'] = $file_upload_status['message'];
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='expert_talk_insert.php'},1000)</script>";
                    //error message popup
                }
            }
            $_SESSION['status'] = "Expert talk Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='expert_talk_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Expert talk Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='expert_talk_edit.php'},1000)</script>";
        }
    }
}
