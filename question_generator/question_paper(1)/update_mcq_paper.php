<?php
include '../include/checklogin.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid Request");
}

$paperId   = $_POST['paper_id'] ?? 0;
$clg_name  = $_POST['clg_name'] ?? '';
$exam_name = $_POST['exam_name'] ?? '';
$exam_date = $_POST['exam_date'] ?? '';
$exam_time = $_POST['exam_time'] ?? '';
$end_time  = $_POST['end_time'] ?? '';
$questions = $_POST['questions'] ?? [];

if (!$paperId) {
    die("Missing Paper ID");
}

// ---- Update Paper Metadata ----
$stmt = $con->prepare("
    UPDATE tbl_paper_mcq
    SET clg_name = ?, exam_name = ?, exam_date = ?, exam_time = ?, end_time = ?
    WHERE paper_id = ?
");
$stmt->bind_param("sssssi", $clg_name, $exam_name, $exam_date, $exam_time, $end_time, $paperId);
$stmt->execute();
$stmt->close();

// ---- Update Questions ----
foreach ($questions as $qid => $data) {
    $sequence_no = $data['sequence_no'] ?? null;
    $question    = $data['question'] ?? '';
    $a           = $data['mcq_choice_a'] ?? '';
    $b           = $data['mcq_choice_b'] ?? '';
    $c           = $data['mcq_choice_c'] ?? '';
    $d           = $data['mcq_choice_d'] ?? '';

    // New JSON data from user input
    $newData = [
        'question'      => $question,
        'mcq_choice_a'  => $a,
        'mcq_choice_b'  => $b,
        'mcq_choice_c'  => $c,
        'mcq_choice_d'  => $d
    ];
    $newJson = json_encode($newData, JSON_UNESCAPED_UNICODE);

    // ---- Fetch existing sequence + question_data ----
    $stmtSel = $con->prepare("
        SELECT sequence_no, question_data 
        FROM tbl_paper_mcq_question
        WHERE paper_id = ? AND question_id = ?
    ");
    $stmtSel->bind_param("ii", $paperId, $qid);
    $stmtSel->execute();
    $stmtSel->bind_result($oldSequence, $oldJson);
    $stmtSel->fetch();
    $stmtSel->close();

    // If no custom data yet, load from master question bank
    if (!$oldJson) {
        $stmtQ = $con->prepare("
            SELECT question, mcq_choice_a, mcq_choice_b, mcq_choice_c, mcq_choice_d
            FROM tbl_questions
            WHERE id = ?
        ");
        $stmtQ->bind_param("i", $qid);
        $stmtQ->execute();
        $stmtQ->bind_result($qText, $qa, $qb, $qc, $qd);
        $stmtQ->fetch();
        $stmtQ->close();

        $oldData = [
            'question'      => $qText,
            'mcq_choice_a'  => $qa,
            'mcq_choice_b'  => $qb,
            'mcq_choice_c'  => $qc,
            'mcq_choice_d'  => $qd
        ];
        $oldJsonNormalized = json_encode($oldData, JSON_UNESCAPED_UNICODE);
    } else {
        // Normalize old JSON
        $oldJsonNormalized = json_encode(json_decode($oldJson, true), JSON_UNESCAPED_UNICODE);
    }

    // ---- Update only if something changed ----
    if ($oldJsonNormalized !== $newJson || (int)$oldSequence !== (int)$sequence_no) {
        $stmtUpd = $con->prepare("
            UPDATE tbl_paper_mcq_question
            SET sequence_no = ?, question_data = ?
            WHERE paper_id = ? AND question_id = ?
        ");
        $stmtUpd->bind_param("isii", $sequence_no, $newJson, $paperId, $qid);
        $stmtUpd->execute();
        $stmtUpd->close();
    }
}


// ---- Redirect back ----
header("Location: view_generate_mcqpaper.php?id=" . $paperId . "&success=1");
exit;
