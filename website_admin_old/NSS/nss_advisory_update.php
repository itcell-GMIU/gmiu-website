<?php
include '../include/checklogin.php';

if ($role_id == 8) {
    if (isset($_POST["submit"])) {
        $nss_advisory_id = mysqli_real_escape_string($con, $_POST['nss_advisory_id']);
        $description = $_POST['description'];


        // validate data


        $stmt = $con->prepare("UPDATE `tbl_nss_advisory` SET description = ? WHERE id = ? ");
        $stmt->bind_param("si", $description, $nss_advisory_id);
        $result = $stmt->execute();

           
            $_SESSION['status'] = "Advisory Committe Updated Successfully";
            $_SESSION['status_code'] = "success";
           echo "<script>setTimeout(function(){window.location='nss_advisory_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Advisory Committe Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='nss_advisory_edit.php'},1000)</script>";
        }
    }
 else {
    if (isset($_POST["submit"])) {

        $nss_advisory_id = mysqli_real_escape_string($con, $_POST['nss_advisory_id']);
        $description = $_POST['description'];

        $stmt = $con->prepare("UPDATE `tbl_nss_advisory` SET description = ? WHERE id = ? ");
        $stmt->bind_param("si", $description, $nss_advisory_id);
        $result = $stmt->execute();

            //report update 
 
            $_SESSION['status'] = "Advisory Committe Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='nss_advisory_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Advisory Committe Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='nss_advisory_edit.php'},1000)</script>";
        }
    }

