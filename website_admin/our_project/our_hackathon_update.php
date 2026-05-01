<?php
include '../include/checklogin.php';
if ($role_id == 8) {
    if (isset($_POST["submit"])) {
        $id = mysqli_real_escape_string($con, $_POST['id']);
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $teamleader = isset($_POST['team_leader']) ? mysqli_real_escape_string($con, $_POST['team_leader']) : '';
        $teammember = isset($_POST['team_member']) ? implode(', ', $_POST['team_member']) : '';


        // validate data
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);
        $title = validate_data($title);
        $program_id = validate_data($program_id);




        $stmt = $con->prepare("UPDATE `tbl_our_hackathon` SET faculty_id = ?,program_id = ?,level_id = ?,title = ?, team_leader=?, title=?, team_member=?, location=? WHERE id = ? ");
        $stmt->bind_param("iiissssi", $faculty_id, $program_id, $level_id, $title, $teamleader, $teammember, $location,  $id);
        $result = $stmt->execute();




        if ($result) {
            //expert talk photos update
            if ($_FILES['images']['error'][0]  == 0) {
                //delete tbl_site photos
                $type = "our_hackathon";
                $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? and type = ?  ");
                $stmt->bind_param("is", $id, $type);
                $result = $stmt->execute();
                // check photos are deleted 
                if ($result) {
                    $targetDirectory = "../uploads/our_project/image/";
                    $uploaded_images = upload_multiple_files($_FILES["images"], $targetDirectory, 1);

                    if ($uploaded_images['status'] == 200) {
                        foreach ($uploaded_images['message'] as $file_name) {
                            $file_type = "image";
                            $type = "our_hackathon";
                            $file_name = implode("", $file_name);
                            $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $id, $type, $file_name, $file_type);
                            $result = $stmt->execute();
                        }
                    } else {
                        $_SESSION['status'] = $uploaded_images['message'];
                        $_SESSION['status_code'] = "error";
                        echo "<script>setTimeout(function(){window.location='our_hackathon_edit.php'},1000)</script>";
                    }
                } else {
                    $_SESSION['status'] = "Our Hackathon Update Failed ";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='our_hackathon_edit.php'},1000);</script>";
                }
            }

            //report update 
            
            $_SESSION['status'] = "Our Hackathon Updated Successfully";
            $_SESSION['status_code'] = "success";
           echo "<script>setTimeout(function(){window.location='our_hackathon_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Our Hackathon Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='our_hackathon_edit.php'},1000)</script>";
        }
    }
} else {
    if (isset($_POST["submit"])) {

        $id = mysqli_real_escape_string($con, $_POST['id']);
        $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $teamleader = mysqli_real_escape_string($con, $_POST['team_leader']);
        $teammember = mysqli_real_escape_string($con, $_POST['team_member']);
        $location = mysqli_real_escape_string($con, $_POST['location']);

        // validate data
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);
        $title = validate_data($title);
        $program_id = validate_data($program_id);




        $stmt = $con->prepare("UPDATE `tbl_our_hackathon` SET faculty_id = ?,program_id = ?,level_id = ?,title = ?,team_leader = ?,team_member = ?,location = ? WHERE id = ? ");
        $stmt->bind_param("iiissssi", $faculty_id, $program_id, $level_id,$title, $teamleader, $teammember, $location, $id);
        $result = $stmt->execute();




        if ($result) {
            //expert talk photos update
            if ($_FILES['images']['error'][0]  == 0) {
                //delete tbl_site photos
                $type = "our_hackathon";
                $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? and type = ?  ");
                $stmt->bind_param("is", $id, $type);
                $result = $stmt->execute();
                // check photos are deleted 
                if ($result) {
                    $targetDirectory = "../uploads/our_project/image/";
                    $uploaded_images = upload_multiple_files($_FILES["images"], $targetDirectory, 1);

                    if ($uploaded_images['status'] == 200) {
                        foreach ($uploaded_images['message'] as $file_name) {
                            $file_type = "image";
                            $type = "our_hackathon";
                            $file_name = implode("", $file_name);
                            $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $id, $type, $file_name, $file_type);
                            $result = $stmt->execute();
                        }
                    } else {
                        $_SESSION['status'] = $uploaded_images['message'];
                        $_SESSION['status_code'] = "error";
                        echo "<script>setTimeout(function(){window.location='our_hackathon_edit.php'},1000)</script>";
                    }
                } else {
                    $_SESSION['status'] = "Our Hackathon Update Failed ";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='our_hackathon_edit.php'},1000);</script>";
                }
            }

            
            $_SESSION['status'] = "Our Hackathon Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='our_hackathon_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Our Hackathon Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='our_hackathon_edit.php'},1000)</script>";
        }
    }
}
