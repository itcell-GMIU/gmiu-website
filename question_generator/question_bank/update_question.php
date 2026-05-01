<?php
include '../include/checklogin.php';

    if (isset($_POST['submit'])) {
        // Retrieve form data
        $id = $_POST['id'];
        $faculty_id = $_POST['faculty_id'];
        $level_id = $_POST['level_id'];
        $program_id = $_POST['program_id'];
        $sem = $_POST['sem'];
        $subject_code = $_POST['subject_code'];
        $chapter = $_POST['chapter'];
        $question = $_POST['question'];
        $marks = $_POST['marks'];
        $co_level = $_POST['co_level'];
        $bl_level = $_POST['bl_level'];
       

        // Validate Data
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);
        $program_id = validate_data($program_id);

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
        $stmt = $con->prepare("UPDATE `tbl_questions` SET `subject_code`=? , `chapter`=? , `question`=?, `marks`=?,`co_level`=?, `bl_level`=? WHERE id = ?");
        $stmt->bind_param("sisissi", $subject_code, $chapter, $question, $marks,$co_level, $bl_level, $id);
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['status'] = "Question Updated Successfully";
            $_SESSION['status_code'] = "success";
            header("Location: view_question_bank.php");
            exit();
        } else {
            $_SESSION['status'] = "Question Updation Failed: " . $stmt->error;
            $_SESSION['status_code'] = "error";
            header("Location: view_question_bank.php");
            exit();
        }

        $stmt->close();
    }

?>

