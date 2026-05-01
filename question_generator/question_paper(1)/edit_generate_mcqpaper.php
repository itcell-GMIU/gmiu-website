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

$totalMarks = (int)($paper['t_marks'] ?? 0);

// fetch questions for this paper
$qstmt = $con->prepare("
    SELECT q.id AS pq_id, q.question_id, q.sequence_no, 
           qb.chapter, qb.question, qb.marks,
           qb.mcq_choice_a, qb.mcq_choice_b, qb.mcq_choice_c, qb.mcq_choice_d
    FROM tbl_paper_mcq_question q
    JOIN tbl_questions qb ON q.question_id = qb.id
    WHERE q.paper_id = ?
    ORDER BY qb.chapter ASC, q.sequence_no ASC
");
$qstmt->bind_param("i", $paperId);
$qstmt->execute();
$questions = $qstmt->get_result()->fetch_all(MYSQLI_ASSOC);

function e($str)
{
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- Sidebar -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit MCQ Question Paper</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit MCQ Question Paper</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <section class="content">
                <div class="container-fluid">
                    <form method="post" action="update_mcq_paper.php">
                        <input type="hidden" name="paper_id" value="<?php echo $paperId; ?>">

                        <!-- Paper Metadata -->
                        <!-- Paper Metadata -->
                        <div class="card card-gmiu">
                            <div class="card-header">
                                <h3 class="card-title">Edit MCQ Paper</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label>College Name</label>
                                    <input type="text" class="form-control"
                                        name="clg_name"
                                        value="<?php echo e($paper['clg_name']); ?>">
                                </div>

                                <div class="form-group">
                                    <label>Exam Name</label>
                                    <input type="text" class="form-control"
                                        name="exam_name"
                                        value="<?php echo e($paper['exam_name']); ?>">
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Exam Date</label>
                                        <input type="date" name="exam_date" class="form-control"
                                            value="<?php echo e($paper['exam_date']); ?>">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Start Time</label>
                                        <input type="time" name="exam_time" class="form-control"
                                            value="<?php echo e($paper['exam_time']); ?>">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>End Time</label>
                                        <input type="time" name="end_time" class="form-control"
                                            value="<?php echo e($paper['end_time']); ?>">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Semester</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo e($paper['sem']); ?>" disabled>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Subject Code</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo e($paper['subject_code']); ?>" disabled>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Total Marks</label>
                                        <input type="number" class="form-control"
                                            value="<?php echo e($paper['t_marks']); ?>" disabled>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Questions -->
                        <div class="card card-gmiu">
                            <div class="card-header">
                                <h3 class="card-title">Edit Questions</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="width: 5%;">No</th>
                                                <th style="width: 8%;">SeqNo</th>
                                                <th style="width: 3%;">Mark</th>
                                                <th style="width: 25%;">Question</th>
                                                <th style="width: 15%;">Choice A</th>
                                                <th style="width: 15%;">Choice B</th>
                                                <th style="width: 15%;">Choice C</th>
                                                <th style="width: 15%;">Choice D</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($questions as $index => $q): ?>
                                                <tr>
                                                    <!-- Auto question number -->
                                                    <td><?php echo $index + 1; ?></td>

                                                    <!-- Editable sequence no -->
                                                    <td>
                                                        <input type="number" class="form-control sequence-input"
                                                            name="questions[<?php echo $q['question_id']; ?>][sequence_no]"
                                                            value="<?php echo e($q['sequence_no']); ?>">
                                                    </td>
                                                    <!-- Editable question Marks -->
                                                    <td>
                                                        <?php echo $q['marks']; ?>
                                                    </td>
                                                    <!-- Editable question text -->
                                                    <td>
                                                        <textarea class="form-control" rows="2"
                                                            name="questions[<?php echo $q['question_id']; ?>][question]"><?php echo e($q['question']); ?></textarea>
                                                    </td>


                                                    <!-- Editable choices as textarea -->
                                                    <td>
                                                        <textarea class="form-control" rows="2"
                                                            name="questions[<?php echo $q['question_id']; ?>][mcq_choice_a]"><?php echo e($q['mcq_choice_a']); ?></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" rows="2"
                                                            name="questions[<?php echo $q['question_id']; ?>][mcq_choice_b]"><?php echo e($q['mcq_choice_b']); ?></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" rows="2"
                                                            name="questions[<?php echo $q['question_id']; ?>][mcq_choice_c]"><?php echo e($q['mcq_choice_c']); ?></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" rows="2"
                                                            name="questions[<?php echo $q['question_id']; ?>][mcq_choice_d]"><?php echo e($q['mcq_choice_d']); ?></textarea>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                            <a href="view_mcq_paper.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>
        <?php include '../include/importjs.php'; ?>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");
        const rows = document.querySelectorAll("tbody tr");

        function showError(input, message) {
            let next = input.nextElementSibling;
            if (next && next.classList.contains("error-msg")) {
                next.remove();
            }
            let div = document.createElement("div");
            div.className = "error-msg";
            div.innerText = message;
            input.insertAdjacentElement("afterend", div);
        }

        function clearError(input) {
            let next = input.nextElementSibling;
            if (next && next.classList.contains("error-msg")) {
                next.remove();
            }
        }

        function validateAndFill(autoFill = false) {
            let values = [];
            let hasDuplicate = false;
            let invalidRange = false;
            let emptyInputs = [];

            rows.forEach((row) => {
                const input = row.querySelector(".sequence-input");
                clearError(input);
                let val = input.value.trim();

                if (val !== "") {
                    val = parseInt(val);
                    if (val < 1 || val > 50 || isNaN(val)) {
                        invalidRange = true;
                        showError(input, "Must be between 1–50");
                    }
                    if (values.includes(val)) {
                        hasDuplicate = true;
                        showError(input, "Duplicate not allowed");
                    } else {
                        values.push(val);
                    }
                } else {
                    emptyInputs.push(input);
                }
            });

            // Auto-fill missing numbers if requested
            if (autoFill && !hasDuplicate && !invalidRange) {
                let current = 1;
                emptyInputs.forEach((input) => {
                    while (values.includes(current) && current <= 50) {
                        current++;
                    }
                    if (current <= 50) {
                        input.value = current;
                        values.push(current);
                        current++;
                    }
                });
            }

            return {
                valid: !hasDuplicate && !invalidRange,
                hasDuplicate,
                invalidRange,
                emptyInputs
            };
        }

        // 🔹 Live validation
        rows.forEach((row) => {
            const input = row.querySelector(".sequence-input");
            input.addEventListener("input", function() {
                this.value = this.value.replace(/[^0-9]/g, "");
                if (this.value.length > 2) this.value = this.value.slice(0, 2);
                if (parseInt(this.value) > 50) this.value = "50";
                validateAndFill(false);
            });
            input.addEventListener("blur", function() {
                validateAndFill(false);
            });
        });

        // 🔹 Submit with optional auto-fill
        form.addEventListener("submit", function(e) {
            let result = validateAndFill(false);

            if (!result.valid) {
                e.preventDefault();
                alert("❌ Fix errors before submitting (no duplicates, only 1–50).");
                return false;
            }

            if (result.emptyInputs.length > 0) {
                e.preventDefault();
                if (confirm("Some sequence numbers are missing. Do you want the system to auto-generate them in order?")) {
                    validateAndFill(true);
                    form.submit(); // resubmit after auto-fill
                } else {
                    alert("❌ Please fill all sequence numbers manually.");
                }
            }
        });
    });
</script>

<style>
    .error-msg {
        color: red;
        font-size: 12px;
        margin-top: 2px;
    }
</style>


</html>