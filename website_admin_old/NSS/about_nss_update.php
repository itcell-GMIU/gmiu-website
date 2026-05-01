<?php
include '../include/checklogin.php';

if ($role_id == 8) {
    if (isset($_POST["submit"])) {
        $nss_about_id = mysqli_real_escape_string($con, $_POST['nss_about_id']);
        $description = $_POST['description'];


        // validate data


        $stmt = $con->prepare("UPDATE `tbl_nss_about` SET description = ? WHERE id = ? ");
        $stmt->bind_param("si", $description, $nss_about_id);
        $result = $stmt->execute();

           
            $_SESSION['status'] = "About Us Updated Successfully";
            $_SESSION['status_code'] = "success";
           echo "<script>setTimeout(function(){window.location='about_nss_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "About Us Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='about_nss_edit.php'},1000)</script>";
        }
    }
 else {
    if (isset($_POST["submit"])) {

        $nss_about_id = mysqli_real_escape_string($con, $_POST['nss_about_id']);
        $description = $_POST['description'];

        $stmt = $con->prepare("UPDATE `tbl_nss_about` SET description = ? WHERE id = ? ");
        $stmt->bind_param("si", $description, $nss_about_id);
        $result = $stmt->execute();

            //report update 
 
            $_SESSION['status'] = "About Us Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='about_nss_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "About Us Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='about_nss_edit.php'},1000)</script>";
        }
    }

