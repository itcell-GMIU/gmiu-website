<?php
include '../include/checklogin.php';

$previewData = [];
$errorMessage = "";

if (isset($_POST['confirm_upload']) && isset($_POST['csv_data'])) {
    $data = json_decode($_POST['csv_data'], true);
    $subject_code = $_POST['subject_code'];
    $create_by = $_SESSION['web_admin_id'];

    // ✅ Check if MCQs already exist for this subject
    $checkStmt = $con->prepare("SELECT COUNT(*) AS cnt FROM tbl_questions 
                                WHERE subject_code=? AND is_active=1 AND is_delete=0 and (marks = '1' OR marks = '2') ");
    $checkStmt->bind_param("s", $subject_code);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result()->fetch_assoc();
    $hasOldData = ($checkResult['cnt'] > 0); // ✅ true if data exists

    // 🔹 If data exists, show modal (handled in HTML/JS below)
    if ($hasOldData && !isset($_POST['replace_confirmed'])) {
        // store data in session and redirect to show modal
        $_SESSION['csv_data_temp'] = $_POST['csv_data'];
        $_SESSION['subject_code_temp'] = $subject_code;
        header("Location: " . $_SERVER["PHP_SELF"] . "?replace=1");
        exit;
    }

    if (isset($_POST['replace_confirmed'])) {
        // ✅ Always fetch subject_code from session
        $subject_code = $_SESSION['subject_code_temp'];

        // Mark old records inactive
        $updateStmt = $con->prepare("UPDATE tbl_questions SET is_active=0, is_delete=1 WHERE subject_code=? and (marks = '1' OR marks = '2') AND is_active=1 AND is_delete=0 ");
        $updateStmt->bind_param("s", $subject_code);
        $updateStmt->execute();

        // Restore CSV data
        $data = json_decode($_SESSION['csv_data_temp'], true);

        // Clear session
        unset($_SESSION['csv_data_temp'], $_SESSION['subject_code_temp']);
    }

    if (isset($_POST['keep_old'])) {
        // ✅ Just restore CSV data without disabling old records
        $subject_code = $_SESSION['subject_code_temp'];
        $data = json_decode($_SESSION['csv_data_temp'], true);

        unset($_SESSION['csv_data_temp'], $_SESSION['subject_code_temp']);
    }

    // ✅ Insert new rows
    $stmt = $con->prepare("INSERT INTO tbl_questions 
        (subject_code, chapter, question, mcq_choice_a, mcq_choice_b, mcq_choice_c, mcq_choice_d, marks, create_by) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $inserted = 0;
    foreach ($data as $row) {
        if ($row['valid']) {
            $stmt->bind_param(
                "sssssssii",
                $subject_code,
                $row['unit_no'],
                $row['question'],
                $row['a'],
                $row['b'],
                $row['c'],
                $row['d'],
                $row['mark'],
                $create_by
            );
            if ($stmt->execute()) {
                $inserted++;
            }
        }
    }

    $_SESSION['status'] = ($inserted > 0)
        ? "✅ $inserted rows inserted successfully!"
        : "❌ No rows inserted!";
    $_SESSION['status_code'] = ($inserted > 0) ? "success" : "error";

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <meta charset="UTF-8">
    <style>

    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="m-0">Add Question Bank</h1>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    <div class="card card-gmiu">
                        <div class="card-header h-100">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h3 class="card-title h-100 mt-1">Upload CSV</h3>
                                </div>
                                <div class="col-sm-9 text-right">
                                    <a class="btn btn-dark p-1" href="question_bank.csv" download="question_bank.csv"><i class="fa fa-download"></i> Download Sample csv</a>
                                </div>

                            </div>
                        </div>


                        <div class="card-body">
                            <!-- Faculty / Level / Program / Sem / Subject Code -->
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Select Faculty<span style="color:red;">*</span></label>
                                    <select class="form-control" name="faculty_id" id="faculty_id" required>
                                        <option value="">---Select Faculty---</option>
                                        <?php
                                        $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                        $stmt = $con->prepare($cmd);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Select Level<span style="color:red;">*</span></label>
                                    <select name="level_id" id="level_id" class="form-control" required>
                                        <option value="">---Select Level---</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Select Program<span style="color:red;">*</span></label>
                                    <select name="program_id" id="program_id" class="form-control" required>
                                        <option value="">---Select Program---</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Select Semester<span style="color:red;">*</span></label>
                                    <select name="sem" id="sem" class="form-control" required>
                                        <option value="">---Select Semester---</option>
                                        <option value="1">Semester 1</option>
                                        <option value="2">Semester 2</option>
                                        <option value="3">Semester 3</option>
                                        <option value="4">Semester 4</option>
                                        <option value="5">Semester 5</option>
                                        <option value="6">Semester 6</option>
                                        <option value="7">Semester 7</option>
                                        <option value="8">Semester 8</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="subject_code_id">Subject Code<span style="color:red;">*</span></label>
                                    <select class="form-control" name="subject_code" required id="subject_code_id">
                                        <option value="">---Select Subject Code---</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="csv_file">Upload CSV<span style="color:red">*</span></label>
                                    <input type="file" name="csv_file" class="form-control" id="csv_file" accept=".csv" required>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="button" id="previewBtn" class="btn btn-info">Preview</button>
                                </div>
                            </div>

                            <div id="previewSection" style="display:none; overflow-x:auto;" class="m-3">
                                <h4>📄 CSV Preview</h4>
                                <table class="table table-bordered" id="previewTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Unit No</th>
                                            <th>Question</th>
                                            <th>Choice A</th>
                                            <th>Choice B</th>
                                            <th>Choice C</th>
                                            <th>Choice D</th>
                                            <th>Total Mark</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <form method="POST" id="confirmForm">
                                    <input type="hidden" name="csv_data" id="confirm_csv_data">
                                    <input type="hidden" name="subject_code" id="confirm_subject_code">
                                    <button type="button" id="finalUploadBtn" class="btn btn-primary">Confirm Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="replaceModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Replace MCQ Data?</h5>
                                </div>
                                <div class="modal-body">
                                    MCQ data already exists for this subject. Do you want to replace it?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" id="keepOldBtn" class="btn btn-success">Keep Old Data</button>
                                    <button type="button" id="confirmReplaceBtn" class="btn btn-danger">Yes, Replace</button>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </section>
        </div>
    </div>

    <?php include '../include/importfooter.php'; ?>
    <?php include '../include/importjs.php'; ?>
    <?php if (isset($_GET['replace'])): ?>

        <script>
            $(document).ready(function() {
                $("#replaceModal").modal("show");
            });
        </script>
        <script>
            document.getElementById("confirmReplaceBtn").addEventListener("click", function() {
                // ✅ Append a hidden field to confirm replace
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "<?php echo $_SERVER['PHP_SELF']; ?>";

                form.innerHTML = `
                        <input type="hidden" name="confirm_upload" value="1">
                        <input type="hidden" name="replace_confirmed" value="1">
                        <input type="hidden" name="csv_data" value='${document.getElementById("confirm_csv_data").value}'>
                        <input type="hidden" name="subject_code" value="${document.getElementById("confirm_subject_code").value}">
                `;
                document.body.appendChild(form);
                form.submit();
            });
            document.getElementById("keepOldBtn").addEventListener("click", function() {
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "<?php echo $_SERVER['PHP_SELF']; ?>";

                form.innerHTML = `
                    <input type="hidden" name="confirm_upload" value="1">
                    <input type="hidden" name="keep_old" value="1">
                    <input type="hidden" name="csv_data" value='${document.getElementById("confirm_csv_data").value}'>
                    <input type="hidden" name="subject_code" value="${document.getElementById("confirm_subject_code").value}">
                `;
                document.body.appendChild(form);
                form.submit();
            });
        </script>
    <?php endif; ?>


    <script>
        let csvData = [];

        document.getElementById('previewBtn').addEventListener('click', function() {
            let file = document.getElementById('csv_file').files[0];
            if (!file) {
                alert("Please select a CSV file");
                return;
            }

            let reader = new FileReader();
            reader.onload = function(e) {
                function parseCSVLine(line) {
                    const result = [];
                    let current = "";
                    let insideQuotes = false;
                
                    for (let i = 0; i < line.length; i++) {
                        let char = line[i];
                
                        if (char === '"' ) {
                            insideQuotes = !insideQuotes;
                            continue;
                        }
                
                        if (char === "," && !insideQuotes) {
                            result.push(current.trim());
                            current = "";
                        } else {
                            current += char;
                        }
                    }
                    result.push(current.trim());
                    return result;
                }

                let rows = e.target.result.split("\n").map(r => r.trim()).filter(r => r !== "");
                let headers = rows[0].split(",");
                let expected = ["unit_no", "mcq_question", "mcq_choice_a", "mcq_choice_b", "mcq_choice_c", "mcq_choice_d", "total_mark"];

                if (headers.join(",") !== expected.join(",")) {
                    Swal.fire({
                        icon: "error",
                        title: "Invalid CSV Format!",
                        text: "Expected: " + expected.join(", "),
                        confirmButtonText: "OK"
                    });
                    return;
                }

                csvData = [];
                let tbody = document.querySelector("#previewTable tbody");
                tbody.innerHTML = "";

                for (let i = 1; i < rows.length; i++) {
                    // let cols = rows[i].split(",");
                    let cols = parseCSVLine(rows[i]);

                    if (cols.length < 7) continue;

                    let mark = cols[6].trim();
                    let isValid = (mark === "1" || mark === "2");

                    csvData.push({
                        unit_no: cols[0],
                        question: cols[1],
                        a: cols[2],
                        b: cols[3],
                        c: cols[4],
                        d: cols[5],
                        mark: mark,
                        valid: isValid
                    });

                    tbody.innerHTML += `
                <tr>
                    <td>${cols[0]}</td><td>${cols[1]}</td><td>${cols[2]}</td>
                    <td>${cols[3]}</td><td>${cols[4]}</td><td>${cols[5]}</td>
                    <td>${mark}</td><td>${isValid ? "✅ OK" : "❌ Invalid"}</td>
                </tr>`;
                }

                document.getElementById("confirm_csv_data").value = JSON.stringify(csvData);
                document.getElementById("confirm_subject_code").value = document.getElementById("subject_code_id").value;
                document.getElementById("previewSection").style.display = "block";
            };
            reader.readAsText(file);
        });

        // ✅ Faculty → Level → Program → Subject Code Ajax
        $('#faculty_id').on('change', function() {
            var path = '<?php echo "$base_url_api"; ?>';
            $.post(path + 'level.php', {
                faculty_data: this.value
            }, function(res) {
                $('#level_id').html(res);
            });
        });

        $('#level_id').on('change', function() {
            var path = '<?php echo "$base_url_api"; ?>';
            $.post(path + 'program.php', {
                level_data: this.value,
                faculty_data: $('#faculty_id').val()
            }, function(res) {
                $('#program_id').html(res);
            });
        });

        function loadSubjectCodes() {
            var path = '<?php echo $base_url_question_paper; ?>';
            $.post(path + 'get_subject_codes.php', {
                faculty_id: $('#faculty_id').val(),
                level_id: $('#level_id').val(),
                program_id: $('#program_id').val(),
                sem: $('#sem').val()
            }, function(res) {
                $('#subject_code_id').html(res);
            });
        }

        $('#faculty_id, #level_id, #program_id, #sem').on('change', loadSubjectCodes);


        $(document).on("click", "#finalUploadBtn", function() {
            let subject_code = document.getElementById("subject_code_id").value;

            if (!subject_code) {
                Swal.fire("⚠️ Please select subject code!", "", "warning");
                return;
            }

            $("#confirmForm").append('<input type="hidden" name="confirm_upload" value="1">');
            $("#confirmForm").submit();
        });
    </script>
</body>

</html>