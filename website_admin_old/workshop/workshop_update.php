<?php
include '../include/checklogin.php';


if ($role_id == 8) {

    
    if (isset($_POST["submit"])) {
        $date = mysqli_real_escape_string($con, $_POST['date']);
        $s = $date;
        $year = strtok($s, '-');
        $month = strtok('-');
        $description = $_POST['description'];
        $id = $_POST['id'];
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $level_id = $_POST['level_id'];

        $level_id = implode(',', $level_id);
 
         $program_id =  $_POST['program_id'];
 
         $program_id = implode(',', $program_id);
       // $level_id = mysqli_real_escape_string($con, $_POST['level_id']);

        $title = validate_data($title);
        $date = validate_data($date);
        $faculty_id = validate_data($faculty_id);
       // $program_id = validate_data($program_id);
        //$level_id = validate_data($level_id);

        $stmt = $con->prepare("UPDATE `tbl_workshop` SET faculty_id = ?,level_id = ?,program_id = ?, year = ?,title = ?,description = ?,date=? WHERE id = ? ");
        $stmt->bind_param("issssssi", $faculty_id, $level_id, $program_id, $year, $title, $description, $date, $id);
        $result = $stmt->execute();

        if ($_FILES['image_upload']['error'][0]  == 0) {

            $type = "workshop";
            $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? and type = ?  ");
            $stmt->bind_param("is", $id, $type);
            $result = $stmt->execute();

            $targetDirectory = "../uploads/workshop/";
            $uploaded_images = upload_multiple_files($_FILES["image_upload"], $targetDirectory, 1);
            if ($uploaded_images['status'] == 200) {

                foreach ($uploaded_images['message'] as $file_name) {
                    $file_type = "image";
                    $type = "workshop";
                    $file_name = implode("", $file_name);
                    $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("isss", $id, $type, $file_name, $file_type);
                    $result = $stmt->execute();
                }


                $_SESSION['status'] = "Workshop Updated Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='workshop_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='workshop_edit.php'},1000)</script>";
            }
        } else {
            if (isset($result)) {

                $_SESSION['status'] = "Workshop Updated Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='workshop_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Workshop Updated Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='workshop_edit.php'},1000);</script>";
            }
        }
    }
} else {
    if (isset($_POST["submit"])) {
        $date = mysqli_real_escape_string($con, $_POST['date']);
        $s = $date;
        $year = strtok($s, '-');
        $month = strtok('-');
        $description = $_POST['description'];
        $id = $_POST['id'];
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
        $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);


        $title = validate_data($title);
        $date = validate_data($date);
        $faculty_id = validate_data($faculty_id);
        $program_id = validate_data($program_id);
        $level_id = validate_data($level_id);

        $stmt = $con->prepare("UPDATE `tbl_workshop` SET faculty_id = ?,level_id = ?,program_id = ?, year = ?,title = ?,description = ?,date=? WHERE id = ? ");
        $stmt->bind_param("issssssi", $faculty_id, $level_id, $program_id, $year, $title, $description, $date, $id);
        $result = $stmt->execute();

        if ($_FILES['image_upload']['error'][0]  == 0) {

            $type = "workshop";
            $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? and type = ?  ");
            $stmt->bind_param("is", $id, $type);
            $result = $stmt->execute();

            $targetDirectory = "../uploads/workshop/";
            $uploaded_images = upload_multiple_files($_FILES["image_upload"], $targetDirectory, 1);
            if ($uploaded_images['status'] == 200) {

                foreach ($uploaded_images['message'] as $file_name) {
                    $file_type = "image";
                    $type = "workshop";
                    $file_name = implode("", $file_name);
                    $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("isss", $id, $type, $file_name, $file_type);
                    $result = $stmt->execute();
                }


                $_SESSION['status'] = "Workshop Updated Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='workshop_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='workshop_edit.php'},1000)</script>";
            }
        } else {
            if (isset($result)) {

                $_SESSION['status'] = "Workshop Updated Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='workshop_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Workshop Updated Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='workshop_edit.php'},1000);</script>";
            }
        }
    }
}
