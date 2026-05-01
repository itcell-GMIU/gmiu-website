<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../include/checklogin.php';


if (isset($_POST['submit'])) {
    // Fetch data from HTML Form
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $sem = mysqli_real_escape_string($con, $_POST['sem']);
    $exam_type = mysqli_real_escape_string($con, $_POST['exam_type']);
    $exam_session = mysqli_real_escape_string($con, $_POST['exam_session']);
    // $subject_codes = $_POST['subject_code']; 
    $year = mysqli_real_escape_string($con, $_POST['year']);
    $subject_fee = mysqli_real_escape_string($con, $_POST['subject_fee']);
    $batch = mysqli_real_escape_string($con, $_POST['batch']);
    $start_date = mysqli_real_escape_string($con, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($con, $_POST['end_date']);

    // Validate Data
    $program_id = validate_data($program_id);
    $faculty_id = validate_data($faculty_id);
    $level_id = validate_data($level_id);


    // Get data from the form
    $starting_dates = $_POST['starting_date'];
    $ending_dates = $_POST['ending_date'];
    $late_fee_amounts = $_POST['late_fee_amount'];

    // Combine data into a JSON array
    $late_fee_data = [];
    for ($i = 0; $i < count($starting_dates); $i++) {
        $entry = [
            'starting_date' => $starting_dates[$i],
            'ending_date' => $ending_dates[$i],
            'late_fee_amount' => $late_fee_amounts[$i]
        ];
        $late_fee_data[] = $entry;
    }

    $late_fee_json = json_encode($late_fee_data);



    // Dynamic table name
    // $tbl_new = "tbl_exam_" . $year;
    $tbl_new = "tbl_exam_form";

    // SQL statement to create the table with a dynamic name
    $sql = "CREATE TABLE IF NOT EXISTS $tbl_new (
        `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
        `faculty_id` INT(20) NULL DEFAULT NULL,
        `level_id` INT(20) NULL DEFAULT NULL,
        `program_id` INT(20) NULL DEFAULT NULL,
        `semester` INT(11) NULL DEFAULT NULL,
        `subject_fee` INT(11) NULL DEFAULT NULL,
        `year` INT(11) NULL DEFAULT NULL,
        `batch` INT(11) NULL DEFAULT NULL,
        `type` VARCHAR(255) NULL DEFAULT NULL,
        `subject_code` VARCHAR(255) NULL DEFAULT NULL,
        `session` VARCHAR(255) NULL DEFAULT NULL,
        `start_date` DATE NULL DEFAULT NULL,
        `end_date` DATE NULL DEFAULT NULL,
        `is_active` TINYINT(1) NOT NULL DEFAULT '1',
        `is_delete` TINYINT(1) NOT NULL DEFAULT '0',
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `created_by` VARCHAR(255) NULL DEFAULT NULL,
        `updated_by` VARCHAR(255) NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    )";
    $con->query($sql);

    // Convert subject_codes array to JSON
    // $subject_codes_json = json_encode($subject_codes);

    $id_count = $con->query("SELECT * FROM $tbl_new");;
    $row_count = mysqli_num_rows($id_count);
    $new_id = $row_count + 1;
    // Insert the JSON data into the database
    $stmt = $con->prepare("INSERT INTO $tbl_new(`id`,`faculty_id`, `level_id`, `program_id`, `semester`, `type`, `subject_code`, `session`, `start_date`, `end_date`, `year`, `subject_fee`, `batch`, `late_fee`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("iiiiisssssiiis", $new_id, $faculty_id, $level_id, $program_id, $sem, $exam_type, $subject_codes_json, $exam_session, $start_date, $end_date, $year, $subject_fee, $batch, $late_fee_json);
    $result1 = $stmt->execute();


    if ($exam_type == 'remedial') {

        $stmtEXID = $con->prepare("SELECT id FROM tbl_exam_form WHERE faculty_id = ? AND level_id = ? AND program_id = ? AND semester = ? AND result_status = 1 AND is_active = 1");
        $stmtEXID->bind_param("iiii", $faculty_id, $level_id, $program_id, $sem);
        $stmtEXID->execute();
        $resultEXID = $stmtEXID->get_result();

        while ($rowEXID = $resultEXID->fetch_assoc()) {

            $remedial_exID = $rowEXID['id'];

            $sql2 = "INSERT INTO tbl_exam_student (enrollnment_no, exam_id)
                SELECT enrollnment_no , $new_id
                FROM tbl_exam_student
                WHERE `exam_id` = $remedial_exID AND `is_pass` = 0";
            $con->query($sql2);
        }
    } else {
        $sql2 = "INSERT INTO tbl_exam_student (enrollnment_no, exam_id)
        SELECT enrollnment_no , $new_id
        FROM tbl_students_2023
        WHERE `semester` = $sem 
          AND `faculty_id` = $faculty_id
          AND `level_id` = $level_id
          AND `program_id` = $program_id";
        $con->query($sql2);
    }


    // Error handling if insertion fails
    if ($result1) {
        $_SESSION['status'] = "Exam Form Inserted Successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='exam_form_insert.php'},1000)</script>";
    } else {
        $_SESSION['status'] = "Program Outcome Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='exam_form_view.php'},1000)</script>";
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

    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
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
                            <h1 class="m-0">Add Exam Forms</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Exam Forms</li>
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
                                    <h3 class="card-title">Add Exam Forms</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Select Faculty<span style="color: red;"> *</span></label>
                                            <select class="form-control" name="faculty_id" required id="faculty_id">
                                                <option value="">---Select Faculty---</option>
                                                <?php
                                                $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    $faculty_id = $row['id'];

                                                    $cmd33 = "SELECT * FROM tbl_clg_name WHERE is_delete = '0' and is_active='1' and FIND_IN_SET('$faculty_id', faculty_id) > 0";
                                                    $stmt33 = $con->prepare($cmd33);
                                                    $stmt33->execute();
                                                    $result33 = $stmt33->get_result();

                                                    echo '<option value="' . $faculty_id . '">';
                                                    if ($result33->num_rows > 0) {
                                                        $counter = 0;
                                                        while ($row33 = $result33->fetch_assoc()) {
                                                            $counter++;
                                                            echo $row33['clg_name'];

                                                            // Add a comma if it's not the last college name
                                                            if ($counter < $result33->num_rows) {
                                                                echo ', ';
                                                            }
                                                        }
                                                    }
                                                    echo '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Level<span style="color: red;"> *</span></label>
                                            <select name="level_id" id="level_id" class="form-control" required>
                                                <option value="">---Select Level---</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Program<span style="color: red;"> *</span></label>
                                            <select name="program_id" id="program_id" class="form-control" required>
                                                <option value="">---Select Program---</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
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

                                        <div class="form-group">
                                            <label>Select Exam Type<span style="color: red;"> *</span></label>
                                            <select name="exam_type" id="exam_type" class="form-control" required>
                                                <option value="regular"> Regular</option>
                                                <option value="remedial"> Remedial</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Exam Session<span style="color: red;"> *</span></label>
                                            <select name="exam_session" id="exam_session" class="form-control" required>
                                                <option value=""> --- Exam--- </option>
                                                <option value="winter"> Winter</option>
                                                <option value="summer"> Summer</option>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label for="start_date">Select Form Filling Start Date<span style="color: red;"> *</span></label>
                                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label for="end_date">Select Form Filling End Date<span style="color: red;"> *</span></label>
                                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Select Exam Year<span style="color: red;"> *</span></label>
                                                <input type="number" min="1900" max="2099" step="1" value="2023" name="year" id="year" class="form-control" required>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Select Student Batch<span style="color: red;"> *</span></label>
                                                <input type="number" min="2000" max="2099" step="1" value="2023" name="batch" id="year" class="form-control" required>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Fees Per Subject<span style="color: red;"> *</span></label>
                                                <input type="number" name="subject_fee" class="form-control" required>
                                            </div>

                                            <div class="col-sm-9">
                                                <div id="late_fee_entries">
                                                    <div class="late_fee_entry row">
                                                        <div class="form-group col-sm-4">
                                                            <label for="starting_date_1">Starting Date:</label>
                                                            <input class="form-control" type="date" name="starting_date[]" required>
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            <label for="ending_date_1">Ending Date:</label>
                                                            <input class="form-control" type="date" name="ending_date[]" required>
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            <label for="late_fee_amount_1">Late Fee Amount:</label>
                                                            <input class="form-control" type="number" name="late_fee_amount[]" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 align-self-center">
                                                <button class="btn btn-info mt-3" type="button" id="add_entry"><i class="fa fa-plus"></i> Add More Late Fee Entry</button>
                                            </div>

                                        </div>


                                        <!-- <div class="form-group">
                                            <label>Select Subject<span style="color: red;"> *</span></label>
                                            <select class="form-control" name="subject_code" id="subject_code" multiple required>
                                                <option value="">--- Select Subject ---</option>
                                            </select>
                                        </div> -->

                                        <!-- <div class="form-group">
                                            <label>Select Subject<span style="color: red;"> *</span></label>
                                            <div class="selected-items"></div>
                                            <select class="select2option" style="width: 100%" name="subject_code[]" id="subject_code" multiple="multiple" required>
                                            </select>
                                        </div> -->

                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>
                            </div>
                            </form>
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
    <script>
        $(document).ready(function() {
            $('.select2option').select2();
        });
    </script>

    <script>
        $(document).ready(function() {

            //call for listing the dropdown and select by default
            load_level();

        });

        function load_level() {
            var path = '<?php echo $base_url_website_admin; ?>';
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
    </script>
    <script type="text/javascript">
        $('#faculty_id').on('change', function() {
            var path = '<?php echo "$base_url_website_admin"; ?>';
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
    </script>
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
    <script>
        $(document).ready(function() {
            // Call this function whenever the selected values change
            function populateSubjectDropdown() {
                var faculty_id = $('#faculty_id').val();
                var level_id = $('#level_id').val();
                var program_id = $('#program_id').val();
                var sem = $('#sem').val();

                $.ajax({
                    url: 'get_subjects.php',
                    type: 'POST',
                    data: {
                        faculty_id: faculty_id,
                        level_id: level_id,
                        program_id: program_id,
                        sem: sem
                    },
                    dataType: 'json',
                    success: function(subjects) {
                        // Clear existing options and add new options
                        var subjectDropdown = $('#subject_code');
                        subjectDropdown.empty();
                        subjectDropdown.append($('<option>', {
                            value: '',
                            text: '--- Select Subject ---'
                        }));
                        $.each(subjects, function(index, subject) {
                            subjectDropdown.append($('<option>', {
                                value: subject.subject_code, // Set value to subject_code
                                text: subject.subject_name + '(' + subject.subject_code + ')' // Set text to subject_name
                            }));
                        });
                    }
                });
            }

            // Call the function when any of the selection boxes change
            $('#faculty_id, #level_id, #program_id, #sem').on('change', function() {
                populateSubjectDropdown();
            });

            // Call the function initially to populate the subject dropdown
            populateSubjectDropdown();
        });
    </script>

    <script>
        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            ;
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>

    <script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        document.getElementById('add_entry').addEventListener('click', function() {
            const lateFeeEntries = document.getElementById('late_fee_entries');
            const newEntry = document.querySelector('.late_fee_entry').cloneNode(true);

            // Reset input values in the new entry
            newEntry.querySelectorAll('input').forEach(input => {
                input.value = '';
            });

            lateFeeEntries.appendChild(newEntry);
        });
    </script>
</body>

</html>