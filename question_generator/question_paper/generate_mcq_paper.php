<?php
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- ClockPicker CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
    <!-- /.CKeditor custom script -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
    <div class="wrapper">

        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Generate MCQ Question Paper</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Generate MCQ Question Paper</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">

                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Generate MCQ Question Paper</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group row">

                                            <div class="form-group col-md-4">
                                                <label for="clg_name">College Name <span
                                                        style="color: red;">*</span></label>
                                                <select name="clg_name" class="form-control" id="clg_name" required>
                                                    <option value="" disabled selected>Select a College</option>
                                                    <option value="Gyanmanjari Institute of Technology">Gyanmanjari
                                                        Institute of Technology</option>
                                                    <option value="Gyanmanjari Diploma Engineering College">Gyanmanjari
                                                        Diploma Engineering College</option>
                                                    <option value="Gyanmanjari Pharmacy College">Gyanmanjari Pharmacy
                                                        College</option>
                                                    <option value="Gyanmanjari Science College">Gyanmanjari Science
                                                        College</option>
                                                    <option value="Gyanmanjari Institute of Commerce">Gyanmanjari
                                                        Institute of Commerce</option>
                                                    <option value="Gyanmanjari Institute of Management Studies">
                                                        Gyanmanjari Institute of Management Studies</option>
                                                    <option value="Gyanmanjari Institute of Arts">Gyanmanjari Institute
                                                        of Arts</option>
                                                    <option value="Gyanmanjari College of Computer Application">
                                                        Gyanmanjari College of Computer Application</option>
                                                    <option value="Gyanmanjari Institute of Design">Gyanmanjari
                                                        Institute of Design</option>
                                                    <option value="Gyanmanjari Institute of Home Science">Gyanmanjari
                                                        Institute of Home Science</option>
                                                    <option
                                                        value="Gyanmanjari Institute of Medical Science and Health Care">
                                                        Gyanmanjari Institute of Medical Science and Health Care
                                                    </option>
                                                    <option value="Gyanmanjari Institute of Social Work">Gyanmanjari
                                                        Institute of Social Work</option>
                                                    <option value="Gyanmanjari Institute of Hotel Management">
                                                        Gyanmanjari Institute of Hotel Management</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="exam_name">Exam Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" name="exam_name" class="form-control" id="exam_name"
                                                    placeholder="ex. B.Tech.- End Semester Examination (ESE)-Summer-2024"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="exam_time">Start Time <span
                                                        style="color: red;">*</span></label>
                                                <div class="input-group clockpicker">
                                                    <input type="text" name="exam_time" class="form-control"
                                                        id="exam_time" placeholder="Enter time" required>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="end_time">End Time <span
                                                        style="color: red;">*</span></label>
                                                <div class="input-group clockpicker">
                                                    <input type="text" name="end_time" class="form-control"
                                                        id="end_time" placeholder="Enter time" required>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="exam_date">Exam Date <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" name="exam_date" class="form-control" id="exam_date"
                                                    placeholder="Enter Date" required>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>Select Faculty<span style="color: red;"> *</span></label>
                                                <select class="form-control" name="faculty_id" required id="faculty_id">
                                                    <option value="">---Select Faculty---</option>
                                                    <?php
                                                    $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $faculty_id = $row['faculty_id'];
                                                    ?>

                                                    <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                        <?php echo $row['name'] ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>

                                            <div class="form-group col-md-4 ">
                                                <label>Select Level<span style="color: red;"> *</span></label>
                                                <select name="level_id" id="level_id" class="form-control" required>
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4 ">
                                                <label>Select Program<span style="color: red;"> *</span></label>
                                                <select name="program_id" id="program_id" class="form-control" required>
                                                    <option value="">---Select Program---</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4 ">
                                                <label>Select sem<span style="color: red;"> *</span></label>
                                                <select name="sem" id="sem" class="form-control" required>
                                                    <option value=""> --- Semester--- </option>
                                                    <option value="1"> Semester 1</option>
                                                    <option value="2"> Semester 2</option>
                                                    <option value="3"> Semester 3</option>
                                                    <option value="4"> Semester 4</option>
                                                    <option value="5"> Semester 5</option>
                                                    <option value="6"> Semester 6</option>
                                                    <option value="7"> Semester 7</option>
                                                    <option value="8"> Semester 8</option>
                                                </select>
                                            </div>

                                            <!-- Add this inside your form -->
                                            <div class="form-group col-md-4 ">
                                                <label for="subject_code_id">Subject Code<span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" name="subject_code" required
                                                    id="subject_code_id">
                                                    <option value="">---Select subject Code---</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4 ">
                                                <label for="t_marks">Total Marks <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" name="t_marks" required id="t_marks">
                                                    <option value="0">---Select Total Marks---</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <button type="button" name="show" class="btn btn-primary">show </button>
                                            </div>

                                            <div class="form-group col-md-12" id="questionContainer"></div>

                                            <div id="previewSection" style="display: none; width: 100%;">
                                                <h4>Preview Questions</h4>
                                                <table class="table table-bordered">
                                                    <colgroup>
                                                        <col style="width: 10%;">
                                                        <col style="width: 10%;">
                                                        <col style="width: 70%;">
                                                        <col style="width: 10%;">
                                                    </colgroup>
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Chapter</th>
                                                            <th>Question</th>
                                                            <th>Marks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="previewQuestions"></tbody>
                                                </table>

                                                <div class="form-check mt-3">
                                                    <input type="checkbox" class="form-check-input" id="confirmCheck">
                                                    <label class="form-check-label" for="confirmCheck">I confirm the
                                                        selected questions</label>
                                                </div>

                                                <button type="button" id="generateBtn" class="btn btn-success mt-3"
                                                    disabled>
                                                    Generate Paper
                                                </button>
                                            </div>

                                            <input type="hidden" id="checkboxID" name="checkboxID" value="">

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
                <!-- </div>/.container-fluid -->
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include '../include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <?php include '../include/importjs.php'; ?>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- Bootstrap JS for ClockPicker -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <!-- ClockPicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
    <script>
    $(function() {
        // Attach datepicker to exam_date input
        $("#exam_date").datepicker({
            dateFormat: "yy-mm-dd", // format YYYY-MM-DD
            minDate: 0 // 0 = today, no past dates
        });
    });
    </script>
    <!-- Config FIRST -->
    <script>
    window.apiConfig = {
        apiUrl: "<?php echo $base_url_api; ?>",
        questionUrl: "<?php echo $base_url_question_paper; ?>"

    };
    window.examConfig = {
        chapterLimits: <?php echo json_encode($limits ?? []); ?>,
        totalMarks: <?= (int)($totalMarks ?? 0) ?>
    };
    </script>
    <script src="js/form_ui.js"></script>
    <script src="js/fetch_questions.js"></script>
    <script src="js/question_selection.js"></script>
    <!-- <script src="js/form_submit.js"></script> -->

    <script>
    $(document).ready(function() {
        // Hide preview section initially
        $("#previewSection").hide();
        $("#previewBtn").hide(); // hide preview button initially

        // Function to check whether Preview button should show
        function checkPreviewButton() {
            let totalMarks = parseInt($("#t_marks").val().trim(), 10) || 0;
            let selectedMarks = 0;

            $(".q-check:checked").each(function() {
                let marks = parseInt($(this).closest("tr").data("marks"), 10) || 0;
                selectedMarks += marks;

            });

            if (selectedMarks === totalMarks && totalMarks > 0) {
                $("#previewBtn").show();
            } else {
                $("#previewBtn").hide();
            }
        }

        // Watch for question checkbox selection (delegated for dynamic content)
        $(document).on("change", ".q-check", function() {
            checkPreviewButton();
        });

        // Handle Preview button click (delegated for dynamic button)
        $(document).on("click", "#previewBtn", function() {
            let selectedData = [];
            let rowsHtml = "";
            let srNo = 1;

            $(".q-check:checked").each(function() {
                let row = $(this).closest("tr");
                let qid = $(this).data("qid");
                let chap = row.data("chapter");
                let marks = row.data("marks");
                let question = row.find(".q-text").html();

                selectedData.push({
                    id: qid,
                    chapter: chap,
                    marks: marks,
                    sequence_no: srNo
                });

                rowsHtml += `
                    <tr data-qid="${qid}" data-chapter="${chap}" data-marks="${marks}">
                        <td>
                            <input type="number" class="form-control seq-input" value="${srNo}" min="1">
                            <small class="error-text text-danger" style="display:none;"></small>
                        </td>
                        <td>${chap}</td>
                        <td class="q-text">${question}</td>
                        <td>${marks}</td>
                    </tr>`;
                srNo++;
            });

            if (selectedData.length === 0) {
                Swal.fire("⚠️ Please select at least one question!", "", "warning");
                return;
            }

            $("#previewQuestions").html(rowsHtml);
            $("#checkboxID").val(JSON.stringify(selectedData)); // ✅ Save JSON
            $("#previewSection").show();
        });


        // When user edits sequence numbers, update hidden field
        $(document).on("input", ".seq-input", function() {
            let values = [];
            let duplicates = {};

            // Reset all error messages
            $(".error-text").hide().text("");

            $(".seq-input").each(function() {
                let val = $(this).val().trim();
                if (val !== "") {
                    if (values.includes(val)) {
                        duplicates[val] = true; // mark duplicate
                    }
                    values.push(val);
                }
            });

            // Show error only for duplicate values
            $(".seq-input").each(function() {
                let val = $(this).val().trim();
                if (val !== "" && duplicates[val]) {
                    $(this).siblings(".error-text")
                        .text("⚠️ Duplicate number not allowed")
                        .show();
                }
            });
        });


        // 2. Enable Generate button when user confirms selection
        $("#confirmCheck").on("change", function() {
            $("#generateBtn").prop("disabled", !this.checked);
        });

        // 3. AJAX to save paper
        $(document).on("click", "#generateBtn", function() {
            let selectedData = [];
            $("#previewQuestions tr").each(function() {
                let qid = $(this).data("qid");
                let chap = $(this).data("chapter");
                let marks = $(this).data("marks");
                let seqNo = parseInt($(this).find(".seq-input").val(), 10) || 0;

                selectedData.push({
                    id: String(qid).trim(),
                    chapter: chap,
                    marks: marks,
                    sequence_no: seqNo
                });
            });
            // Update hidden field
            $("#checkboxID").val(JSON.stringify(selectedData));

            console.log("✅ Generate Paper clicked");
            // Disable button immediately to avoid double click
            $("#generateBtn").prop("disabled", true).text("Saving...");
            // Serialize form data
            let formData = $("form#quickForm").serialize();
            console.log("📤 Form Data Sent:", formData);

            $.ajax({
                url: "save_paper.php",
                type: "POST",
                data: formData,
                dataType: "json", // expecting JSON back
                success: function(res) {
                    if (res.status === "success") {
                        Swal.fire("✅ Saved!", res.message, "success").then(() => {
                            window.location.href = "view_generate_mcqpaper.php";
                        });
                    } else {
                        Swal.fire("⚠️ Error", res.message, "warning");
                        $("#generateBtn").prop("disabled", false).text("Generate Paper");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire("❌ Error", "Check console for details", "error");
                    $("#generateBtn").prop("disabled", false).text("Generate Paper");
                }
            });
        });

    });
    </script>

</body>

</html>