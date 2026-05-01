<?php
// Include the checklogin.php file
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Header -->
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
<?php
// Fetch program id and level id from display table
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id = only_digits($id);

    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000)</script>";
    }
}

$cmd = $con->prepare("SELECT
std.id as id, 
std.faculty_id as faculty_id, 
std.level_id as level_id, 
std.program_id as program_id, 
std.semester as semester, 
std.is_active as std_is_active, 
std.type as type, 
std.session as session, 
std.start_date as start_date, 
std.end_date as end_date, 
std.year as year,
std.batch as batch,
std.subject_fee as subject_fee,
std.late_fee as late_fee
FROM tbl_exam_form as std WHERE id = ? and is_delete = 0");
$cmd->bind_param("i", $id);
$cmd->execute();
$result = $cmd->get_result();

while ($row = $result->fetch_assoc()) {
    // Fetch data from database
    $id = $row['id'];
    $faculty_id = !empty($row['faculty_id']) ? $row['faculty_id'] : 'N/A';
    $level_id = !empty($row['level_id']) ? $row['level_id'] : 'N/A';
    $program_id = !empty($row['program_id']) ? $row['program_id'] : 'N/A';
    $sem = !empty($row['semester']) ? $row['semester'] : 'N/A';
    $type = !empty($row['type']) ? $row['type'] : 'N/A';
    $session = !empty($row['session']) ? $row['session'] : 'N/A';
    $start_date = !empty($row['start_date']) ? $row['start_date'] : 'N/A';
    $end_date = !empty($row['end_date']) ? $row['end_date'] : 'N/A';
    $year = !empty($row['year']) ? $row['year'] : 'N/A';
    $batch = !empty($row['batch']) ? $row['batch'] : 'N/A';
    $fees = !empty($row['subject_fee']) ? $row['subject_fee'] : 'N/A';
    $late_fee = !empty($row['late_fee']) ? $row['late_fee'] : 'N/A';

    // sem selection 
    $sem1 = "";
    $sem2 = "";
    $sem3 = "";
    $sem4 = "";
    $sem5 = "";
    $sem6 = "";
    $sem7 = "";
    $sem8 = "";
    if ($sem == 1) {
        $sem1 = "selected";
    } elseif ($sem == 2) {
        $sem2 = "selected";
    } elseif ($sem == 3) {
        $sem3 = "selected";
    } elseif ($sem == 4) {
        $sem4 = "selected";
    } elseif ($sem == 5) {
        $sem5 = "selected";
    } elseif ($sem == 6) {
        $sem6 = "selected";
    } elseif ($sem == 7) {
        $sem7 = "selected";
    } elseif ($sem == 8) {
        $sem8 = "selected";
    }

    $regular = "";
    $remedial = "";
    if ($type == "regular") {
        $regular = "selected";
    } elseif ($type == "remedial") {
        $remedial = "selected";
    }

    $summer = "";
    $winter = "";
    if ($session == "summer") {
        $summer = "selected";
    } elseif ($session == "winter") {
        $winter = "selected";
    }
}
?>


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
                            <h1 class="m-0">Edit Exam Forms</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Exam Forms</li>
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
                                    <h3 class="card-title">Edit Exam Forms</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" action="exam_form_update.php" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" name="exam_id" value="<?= $id ?>">
                                        <div class="form-group">
                                            <label>Select Faculty</label>
                                            <select class="form-control" name="faculty_id" id="faculty_id">
                                                <?php
                                                $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {

                                                ?>

                                                    <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                        <?php echo $row['name'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Level</label>
                                            <select name="level_id" id="level_id" class="form-control" required>
                                                <?php
                                                $cmd = "SELECT * FROM tbl_level WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {

                                                ?>

                                                    <option value="<?php echo $row['id'] ?>" <?php if ($level_id == $row['id']) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                        <?php echo $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Program</label>
                                            <select name="program_id" id="program_id" class="form-control" required>
                                                <?php
                                                $cmd = "SELECT * FROM tbl_program WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {

                                                ?>

                                                    <option value="<?php echo $row['id'] ?>" <?php if ($program_id == $row['id']) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                        <?php echo $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select sem<span style="color: red;"> *</span></label>
                                            <select name="sem" id="sem" class="form-control" required>
                                                <option value=""> --- Semester--- </option>
                                                <option value="1" <?= $sem1 ?>> Semester 1</option>
                                                <option value="2" <?= $sem2 ?>> Semester 2</option>
                                                <option value="3" <?= $sem3 ?>> Semester 3</option>
                                                <option value="4" <?= $sem4 ?>> Semester 4</option>
                                                <option value="5" <?= $sem5 ?>> Semester 5</option>
                                                <option value="6" <?= $sem6 ?>> Semester 6</option>
                                                <option value="7" <?= $sem7 ?>> Semester 7</option>
                                                <option value="8" <?= $sem8 ?>> Semester 8</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Exam Type<span style="color: red;"> *</span></label>
                                            <select name="exam_type" id="exam_type" class="form-control" required>
                                                <option value="regular" <?= $regular ?>> Regular</option>
                                                <option value="remedial" <?= $remedial ?>> Remedial</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Exam Session<span style="color: red;"> *</span></label>
                                            <select name="exam_session" id="exam_session" class="form-control" required>
                                                <option value=""> --- Exam--- </option>
                                                <option value="winter" <?= $winter ?>> Winter</option>
                                                <option value="summer" <?= $summer ?>> Summer</option>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label for="start_date">Select Form Filling Start Date<span style="color: red;"> *</span></label>
                                                <input type="date" name="start_date" id="start_date" class="form-control" required value="<?= $start_date ?>">
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label for="end_date">Select Form Filling End Date<span style="color: red;"> *</span></label>
                                                <input type="date" name="end_date" id="end_date" class="form-control" required value="<?= $end_date ?>">
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Select Exam Year<span style="color: red;"> *</span></label>
                                                <input type="number" min="1900" max="2099" step="1" name="year" id="year" class="form-control" required value="<?= $year ?>">
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Select Student Batch<span style="color: red;"> *</span></label>
                                                <input type="number" min="2000" max="2099" step="1" name="batch" id="year" class="form-control" value="<?= $batch ?>" required>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Fees Per Subject<span style="color: red;"> *</span></label>
                                                <input type="number" name="subject_fee" class="form-control" value="<?= $fees ?>" required>
                                            </div>

                                            <div class="col-sm-9">
                                                <?php
                                                $jsonData = $late_fee;

                                                // Decode the JSON data into a PHP array
                                                $dataArray = json_decode($jsonData, true);

                                                // Check if the decoding was successful
                                                if ($dataArray !== null) {
                                                    // Iterate through the entries 
                                                    $in = 1;
                                                    foreach ($dataArray as $entry) {
                                                        $startingDate = $entry['starting_date'];

                                                        $endingDate = $entry['ending_date'];

                                                        $lateFeeAmount = $entry['late_fee_amount'];

                                                ?>

                                                        <div class="late_fee_entry row">
                                                            <div class="form-group col-sm-4">
                                                                <label for="starting_date_<?= $in ?>">Starting Date:</label>
                                                                <input class="form-control" type="date" name="starting_date[]" value="<?= $startingDate ?>" required>
                                                            </div>
                                                            <div class="form-group col-sm-4">
                                                                <label for="ending_date_<?= $in ?>">Ending Date:</label>
                                                                <input class="form-control" type="date" name="ending_date[]" value="<?= $endingDate ?>" required>
                                                            </div>
                                                            <div class="form-group col-sm-4">
                                                                <label for="late_fee_amount_<?= $in ?>">Late Fee Amount:</label>
                                                                <input class="form-control" type="number" name="late_fee_amount[]" value="<?= $lateFeeAmount ?>" required>
                                                            </div>
                                                        </div>
                                                    <?php
                                                        $in++;
                                                    }
                                                } else {
                                                    ?>
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
                                                    <div class="col-sm-3 align-self-center">
                                                        <button class="btn btn-info mt-3" type="button" id="add_entry"><i class="fa fa-plus"></i> Add More Late Fee Entry</button>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
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
            load_program();
        });

        function load_level() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $faculty_id; ?>;
            var level_id = <?php echo $level_id; ?>;
            var api_for = "dashboard";
            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id,
                    api_for: api_for
                },
                success: function(result) {
                    $('#level_id').html(result);
                }
            });

        }

        function load_program() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $faculty_id; ?>;
            var level_id = <?php echo $level_id; ?>;
            var program_id = <?php echo $program_id; ?>;
            var api_for = "dashboard";
            $.ajax({
                url: path + 'program.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_data: level_id,
                    program_id: program_id,
                    api_for: api_for
                },
                success: function(result) {
                    $('#program_id').html(result);
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
                }
            })
        });
    </script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>

    <script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

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