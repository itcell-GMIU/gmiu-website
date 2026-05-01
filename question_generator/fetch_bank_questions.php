<?php
include '../database/connect.php';

// Input
$subjectCode = $_POST['subject_code'] ?? '';
$totalMarks = isset($_POST['t_marks']) ? (int) $_POST['t_marks'] : 0;

if (!$subjectCode || !$totalMarks) {
    die("Invalid request");
}

// ---------- Fetch Functions ----------
function getChapters($con, $subjectCode)
{
    $stmt = $con->prepare("
        SELECT id, chapter, chapter_weight 
        FROM tbl_weightage 
        WHERE subject_code = ? AND is_delete = '0'
    ");
    $stmt->bind_param("s", $subjectCode);
    $stmt->execute();
    $res = $stmt->get_result();
    $chapters = $res->fetch_all(MYSQLI_ASSOC);

    return $chapters;
}

function getQuestions($con, $subjectCode, $chapter, $marksFilter = null)
{
    $query = "
        SELECT id, chapter, question, mcq_choice_a, mcq_choice_b, mcq_choice_c, mcq_choice_d, marks
        FROM tbl_questions
        WHERE subject_code = ? AND chapter = ? AND is_delete = '0'
    ";
    if ($marksFilter) {
        $placeholders = implode(",", array_fill(0, count($marksFilter), "?"));
        $query .= " AND marks IN ($placeholders)";
    }

    $stmt = $con->prepare($query);

    if ($marksFilter) {
        $types = "si" . str_repeat("i", count($marksFilter));
        $stmt->bind_param($types, $subjectCode, $chapter, ...$marksFilter);
    } else {
        $stmt->bind_param("si", $subjectCode, $chapter);
    }

    $stmt->execute();
    $res = $stmt->get_result();
    $questions = $res->fetch_all(MYSQLI_ASSOC);

    return $questions;
}

// ---------- Logic ----------
$chapters = getChapters($con, $subjectCode);

$questions_selected = [];
$weightage_summary = [];
$chapter_limits = [];

// Step 1: Compute exact fractional marks
$exact_marks = [];
foreach ($chapters as $chapter) {
    $chapNo = (int) $chapter['chapter'];
    $weight = (float) $chapter['chapter_weight'];
    $exact_marks[$chapNo] = ($weight / 100) * $totalMarks;
}

// Step 2: Round down initially
$chapter_marks = [];
foreach ($exact_marks as $chapNo => $exact) {
    $chapter_marks[$chapNo] = floor($exact);
}

// Step 3: Distribute remaining marks (due to rounding)
$allocated_sum = array_sum($chapter_marks);
$remaining = $totalMarks - $allocated_sum;

// Sort chapters by fractional remainder descending
$remainders = [];
foreach ($exact_marks as $chapNo => $exact) {
    $remainders[$chapNo] = $exact - floor($exact);
}
arsort($remainders);

// Assign remaining marks to chapters with largest remainders
foreach ($remainders as $chapNo => $rem) {
    if ($remaining <= 0)
        break;
    $chapter_marks[$chapNo]++;
    $remaining--;
}

// Step 4: Fetch questions per chapter according to marks
foreach ($chapters as $chapter) {
    $chapNo = (int) $chapter['chapter'];
    $weight = (float) $chapter['chapter_weight'];
    $allocatedMarks = $chapter_marks[$chapNo];
    $chapter_limits[$chapNo] = $allocatedMarks;

    // Decide question marks to fetch
    if ($totalMarks == 50) {
        // Only 1-mark questions
        $chapter_questions = getQuestions($con, $subjectCode, $chapNo, [1]);
    } else {
        // 1-mark and 2-mark questions
        $chapter_questions = getQuestions($con, $subjectCode, $chapNo, [1, 2]);
    }

    $questions_selected = array_merge($questions_selected, $chapter_questions);

    $weightage_summary[] = [
        'chapter' => $chapNo,
        'weightage' => $weight,
        'marks_allocated' => $allocatedMarks,
    ];
}

// ---------- Validate Question Availability ----------
$errors = [];

// ---------- Extra check for 60 mark paper (need 10 two-mark questions) ----------
if ($totalMarks == 60) {

    $totalTwoMarkNeeded = 10;

    // Step 1: Count total available 2-mark questions across all chapters
    $stmt = $con->prepare("
        SELECT COUNT(*) as total_two_mark
        FROM tbl_questions
        WHERE subject_code = ? AND marks = 2 AND is_delete = '0'
    ");
    $stmt->bind_param("s", $subjectCode);
    $stmt->execute();
    $totalTwoMarkAvailable = (int) $stmt->get_result()->fetch_assoc()['total_two_mark'];

    if ($totalTwoMarkAvailable < $totalTwoMarkNeeded) {
        $errors[] = "Not enough 2-mark questions overall: Need {$totalTwoMarkNeeded}, but only {$totalTwoMarkAvailable} available.";
    }

    // Step 2: Check per-chapter limit, but only warn if selecting all 2-mark questions from this chapter
    foreach ($chapters as $chapter) {
        $chapNo = (int) $chapter['chapter'];
        $allocatedMarks = $chapter_marks[$chapNo];

        $maxTwoMarkThisChapter = floor($allocatedMarks / 2);

        $stmt = $con->prepare("
            SELECT COUNT(*) as cnt
            FROM tbl_questions
            WHERE subject_code = ? AND chapter = ? AND is_delete = '0' AND marks = 2
        ");
        $stmt->bind_param("si", $subjectCode, $chapNo);
        $stmt->execute();
        $availableForThisChapter = (int) $stmt->get_result()->fetch_assoc()['cnt'];

        if ($availableForThisChapter < $maxTwoMarkThisChapter) {
            $errors[] = "Chapter {$chapNo} has more 2-mark questions ({$availableForThisChapter}) than allocated marks allow ({$allocatedMarks}). You can still select from other chapters to meet total 10 two-mark questions.";
        }
    }
}


foreach ($weightage_summary as $ws) {
    $chap = $ws['chapter'];
    $allocated = (int) $ws['marks_allocated'];

    // sum of available questions' marks for this chapter
    $stmt = $con->prepare("
        SELECT COALESCE(SUM(marks),0) as total_marks
        FROM tbl_questions
        WHERE subject_code = ? AND chapter = ? AND is_delete = '0'
          AND marks IN (" . ($totalMarks == 50 ? "1" : "1,2") . ")
    ");
    $stmt->bind_param("si", $subjectCode, $chap);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    $availableMarks = (int) $res['total_marks'];

    if ($availableMarks < $allocated) {
        $errors[] = "Chapter {$chap}: Needs {$allocated} marks, only {$availableMarks} available.";
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Question Bank</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
    }

    th,
    td {
        padding: 4px 10px;
        border: 1px solid #ccc;
        text-align: left;
    }

    thead {
        background: #f4f4f4;
    }

    .badge {
        padding: 3px 6px;
        border-radius: 4px;
        font-size: 12px;
        color: #fff;
    }

    .blue {
        background: #007bff;
    }

    .green {
        background: #28a745;
    }

    .orange {
        background: #fd7e14;
    }

    .summary-container {
        position: sticky;
        bottom: 0;
        background: #fafafa;
        padding: 10px;
        border: 1px solid #ddd;
        z-index: 1000;
    }

    .summary-table th {
        background: #e9ecef;
        text-align: center;
        font-size: 14px;
    }

    .summary-table td {
        font-size: 14px;
    }

    .summary-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
        font-size: 14px;
        font-weight: bold;
    }

    .summary-header .title {
        color: #333;
    }

    .summary-header .remaining-marks {
        color: #007bff;
    }

    .q-check {
        transform: scale(1.3);
        margin: 5px;
        cursor: pointer;
    }

    /* button {
            margin: 8px;
            padding: 8px 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        } */

    #autoSelect {
        background: #28a745;
        color: #fff;
    }

    #savePaper {
        background: #007bff;
        color: #fff;
    }

    #questions-table {
        table-layout: fixed;
        /* force columns to respect set widths */
        width: 100%;
        word-wrap: break-word;
        /* wrap long text */
    }
    </style>
</head>

<body>
    <?php if (!empty($errors)): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Not Enough Questions!',
        html: `<?= implode("<br>", $errors) ?>`
    }).then(() => {
        $("#questionContainer").hide();
    });
    </script>
    <?php endif ?>


    <h2>📚 MCQ Question Bank</h2>
    <div style="overflow-x:auto;">
        <table id="questions-table">
            <colgroup>
                <col style="width: 5%;">
                <col style="width: 70%;">
                <col style="width: 10%;">
                <col style="width: 10%;">
                <col style="width: 5%;">
            </colgroup>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Marks</th>
                    <th>Chapter</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($questions_selected): ?>
                <?php foreach ($questions_selected as $i => $q): ?>
                <tr data-chapter="<?= $q['chapter'] ?>" data-marks="<?= $q['marks'] ?>">
                    <td><span class="badge blue">
                            <?= $i + 1 ?>
                        </span></td>

                    <!-- Merge Question + Options into one cell -->
                    <td class="q-text">
                        <?= htmlspecialchars($q['question']) ?><br>
                        (A) <?= htmlspecialchars($q['mcq_choice_a']) ?>&nbsp;&nbsp;&nbsp;
                        (B) <?= htmlspecialchars($q['mcq_choice_b']) ?><br>
                        (C)
                        <?= htmlspecialchars($q['mcq_choice_c']) ?>&nbsp;&nbsp;&nbsp;
                        (D)
                        <?= htmlspecialchars($q['mcq_choice_d']) ?>
                    </td>

                    <td><span class="badge <?= $q['marks'] == 1 ? 'blue' : 'green' ?>">
                            <?= $q['marks'] ?></span>
                    </td>
                    <td><span class="badge orange">
                            <?= $q['chapter'] ?>
                        </span></td>
                    <td><input type="checkbox" class="q-check" data-qid="
                    <?= $q['id'] ?>"></td>
                </tr>

                <?php endforeach ?>
                <?php else: ?>
                <tr>
                    <td colspan="9" style="text-align:center;">No questions available</td>
                </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>

    <div class="summary-container">
        <div class="summary-header">
            <span class="title">📊 Weightage Summary</span> <span class="remaining-marks"> <button type="button"
                    class="btn btn-success btn-sm" id="autoSelect">⚡ Auto
                    Generate Paper</button></span>
            <span class="remaining-marks">Total Marks:
                <?= $totalMarks ?>
            </span>
        </div>

        <table class="summary-table">
            <thead>
                <tr>
                    <th>Chapter</th>
                    <?php foreach ($weightage_summary as $ws): ?>
                    <th>
                        <?= $ws['chapter'] ?>
                    </th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Weightage (%)</td>
                    <?php foreach ($weightage_summary as $ws): ?>
                    <td style="text-align:center">
                        <?= $ws['weightage'] ?>%
                    </td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>Marks Allocated</td>
                    <?php foreach ($weightage_summary as $ws): ?>
                    <td style="text-align:center">
                        <?= (int) $ws['marks_allocated'] ?>
                    </td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>Questions Selected</td>
                    <?php foreach ($weightage_summary as $ws): ?>
                    <td style="text-align:center" class="selected-count" data-chap="<?= $ws['chapter'] ?>">0</td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>Marks Selected</td>
                    <?php foreach ($weightage_summary as $ws): ?>
                    <td style="text-align:center" class="selected-marks" data-chap="<?= $ws['chapter'] ?>">0</td>
                    <?php endforeach ?>
                </tr>
            </tbody>
        </table>
        <?php if ($questions_selected): ?>
        <div class="mt-3 text-right">
            <button type="button" id="previewBtn" class="btn btn-primary">Preview</button>
        </div>
        <?php endif; ?>



    </div>

    <script>
    $(document).ready(function() {
        const chapterLimits = <?= json_encode($chapter_limits) ?>;

        function checkPreviewButton() {
            let totalMarks = parseInt($("#t_marks").val().trim(), 10) || 0;
            let selectedMarks = 0;

            $(".q-check:checked").each(function() {
                let marks = parseInt($(this).closest("tr").data("marks"), 10) || 0;
                selectedMarks += marks;
                // alert("Selected Marks: " + selectedMarks); // For debugging
            });

            if (selectedMarks === totalMarks && totalMarks > 0) {
                $("#previewBtn").show();
            } else {
                $("#previewBtn").hide();
            }
        }

        // ✅ Update summary when checkbox clicked
        $(document).on('change', '.q-check', function() {
            const $checkbox = $(this);
            const chap = $checkbox.closest("tr").data("chapter");
            const marks = parseInt($checkbox.closest("tr").data("marks"));
            const chapterLimit = chapterLimits[chap];

            // Calculate current selected marks for this chapter
            let selectedMarks = 0;
            $(".q-check:checked").each(function() {
                const c = $(this).closest("tr").data("chapter");
                const m = parseInt($(this).closest("tr").data("marks"));
                if (c == chap) selectedMarks += m;
            });

            if (selectedMarks > chapterLimit) {
                // ❌ Exceeds allowed marks
                $checkbox.prop('checked', false); // revert selection
                Swal.fire({
                    icon: 'warning',
                    title: 'Limit Reached!',
                    text: `Marks allowed for Chapter ${chap} is 0 or fully used. Please check other chapter questions.`,
                });
                return;
            }

            updateSummary();
            checkPreviewButton();
        });

        function updateSummary() {
            // reset counts
            $(".selected-count").text("0");
            $(".selected-marks").text("0");

            $(".q-check:checked").each(function() {
                const chap = $(this).closest("tr").data("chapter");
                const marks = parseInt($(this).closest("tr").data("marks"));

                let $countCell = $(".selected-count[data-chap='" + chap + "']");
                let $marksCell = $(".selected-marks[data-chap='" + chap + "']");

                $countCell.text(parseInt($countCell.text()) + 1);
                $marksCell.text(parseInt($marksCell.text()) + marks);
            });
        }

        // Auto select questions with max 10 two-mark limit
        $('#autoSelect').on('click', function() {
            $('.q-check').prop('checked', false);

            const totalMarks = <?= $totalMarks ?>;
            let maxTwoMarkAllowed = (totalMarks === 60) ? 10 : 0; // only for 60 marks case
            let usedTwoMarks = 0;

            Object.keys(chapterLimits).forEach(chap => {
                let remaining = chapterLimits[chap];
                let chapterQuestions = $(`tr[data-chapter='${chap}']`).toArray();

                // 🔀 Shuffle the questions array for random selection
                chapterQuestions = chapterQuestions.sort(() => Math.random() - 0.5);

                // ✅ Step 1: Select 2-mark questions first (but not exceeding max limit)
                chapterQuestions.forEach(row => {
                    if (remaining <= 0) return;
                    const marks = parseInt($(row).data('marks'));

                    if (marks === 2 && usedTwoMarks < maxTwoMarkAllowed && marks <=
                        remaining) {
                        $(row).find('.q-check').prop('checked', true);
                        remaining -= marks;
                        usedTwoMarks++;
                    }
                });

                // ✅ Step 2: Shuffle again & Fill remaining with 1-mark questions
                chapterQuestions = chapterQuestions.sort(() => Math.random() - 0.5);
                chapterQuestions.forEach(row => {
                    if (remaining <= 0) return;
                    const marks = parseInt($(row).data('marks'));

                    if (marks === 1 && marks <= remaining) {
                        $(row).find('.q-check').prop('checked', true);
                        remaining -= marks;
                    }
                });
            });

            updateSummary();
            checkPreviewButton();

            Swal.fire("Auto Selection Done!",
                "Questions selected randomly as per weightage.",
                "success");
        });
    });
    </script>
</body>

</html>