<?php
include '../include/checklogin.php';

if ($role_id == 8) {
    if (isset($_POST["submit"])) {
        $about_startup_id = mysqli_real_escape_string($con, $_POST['about_startup_id']);
        $description = $_POST['description'];


        // validate data


        $stmt = $con->prepare("UPDATE `tbl_about_startup` SET description = ? WHERE id = ? ");
        $stmt->bind_param("si", $description, $about_startup_id);
        $result = $stmt->execute();

           
            $_SESSION['status'] = "About Startup Updated Successfully";
            $_SESSION['status_code'] = "success";
           echo "<script>setTimeout(function(){window.location='about_startup_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "About Startup Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='about_startup_edit.php'},1000)</script>";
        }
    }
 else {
    if (isset($_POST["submit"])) {

        $about_startup_id = mysqli_real_escape_string($con, $_POST['about_startup_id']);
        $description = $_POST['description'];

        $stmt = $con->prepare("UPDATE `tbl_about_startup` SET description = ? WHERE id = ? ");
        $stmt->bind_param("si", $description, $about_startup_id);
        $result = $stmt->execute();

            //report update 
 
            $_SESSION['status'] = "About Startup Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='about_startup_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "About Startup Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='about_startup_edit.php'},1000)</script>";
        }
    }

