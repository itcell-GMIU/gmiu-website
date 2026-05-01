<?php
include '../include/checklogin.php';

// get paper id
$paperId = $_GET['id'] ?? 0;

// fetch paper metadata
$stmt = $con->prepare("
    SELECT p.*, 
           s.subject_name, s.subject_code AS subject_code,
           f.name AS faculty_name, 
           l.name AS level_name, 
           pr.name AS program_name
    FROM tbl_paper_mcq p
    LEFT JOIN tbl_std_corner_exam s ON p.subject_code = s.id
    LEFT JOIN tbl_faculty f        ON p.faculty_id = f.id
    LEFT JOIN tbl_level l          ON p.level_id = l.id
    LEFT JOIN tbl_program pr       ON p.program_id = pr.id
    WHERE p.paper_id = ?
    LIMIT 1
");
$stmt->bind_param("i", $paperId);
$stmt->execute();
$paper = $stmt->get_result()->fetch_assoc();

if (!$paper) {
    die("Invalid Paper ID");
}

$totalMarks = (int) ($paper['t_marks'] ?? 0);

if ($totalMarks == 60) {
    // 60 marks case → first 10 are 2 marks
    $qstmt = $con->prepare("
       SELECT 
    q.question_id, 
    q.sequence_no, 
    q.question_data,
    qb.chapter, 
    qb.question, 
    qb.mcq_choice_a, 
    qb.mcq_choice_b, 
    qb.mcq_choice_c, 
    qb.mcq_choice_d,
    q.marks
FROM tbl_paper_mcq_question q
JOIN tbl_questions qb ON q.question_id = qb.id
WHERE q.paper_id = ?
ORDER BY q.marks DESC, q.sequence_no ASC;

    ");
} else {
    // For 50 marks (or others) → all are 1 mark
    $qstmt = $con->prepare("
        SELECT q.question_id, q.sequence_no, q.question_data,
               qb.chapter, qb.question, 
               qb.mcq_choice_a, qb.mcq_choice_b, qb.mcq_choice_c, qb.mcq_choice_d,
               1 AS marks
        FROM tbl_paper_mcq_question q
        JOIN tbl_questions qb ON q.question_id = qb.id
        WHERE q.paper_id = ?
        ORDER BY q.sequence_no ASC
    ");
}

$qstmt->bind_param("i", $paperId);
$qstmt->execute();
$questions = $qstmt->get_result()->fetch_all(MYSQLI_ASSOC);

// helper: safe text
function e($str)
{
    return htmlspecialchars((string) $str, ENT_QUOTES, 'UTF-8');
}

// format time like "02:30AM To 05:30PM" if values present
function fmtTime($start, $end)
{
    if (!$start && !$end)
        return '';
    $s = $start ? date('h:ia', strtotime($start)) : '';
    $e = $end ? date('h:ia', strtotime($end)) : '';
    if ($s && $e)
        return strtoupper($s) . " To " . strtoupper($e);
    return strtoupper($s ?: $e);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MCQ Paper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="paper.css">
</head>

<body>

    <div class="a4">
        <button class="noprint" onclick="window.print()">Print</button>

        <!-- Header -->
        <div class="header avoid-break">
            <h1 class="university">GYANMANJARI INNOVATIVE UNIVERSITY</h1>
            <div class="institute"><?php echo e($paper['clg_name']); ?></div>
            <div class="exam-title"><?php echo e($paper['exam_name']); ?></div>
        </div>

        <!-- Meta (student + exam details) -->
        <div class="meta avoid-break">
            <div class="left">Enrollment No.: ___________________</div>
            <div class="right">Date: <?php echo e($paper['exam_date']); ?></div>

            <div class="left">Subject Code: <?php echo e($paper['subject_code']); ?></div>
            <div class="right">Semester: <?php echo e($paper['sem']); ?></div>

            <div class="left">Subject Name: <?php echo e($paper['subject_name']); ?></div>
            <div class="right">Time: <?php echo e(fmtTime($paper['exam_time'] ?? '', $paper['end_time'] ?? '')); ?>
            </div>

            <div class="left">Total Marks: <?php echo (int) $totalMarks; ?></div>
            <div class="right"></div>
        </div>

        <!-- Instructions -->
        <div class="instructions avoid-break">
            <b>Instructions:</b>
            <ol>
                <li>All Questions are compulsory.</li>
                <li>Figures to the right indicate full marks.</li>
            </ol>
        </div>
        <!-- <div class="rule"></div> -->
        <div class="qrow qheader">
            <div class="qnum"></div>
            <div class="qcol"></div>
            <div class="marks">Marks</div>
        </div>


        <!-- Questions -->
        <?php
        $qNo = 1;
        foreach ($questions as $index => $q) {

            // prefer JSON if available
            if (!empty($q['question_data'])) {
                $custom = json_decode($q['question_data'], true);

                // fallback merge: if JSON doesn’t contain some fields, take from qb
                $qtext = $custom['question'] ?? $q['question'];
                $a = $custom['mcq_choice_a'] ?? $q['mcq_choice_a'];
                $b = $custom['mcq_choice_b'] ?? $q['mcq_choice_b'];
                $c = $custom['mcq_choice_c'] ?? $q['mcq_choice_c'];
                $d = $custom['mcq_choice_d'] ?? $q['mcq_choice_d'];
            } else {
                // fallback to original
                $qtext = $q['question'];
                $a = $q['mcq_choice_a'];
                $b = $q['mcq_choice_b'];
                $c = $q['mcq_choice_c'];
                $d = $q['mcq_choice_d'];
            }
            ?>
        <div class="qrow">
            <div class="qnum">Q.<?php echo $qNo++; ?></div>

            <div class="qcol">
                <div class="qtext"><?php echo e($qtext); ?></div>

                <div class="options">
                    <?php if (!empty($a)): ?>
                    <div class="opt" data-label="A"><?php echo e($a); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($b)): ?>
                    <div class="opt" data-label="B"><?php echo e($b); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($c)): ?>
                    <div class="opt" data-label="C"><?php echo e($c); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($d)): ?>
                    <div class="opt" data-label="D"><?php echo e($d); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="marks"><?php echo $q['marks']; ?></div>

        </div>
        <?php } ?>

    </div>

</body>

</html>