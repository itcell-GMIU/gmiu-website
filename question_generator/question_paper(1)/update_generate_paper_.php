<?php
include '../include/checklogin.php';

    if (isset($_POST['submit'])) {
        // Retrieve form data
        $id = $_POST['id'];
        $clg_name = $_POST['clg_name'];
        $exam_name = $_POST['exam_name'];
        $exam_time = $_POST['exam_time'];
        $end_time = $_POST['end_time'];
        $exam_date = $_POST['exam_date'];


        // Check if the combination of subject code and chapter already exists
        // $stmt_check = $con->prepare("SELECT * FROM `tbl_weightage` WHERE subject_code = ? AND chapter = ? AND id != ?");
        // $stmt_check->bind_param("ssi", $subject_code, $chapter, $id);
        // $stmt_check->execute();
        // $result_check = $stmt_check->get_result();

        // If the combination already exists, display an error message
        // if ($result_check->num_rows > 0) {
        //     $_SESSION['status'] = "Weightage for chapter '$chapter' already exists for the selected subject code.";
        //     $_SESSION['status_code'] = "error";
        //     header("Location: view_weightage.php");
        //     exit(); // Stop further execution
        // }

        // Update the data in the database
        $stmt = $con->prepare("UPDATE `tbl_paper` SET `clg_name`=? , `exam_name`=? , `exam_time`=?, `end_time`=?, `exam_date`=? WHERE id = ?");
        $stmt->bind_param("sssssi", $clg_name, $exam_name, $exam_time, $end_time, $exam_date, $id);
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['status'] = "Field Update Successfully";
            $_SESSION['status_code'] = "success";
            header("Location: view_generate_paper.php");
            exit();
        } else {
            $_SESSION['status'] = "Field Updation Failed: " . $stmt->error;
            $_SESSION['status_code'] = "error";
            header("Location: view_generate_paper.php");
            exit();
        }

        $stmt->close();
    }

?>

