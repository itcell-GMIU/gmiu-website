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

    // Update the paper info
    $stmt = $con->prepare("UPDATE `tbl_paper` 
        SET `clg_name`=?, `exam_name`=?, `exam_time`=?, `end_time`=?, `exam_date`=? 
        WHERE id = ?");
    $stmt->bind_param("sssssi", $clg_name, $exam_name, $exam_time, $end_time, $exam_date, $id);
    $result = $stmt->execute();

    if ($result) {
        // ✅ Update modified questions in tbl_paper_question
        if (!empty($_POST['questions']) && is_array($_POST['questions'])) {
            $stmt_question = $con->prepare("UPDATE `tbl_questions` SET `modify_question`=? WHERE id=?");
            foreach ($_POST['questions'] as $question_id => $data) {
                $modified_question = !empty($data['modify_questions']) ? trim($data['modify_questions']) : NULL;
                $stmt_question->bind_param("si", $modified_question, $question_id);
                $stmt_question->execute();
            }
            $stmt_question->close();
        }

        $_SESSION['status'] = "Field Updated Successfully, All changes saved successfully";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Field Update Failed: " . $stmt->error;
        $_SESSION['status_code'] = "error";
    }

    $stmt->close();
    header("Location: view_generate_paper.php");
    exit();
}
