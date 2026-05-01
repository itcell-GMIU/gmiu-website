<?php
// Include the checklogin.php file
include '../include/checklogin.php';
if (isset($_POST['submit'])) {
    // Fetch data from HTML Form
    $mrk = $_POST['marks'];
    $br = $_POST['brCode'];
    if ($role_id == 51) {
        if ($mrk > 100) {
            echo "<script>setTimeout(function(){window.location='add_marks.php?err=g100'},100)</script>";
        } else {

            // Insert the JSON data into the database
            $stmt = $con->prepare("UPDATE tbl_exam_results SET Mtheory = ?, MtheoryTime = CURRENT_TIMESTAMP WHERE barcode = ?");
            $stmt->bind_param("is", $mrk, $br);
            $result1 = $stmt->execute();

            // Error handling if insertion fails
            if ($result1 == 1) {
                // $_SESSION['status'] = "Mark Locked Successfully!";
                // $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='add_marks.php'},100)</script>";
            } else {
                $_SESSION['status'] = "Marks Insertion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='add_marks.php'},100)</script>";
            }
        }
    }
    if ($role_id == 52) {

        if ($mrk > 100) {
            echo "<script>setTimeout(function(){window.location='add_marks.php?err=g100'},100)</script>";
        } else {

            // Insert the JSON data into the database
            $stmt = $con->prepare("UPDATE tbl_exam_results SET Mtheory = ?, examinerID = ?, MtheoryTime = CURRENT_TIMESTAMP WHERE barcode = ?");
            $stmt->bind_param("sis", $mrk, $staff_id, $br);
            $result1 = $stmt->execute();

            // Error handling if insertion fails
            if ($result1 == 1) {
                // $_SESSION['status'] = "Mark Locked Successfully!";
                // $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='add_marks.php'},100)</script>";
            } else {
                $_SESSION['status'] = "Marks Insertion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='add_marks.php'},100)</script>";
            }
        }
    }
}
