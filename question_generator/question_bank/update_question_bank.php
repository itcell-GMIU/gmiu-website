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
    $mcq_a = $_POST['mcq_a'];
    $mcq_b = $_POST['mcq_b'];
    $mcq_c = $_POST['mcq_c'];
    $mcq_d = $_POST['mcq_d'];

    // Validate Data
    $faculty_id = validate_data($faculty_id);
    $level_id = validate_data($level_id);
    $program_id = validate_data($program_id);


    $stmt = $con->prepare("UPDATE `tbl_questions` SET `subject_code`=? , `chapter`=? , `question`=?, `marks`=?,`mcq_choice_a`=?, `mcq_choice_b`=?, `mcq_choice_c`=?, `mcq_choice_d`=?  WHERE id = ?");
    $stmt->bind_param("sisissssi", $subject_code, $chapter, $question, $marks, $mcq_a, $mcq_b, $mcq_c, $mcq_d, $id);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = "Question Updated Successfully";
        $_SESSION['status_code'] = "success";
        header("Location: view_mcq_question_bank.php");
        exit();
    } else {
        $_SESSION['status'] = "Question Updation Failed: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        header("Location: view_mcq_question_bank.php");
        exit();
    }
    $stmt->close();
}
