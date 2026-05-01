<?php
include '../include/checklogin.php';
$errorInPreview = false;
$errorMessages = [];
$previewData = [];
if (isset($_POST["import"])) {
    $filename = $_FILES["file"]["tmp_name"];
    if ($_FILES["file"]["size"] > 0) {

        $subject_code = mysqli_real_escape_string($con, $_POST['subject_code']);

        $rowIndex = 1;

        $file = fopen($filename, "r");
        $skipFirstRow = true;

        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
            if ($skipFirstRow) {
                $skipFirstRow = false;
                continue;
            }

            $rowIndex++;

            if (count($getData) < 5) {
                $errorInPreview = true;
                $errorMessages[] = "Row $rowIndex: Invalid number of columns. Please add all data in CSV.";
                break;
            }

            $chapter = trim($getData[0]);
            $question = trim($getData[1]);
            $marks = trim($getData[2]);
            $co_level_raw = trim($getData[3]);
            $bl_level = trim($getData[4]);

            if (empty($chapter)) {
                $errorInPreview = true;
                $errorMessages[] = "Row $rowIndex: Chapter is empty.";
                break;
            }
            if (empty($question)) {
                $errorInPreview = true;
                $errorMessages[] = "Row $rowIndex: Question is empty.";
                break;
            }
            if (!in_array($marks, ['5', '10'])) {
                $errorInPreview = true;
                $errorMessages[] = "Row $rowIndex: Marks must be 5 or 10. Found: $marks";
                break;
            }
            $co_level_clean = strtoupper(str_replace(' ', '', $co_level_raw));
            if (!preg_match('/^CO([1-9]|10)$/', $co_level_clean)) {
                $errorInPreview = true;
                $errorMessages[] = "Row $rowIndex: CO Level must be CO1 to CO10. Found: $co_level_clean";
                break;
            }
            if (empty($bl_level)) {
                $errorInPreview = true;
                $errorMessages[] = "Row $rowIndex: BL Level is empty.";
                break;
            }

            $previewData[] = $getData;
        }

        fclose($file);

        if (!$errorInPreview) {
            // No errors, now update old data
            $checkQuery = "SELECT COUNT(*) FROM tbl_questions WHERE subject_code = ?";
            $checkStmt = $con->prepare($checkQuery);
            $checkStmt->bind_param("s", $subject_code);
            $checkStmt->execute();
            $checkStmt->store_result();
            $count = $checkStmt->num_rows;

            if ($count > 0) {
                $updateQuery = "UPDATE `tbl_questions` SET is_active = 0, is_delete = 1 WHERE subject_code = ?";
                $updateStmt = $con->prepare($updateQuery);
                $updateStmt->bind_param("s", $subject_code);
                $updateStmt->execute();
                $updateStmt->close();
            }

            // Insert new data
            foreach ($previewData as $row) {
                $questionText = $row[1];
                 $co_level = strtoupper(str_replace(' ', '', $row[3]));
               if ($_SERVER['HTTP_HOST'] == 'localhost') {
                    $basePath = "http://localhost/gmiu/question_generator/question_bank/uploads/";
                } else {
                    $basePath = "https://gmiu.edu.in/gmiu/question_generator/question_bank/uploads/";
                }

                $uploadDir = __DIR__ . "/uploads/"; // Path to check files

                // ✅ Check for <img> tags in question
                if (preg_match_all('/<img>(.*?)<\/img>/', $questionText, $matches)) {
                    foreach ($matches[1] as $fileName) {

                        // ✅ Check if filename matches Y-m-d-H-i-s format
                        if (preg_match('/^\d{4}-\d{2}-\d{2}-\d{2}-\d{2}-\d{2}-/', $fileName)) {
                            $filePath = $uploadDir . $fileName;

                            // ✅ Check if file actually exists
                            if (file_exists($filePath)) {
                                $fullImageTag = '<img src="' . $basePath . $fileName . '" alt="image" style="max-width:300px; height:auto; border-radius:6px;">';
                                $questionText = str_replace("<img>$fileName</img>", $fullImageTag, $questionText);
                            } else {
                                $errorInPreview = true;
                                $errorMessages[] = "Image file '$fileName' (Row: $rowIndex) not found in uploads folder.";
                                break 2; // Stop import process
                            }
                        }
                    }
                }

                if ($errorInPreview) {
                    break;
                }

                // ✅ Insert into Database
                $stmt = $con->prepare("INSERT INTO `tbl_questions` (subject_code, chapter, question, marks, co_level, bl_level, create_by) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param(
                    "sssissi",
                    $subject_code,
                    $row[0],
                    $questionText,
                    $row[2],
                    $co_level,  
                    $row[4],
                    $web_admin_id
                );

                $result = $stmt->execute();

                if (!$result) {
                    $_SESSION['status'] = "Database error during import.";
                    $_SESSION['status_code'] = "error";
                    header("Location: view_question_bank.php");
                    exit();
                }
            }


            $_SESSION['status'] = "Imported Successfully";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = implode("<br>", $errorMessages);
            $_SESSION['status_code'] = "error";
        }

        echo "<script>setTimeout(function(){window.location='insert_question_bank.php'},2000)</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
    <meta charset="UTF-8">
    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../include/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
    <style>
        #upload-guidelines {
            /* max-width: 500px; */
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        #upload-guidelines h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        #upload-guidelines p {
            font-size: 16px;
            margin-bottom: 15px;
        }

        #upload-guidelines ul {
            margin-left: 20px;
        }

        #upload-guidelines li {
            font-size: 16px;
            margin-bottom: 5px;
        }
    </style>
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
                            <h1 class="m-0">Add Question Bank</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Question Bank</li>
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
                                <div class="card-header h-100">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h3 class="card-title h-100 mt-1">Add Question Bank</h3>
                                        </div>
                                        <div class="col-sm-9 text-right">
                                            <a class="btn btn-dark p-1" href="demo.csv" download="demo.csv"><i class="fa fa-download"></i> Download Sample csv</a>
                                        </div>

                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div id="upload-guidelines">
                                            <h2>Upload CSV Guidelines</h2>
                                            <ul>
                                                <li>Ensure your CSV file is properly formatted.</li>
                                                <li>Make sure the first row contains column headers.</li>
                                                <li style="background-color:lightblue;">Avoid inserting any empty rows between the rows containing question data.</li>
                                                <li style="background-color:lightblue;">If you want to upload in Gujarati, consider creating the file in Google Spreadsheet and then download it as CSV.</li>
                                                <li>
                                                    If you have multiple questions within one record in your CSV file, and you want to separate them with commas while ensuring that the CSV format remains intact, you can follow these steps:<br>
                                                    For example, if you have two questions, you would format them like this: "Question 1", "Question 2" in one row.
                                                </li>
                                                <li>Each subsequent row should represent a single record.</li>
                                                <li>Verify that all data is correctly separated by commas (,) or another specified delimiter.</li>
                                                <li>Check for any special characters that may cause issues.</li>
                                                <li>Review the data for accuracy and consistency before uploading.</li>
                                                <li>If the CSV file is not responsive, open it in a text editor like Notepad to check for any missing elements or formatting issues.</li>

                                                <!-- ✅ New Instructions for Image Tag -->
                                                <li style="background-color:#ffeaa7; font-weight:bold;">
                                                    To attach an image to a question, include the tag inside the question text.<br><br>
                                                    ✅ Example:<br>
                                                    <code>"What is the capital of France? &lt;img&gt;france_flag.jpeg&lt;/img&gt;"</code><br><br>
                                                    ✅ The <code>&lt;img&gt;filename&lt;/img&gt;</code> must match exactly with the uploaded file name from the "View Uploaded Images" page.<br><br>
                                                    ✅ Do <b>NOT</b> include the full URL. Only use the file name (e.g. <code>france_flag.jpeg</code>).<br><br>
                                                    ✅ For Gujarati questions, you can also add images similarly:<br>
                                                    <code>"ફ્રાન્સની રાજધાની શું છે? &lt;img&gt;france_flag.jpeg&lt;/img&gt;"</code>
                                                </li>
                                            </ul>
                                        </div>

                                        <br>
                                        <div class="form-group row">
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
                                                <label for="subject_code_id">Subject Code<span style="color: red;">*</span></label>
                                                <select class="form-control" name="subject_code" required id="subject_code_id">
                                                    <option value="">---Select subject Code---</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="name">Upload CSV<span style="color: red;">*</span></label>
                                                <input type="file" name="file" class="form-control h-100" id="file" accept=".csv" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <button id="previewBtn" class="btn btn-info">Preview</button>
                                            </div>
                                        </div>
                                        <?php

                                        if ($errorInPreview): ?>
                                            <div class="alert alert-danger">
                                                <strong>CSV Error Detected:</strong><br>
                                                <?php foreach ($errorMessages as $msg): ?>
                                                    <?= htmlspecialchars($msg) ?><br>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <!-- Show your preview table using $previewData -->
                                        <?php endif; ?>

                                        <div id="previewTableDiv" class="form-group col-md-12" style="display: none;">
                                            <h4>CSV Preview</h4>
                                            <table class="table table-bordered">

                                                <tbody id="previewTableBody">
                                                    <!-- Preview data will be inserted here -->
                                                </tbody>

                                            </table>

                                            <input type="checkbox" id="confirmCheckbox"> I confirm that I want to submit the question bank.

                                        </div>


                                        <div class="card-footer text-right">
                                            <input type="submit" name="import" value="Import" class="btn btn-primary">
                                        </div>
                                </form>
                            </div>

                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
        </div><!-- /.container-fluid -->
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
</body>

</html>
<?php // } 
?>


<script>
    $(document).ready(function() {
        //call for listing the dropdown and select by default
        load_level();
        load_program();
    });

    function load_level() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $faculty_id; ?>;
        var level_id = <?php echo $level_id; ?>;

        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_id: level_id
            },
            success: function(result) {
                $('#level_id').html(result);

                // console.log(result);
            }
        });

    }

    function load_program() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $faculty_id; ?>;
        var level_id = <?php echo $level_id; ?>;

        $.ajax({
            url: path + 'program.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_id: level_id
            },
            success: function(result) {
                $('#program_id').html(result);

                // console.log(result);
            }
        });

    }
</script>
<script type="text/javascript">
    $('#faculty_id').on('change', function() {
        var path = '<?php echo "$base_url_api"; ?>';
        var faculty_id = this.value;
        // alert("hii");
        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id
            },
            success: function(result) {
                $('#level_id').html(result);

                // console.log(result);
            }
        })
    });

    $('#level_id').on('change', function() {
        var path = '<?php echo "$base_url_api"; ?>';
        var level_id = this.value;
        var faculty_id = $("select#faculty_id option:checked").val();
        /*  alert(level_id); */

        $.ajax({
            url: path + 'program.php',
            type: "POST",
            data: {
                level_data: level_id,
                faculty_data: faculty_id
            },
            cache: false,
            success: function(data) {
                $('#program_id').html(data);
                // console.log(data);
            }
        })
    });
</script>


<script type="text/javascript">
    var path = '<?php echo $base_url_question_paper; ?>';
    $(document).ready(function() {
        // Function to load subject codes based on selected parameters
        function loadSubjectCodes() {
            var faculty_id = $('#faculty_id').val();
            var level_id = $('#level_id').val();
            var program_id = $('#program_id').val();
            var sem = $('#sem').val();

            $.ajax({
                url: path + 'get_subject_codes.php',
                type: 'POST',
                data: {
                    faculty_id: faculty_id,
                    level_id: level_id,
                    program_id: program_id,
                    sem: sem
                },
                success: function(response) {
                    // Populate the subject code dropdown with the fetched options
                    $('#subject_code_id').html(response);


                }
            });
        }

        // Call the function initially and whenever any of the selection changes
        loadSubjectCodes();

        $('#faculty_id, #level_id, #program_id, #sem').on('change', function() {
            loadSubjectCodes();
        });

    });
</script>

<script>
    $(document).ready(function() {
        $('#previewBtn').click(function() {
            var file = $('#file')[0].files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var rows = e.target.result.split('\n');
                    var tableContent = '';
                    for (var i = 0; i < rows.length; i++) {
                        var cells = parseCSVRow(rows[i]);
                        if (cells.length >= 5) {
                            tableContent += '<tr>';
                            for (var j = 0; j < 5; j++) {
                                tableContent += '<td>' + cells[j] + '</td>';
                            }
                            tableContent += '</tr>';
                        }
                    }
                    $('#previewTableBody').html(tableContent);
                    $('#previewTableDiv').show();
                };
                reader.readAsText(file);
            } else {
                alert('Please select a file.');
            }
            return false; // Prevent form submission
        });

        // Add an event listener for the form submission
        $('#quickForm').submit(function(event) {
            // Check if the preview button has been clicked
            if ($('#previewTableDiv').is(':visible')) {
                // Check if the confirmation checkbox is checked
                if ($('#confirmCheckbox').is(':checked')) {
                    // Continue with form submission
                    return true;
                } else {
                    // Prevent form submission if the confirmation checkbox is not checked
                    event.preventDefault();
                    alert('Please confirm before submitting the question bank.');
                    return false;
                }
            } else {
                // Prevent form submission if the preview button has not been clicked
                event.preventDefault();
                alert('Please click the preview button before submitting.');
                return false;
            }
        });

        function parseCSVRow(row) {
            var regex = /(?:^|,)(\"(?:[^\"]+|\"\")*\"|[^,]*)/g;
            var matches = row.match(regex);
            var cells = [];
            matches.forEach(function(match) {
                cells.push(match.replace(/(^,)|(,$)/g, '').replace(/^\"|\"$/g, ''));
            });
            return cells;
        }
    });
</script>