<?php
include '../include/checklogin.php';
include '../../database/connect.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $clg_name = $_POST['clg_name'] ?? '';
        $exam_name = $_POST['exam_name'] ?? '';
        $exam_time = $_POST['exam_time'] ?? '';
        $end_time = $_POST['end_time'] ?? '';
        $exam_date = $_POST['exam_date'] ?? '';
        $subject_code = $_POST['subject_code'] ?? '';
        $t_marks = (int) ($_POST['t_marks'] ?? 0);
        $faculty_id = (int) ($_POST['faculty_id'] ?? 0);
        $level_id = (int) ($_POST['level_id'] ?? 0);
        $program_id = (int) ($_POST['program_id'] ?? 0);
        $sem = (int) ($_POST['sem'] ?? 0);
        $create_by = (int) ($_SESSION['web_admin_id'] ?? 0);

        // 🔎 Step 1: Duplicate check (same header info)
        $dupCheck = $con->prepare("
            SELECT paper_id 
            FROM tbl_paper_mcq 
            WHERE is_active=1
              AND faculty_id=? 
              AND level_id=? 
              AND program_id=? 
              AND sem=? 
              AND subject_code=? 
              AND t_marks=?
            LIMIT 1
        ");

        $dupCheck->bind_param(
            "siiisi",
            $faculty_id,
            $level_id,
            $program_id,
            $sem,
            $subject_code,
            $t_marks
        );

        $dupCheck->execute();
        $dupCheck->store_result();

        if ($dupCheck->num_rows > 0) {
            echo json_encode([
                "status" => "error",
                "message" => "⚠️ A paper with the same details already exists!"
            ]);
            exit;
        }
        $dupCheck->close();

        // ✅ Step 2: Insert into tbl_paper_mcq
        $stmt = $con->prepare("
            INSERT INTO tbl_paper_mcq 
            (clg_name, exam_name, exam_date, exam_time, end_time, faculty_id, level_id, program_id, sem, subject_code, t_marks, created_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $con->error);
        }

        $stmt->bind_param(
            "ssssssiiisis",
            $clg_name,
            $exam_name,
            $exam_date,
            $exam_time,
            $end_time,
            $faculty_id,
            $level_id,
            $program_id,
            $sem,
            $subject_code,
            $t_marks,
            $create_by
        );


        if (!$stmt) {
            echo json_encode([
                "status" => "error",
                "message" => "❌ Database prepare failed: " . $con->error
            ]);
            exit;
        }

        if (!$stmt->execute()) {
            echo json_encode([
                "status" => "error",
                "message" => "❌ Failed to save paper: " . $stmt->error
            ]);
            exit;
        }

        $paperId = $con->insert_id;
        $questions_saved = 0;

        $selectedQuestions = json_decode($_POST['checkboxID'] ?? '[]', true);
        if ($selectedQuestions === null && !empty($_POST['checkboxID'])) {
            echo json_encode([
                "status" => "error",
                "message" => "⚠️ Invalid question data format. Please try again."
            ]);
            exit;
        }

        // ✅ Step 3: Insert selected questions
        if (!empty($selectedQuestions)) {
            $stmt2 = $con->prepare("
                INSERT INTO tbl_paper_mcq_question (paper_id, question_id, marks, sequence_no) 
                VALUES (?, ?, ?, ?)
            ");

            if (!$stmt2) {
                echo json_encode([
                    "status" => "error",
                    "message" => "❌ Prepare failed for questions: " . $con->error
                ]);
                exit;
            }

            foreach ($selectedQuestions as $q) {
                $qid = (int) ($q['id'] ?? 0);
                $marks = (int) ($q['marks'] ?? 0);
                $seqNo = (int) ($q['sequence_no'] ?? 0);

                if (!$stmt2->bind_param("iiii", $paperId, $qid, $marks, $seqNo)) {
                    echo json_encode([
                        "status" => "error",
                        "message" => "❌ Bind failed for question ID $qid: " . $stmt2->error
                    ]);
                    exit;
                }

                if (!$stmt2->execute()) {
                    echo json_encode([
                        "status" => "error",
                        "message" => "❌ Failed to save question ID $qid: " . $stmt2->error
                    ]);
                    exit;
                }
            }
        }


        echo json_encode([
            "status" => "success",
            "message" => "✅ Paper saved successfully!",
            "paper_id" => $paperId,
            "questions_saved" => $questions_saved
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
    }
}