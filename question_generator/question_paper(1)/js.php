<?php
include '../include/checklogin.php';

if ($role_id == 51 ) {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $clg_name     = mysqli_real_escape_string($con, $_POST['clg_name']);
        $exam_name    = mysqli_real_escape_string($con, $_POST['exam_name']);
        $exam_time    = mysqli_real_escape_string($con, $_POST['exam_time']);
        $end_time     = mysqli_real_escape_string($con, $_POST['end_time']);
        $exam_date    = mysqli_real_escape_string($con, $_POST['exam_date']);
        $subject_code = $_POST['subject_code'];
        $t_marks      = $_POST['t_marks'];
        $blWeightageData = isset($_POST['blWeightageData']) ? $_POST['blWeightageData'] : '';
        $chapterWeightageData = isset($_POST['chapterWeightageData']) ? $_POST['chapterWeightageData'] : '';

        $checkboxIDs  = $_POST['checkboxID'];

        if (empty($checkboxIDs)) {
            echo "Checkbox ID is null!";
            exit();
        }

        // Prepare selected question IDs
        $selectedQuestions = [];
        $idsAndData = explode(',', $checkboxIDs);
        foreach ($idsAndData as $entry) {
            list($questionId, $blLevel, $seq) = explode('-', $entry);
            $selectedQuestions[] = (int)$questionId;
        }
        sort($selectedQuestions);

        // 1️⃣ Check for duplicate papers
        $duplicateFound = false;
        $stmt_check = $con->prepare("SELECT id FROM tbl_paper WHERE subject_code = ? AND total_mark = ? AND is_delete = '0' ");
        $stmt_check->bind_param("si", $subject_code, $t_marks);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        while ($row = $result_check->fetch_assoc()) {
            $paper_id_existing = $row['id'];
            $res_q = $con->query("SELECT question_id FROM tbl_paper_question WHERE paper_id = $paper_id_existing ORDER BY question_id ASC");

            $existingQ = [];
            while ($r = $res_q->fetch_assoc()) {
                $existingQ[] = (int)$r['question_id'];
            }
            sort($existingQ);

            if ($selectedQuestions === $existingQ) {
                $duplicateFound = true;
                break;
            }
        }

        if ($duplicateFound) {
            echo "This paper already exists!";
            exit();
        } else {
            // 2️⃣ Insert paper
            $stmt_insert = $con->prepare("INSERT INTO tbl_paper (subject_code, total_mark, create_by, clg_name, exam_name, exam_time, end_time, exam_date, blWeightageData, chapterWeightageData) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_insert->bind_param("siisssssss", $subject_code, $t_marks, $web_admin_id, $clg_name, $exam_name, $exam_time, $end_time, $exam_date, $blWeightageData, $chapterWeightageData);
            $stmt_insert->execute();
            $paper_id = $stmt_insert->insert_id;

            if (!$paper_id) {
                echo "Failed to insert paper!";
                exit();
            }

            // 3️⃣ Insert questions
            foreach ($idsAndData as $entry) {
                list($questionId, $blLevel, $seq) = explode('-', $entry);
                $stmt_pq = $con->prepare("INSERT INTO tbl_paper_question (paper_id, question_id, sequence_no, bl_level) VALUES (?, ?, ?, ?)");
                $stmt_pq->bind_param("iiis", $paper_id, $questionId, $seq, $blLevel);
                $stmt_pq->execute();
            }

            echo "Data inserted successfully!";
            exit();
        }
    } else {
        echo "Invalid request method!";
        exit();
    }
} else {
    echo "You are not authorized!";
    exit();
}