<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// The user's code starts here
if ($role_id == 8) {
    if (isset($_POST['submit'])) {

        // --- FIX 1: Get faculty and program ID from the session ---
        // For this user role, faculty_id and program_id are not coming from the form,
        // but are likely set in the session by 'checklogin.php'.
        $faculty_id = $_SESSION['faculty_id']; // Assuming faculty_id is stored in the session
        $program_id = $_SESSION['program_id']; // Assuming program_id is stored in the session

        //Fetch data from HTML Form
        $sem = mysqli_real_escape_string($con, $_POST['sem']);
        $subject_code = mysqli_real_escape_string($con, $_POST['subject_code']);
        $subject_name = mysqli_real_escape_string($con, $_POST['subject_name']);
        $subject_short_name = mysqli_real_escape_string($con, $_POST['subject_short_name']);
        $lectures = mysqli_real_escape_string($con, $_POST['lectures']);
        $tutorial = mysqli_real_escape_string($con, $_POST['tutorial']);
        $practical = mysqli_real_escape_string($con, $_POST['practical']);
        $credit = mysqli_real_escape_string($con, $_POST['credit']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);

        // validate Data
        // These are now validated after being fetched from the session or POST
        $program_id = validate_data($program_id);
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);

        $stmt = $con->prepare("INSERT INTO `tbl_std_corner`(faculty_id,level_id,program_id,sem,subject_code,subject_name,subject_short_name,lectures,tutorial,practical,credit)VALUES (?,?,?,?,?,?,?,?,?,?,?)");

        // --- FIX 2: Bind the correct variables ---
        // The bind_param now uses the variables correctly fetched from the session and the form.
        // Assuming program_id and sem are integers for this user role.
        $stmt->bind_param("iiisssiiiii", $faculty_id, $level_id, $program_id, $sem, $subject_code, $subject_name, $subject_short_name, $lectures, $tutorial, $practical, $credit);

        $result1 = $stmt->execute();
        $id = $con->insert_id;

        if ($result1) {
            $targetDirectory = "../uploads/Syllabus/";
            $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);

            if ($file_upload_status['status'] == 200) {
                $report_name = $file_upload_status['message'];
                $stmt = $con->prepare("UPDATE `tbl_std_corner` SET `Syllabus` = ? WHERE `id` = ?");
                $stmt->bind_param("si", $report_name, $id);
                $result = $stmt->execute();
            } else {
                $stmt = $con->prepare("DELETE FROM `tbl_std_corner` WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute(); // Execute the delete statement
                $_SESSION['status'] = $file_upload_status['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000)</script>";
                exit(); // Stop script execution after redirect
            }

            if (isset($result) && $result) {
                $_SESSION['status'] = "Student Corner Inserted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Syllabus Upload Failed or No File Uploaded";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000)</script>";
            }
        } else {
            // Handle initial insertion failure
            $_SESSION['status'] = "Student Corner Insertion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000)</script>";
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
            document.addEventListener('DOMContentLoaded', function () {
                CKEDITOR.replace('text_editor');
            });
        </script>
        <!-- /.CKeditor custom script -->

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <!-- Preloader -->
        <div id="preloader">
            <div id="status">&nbsp;</div>
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
                                <h1 class="m-0">Add Student Corner</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Student Corner</li>
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
                                        <h3 class="card-title">Add Student Corner</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form id="quickForm" method="POST" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Select level<span style="color: red;"> *</span></label>
                                                <select class="form-control" name="level_id" required id="level_id">
                                                    <option value="">---Select level---</option>
                                                    <?php
                                                    // The IN($level_id) is likely from the session variable set in checklogin.php
                                                    $cmd = "SELECT id,name FROM tbl_level WHERE id IN($level_id) and is_delete = '0' and is_active='1'";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                        <option value="<?php echo $row['id'] ?>">
                                                            <?php echo $row['name'] ?>
                                                        </option>
                                                    <?php } ?>
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
                                                <label for="subject_code_id">subject code<span
                                                        style="color: red;">*</span></label>
                                                <!-- FIX 3: Removed space from name attribute -->
                                                <input type="text" name="subject_code" class="form-control"
                                                    id="subject_code_id" placeholder="Enter Subject Code" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="subject_name">subject name<span
                                                        style="color: red;">*</span></label>
                                                <input type="text" name="subject_name" class="form-control"
                                                    id="subject_name" placeholder="Enter Subject Name" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="subject_short_id">subject short name<span
                                                        style="color: red;">*</span></label>
                                                <!-- FIX 4: Removed space from name attribute -->
                                                <input type="text" name="subject_short_name" class="form-control"
                                                    id="subject_short_id" placeholder="Enter subject short name" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="lectures">lectures<span style="color: red;">*</span></label>
                                                <input type="text" name="lectures" class="form-control" id="lectures"
                                                    placeholder="Enter lectures" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tutorial">tutorial<span style="color: red;">*</span></label>
                                                <input type="text" name="tutorial" class="form-control" id="tutorial"
                                                    placeholder="Enter tutorial" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="practical">practical<span style="color: red;">*</span></label>
                                                <input type="text" name="practical" class="form-control" id="practical"
                                                    placeholder="Enter practical" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="credit">credit<span style="color: red;">*</span></label>
                                                <input type="text" name="credit" class="form-control" id="credit"
                                                    placeholder="Enter credit" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Syllabus<span style="color: red;">
                                                        *</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="report_upload"
                                                            id="report_upload" required>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
        <!-- Select2 JS should be included here if not in importjs.php -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(function () {
                // Initialize bs-custom-file-input
                bsCustomFileInput.init();
            });
        </script>
    </body>

    </html>
    <?php

} else {

    if (isset($_POST['submit'])) {

        //Fetch data from HTML Form
        $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        $program_ids = $_POST['program_id']; // This is an array from the multiple select
        $sem = mysqli_real_escape_string($con, $_POST['sem']);
        $subject_code = mysqli_real_escape_string($con, $_POST['subject_code']);
        $subject_name = mysqli_real_escape_string($con, $_POST['subject_name']);
        $subject_short_name = mysqli_real_escape_string($con, $_POST['subject_short_name']);
        $lectures = mysqli_real_escape_string($con, $_POST['lectures']);
        $tutorial = mysqli_real_escape_string($con, $_POST['tutorial']);
        $practical = mysqli_real_escape_string($con, $_POST['practical']);
        $credit = mysqli_real_escape_string($con, $_POST['credit']);

        // Validate and process data
        // Convert the array of program IDs into a single comma-separated string to store in the database.
        $program_id_str = implode(',', array_map('intval', $program_ids));
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);


        $stmt = $con->prepare("INSERT INTO `tbl_std_corner`(faculty_id,level_id,program_id,sem,subject_code,subject_name,subject_short_name,lectures,tutorial,practical,credit)VALUES (?,?,?,?,?,?,?,?,?,?,?)");

        // --- FIX ---
        // The error was here. You were binding an undefined variable `$program_id`.
        // The correct variable is `$program_id_str`, which holds the comma-separated string of IDs.
        // The type string "iisisssiiii" was also likely incorrect for your needs. Assuming program_id is a string (VARCHAR/TEXT)
        // and sem is also a string.
        $stmt->bind_param("iisssssiiii", $faculty_id, $level_id, $program_id_str, $sem, $subject_code, $subject_name, $subject_short_name, $lectures, $tutorial, $practical, $credit);

        $result1 = $stmt->execute();
        $id = $con->insert_id;

        if ($result1) {

            $targetDirectory = "../uploads/Syllabus/";
            $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);

            // check file moved Successfully
            if ($file_upload_status['status'] == 200) {
                $report_name = $file_upload_status['message'];
                $stmt = $con->prepare("UPDATE `tbl_std_corner` SET `Syllabus` = ? WHERE `id` = ?");
                $stmt->bind_param("si", $report_name, $id);
                $result = $stmt->execute();
            } else {

                $stmt = $con->prepare("DELETE FROM `tbl_std_corner` WHERE id = ?");
                $stmt->bind_param("i", $id);
                $result = $stmt->execute();
                $_SESSION['status'] = $file_upload_status['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000)</script>";
            }

            if ($result) {
                //Sweet Alert of Success Message
                $_SESSION['status'] = "Student Corner Inserted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000);</script>";
            } else {
                //Sweet Alert of Error Message
                $_SESSION['status'] = "Program Outcome Insertion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000)</script>";
            }
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
            document.addEventListener('DOMContentLoaded', function () {
                CKEDITOR.replace('text_editor');
            });
        </script>
        <!-- /.CKeditor custom script -->
        <style>
            .select2-selection__choice__display {
                color: #000000;
            }
        </style>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <!-- Preloader -->
        <div id="preloader">
            <div id="status">&nbsp;</div>
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
                                <h1 class="m-0">Add Student Corner</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Student Corner</li>
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
                                        <h3 class="card-title">Add Student Corner</h3>
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
                                                        // This logic seems incorrect for a new form, it's more for an edit form.
                                                        // Keeping as is, per user request.
                                                        // $faculty_id = $row['faculty_id']; 
                                                        ?>
                                                        <option value="<?php echo $row['id'] ?>">
                                                            <?php echo $row['name'] ?>
                                                        </option>
                                                    <?php } ?>
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
                                                <select name="program_id[]" id="program_id" class="form-control"
                                                    multiple="multiple" required>
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
                                                <label for="subject_code_id">subject code<span
                                                        style="color: red;">*</span></label>
                                                <!-- FIX: Removed space from name attribute -->
                                                <input type="text" name="subject_code" class="form-control"
                                                    id="subject_code_id" placeholder="Enter Subject Code" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="subject_name">subject name<span
                                                        style="color: red;">*</span></label>
                                                <input type="text" name="subject_name" class="form-control"
                                                    id="subject_name" placeholder="Enter Subject Name" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="subject_short_id">subject short name<span
                                                        style="color: red;">*</span></label>
                                                <!-- FIX: Removed space from name attribute -->
                                                <input type="text" name="subject_short_name" class="form-control"
                                                    id="subject_short_id" placeholder="Enter subject short name" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="lectures">lectures<span style="color: red;">*</span></label>
                                                <input type="text" name="lectures" class="form-control" id="lectures"
                                                    placeholder="Enter lectures" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tutorial">tutorial<span style="color: red;">*</span></label>
                                                <input type="text" name="tutorial" class="form-control" id="tutorial"
                                                    placeholder="Enter tutorial" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="practical">practical<span style="color: red;">*</span></label>
                                                <input type="text" name="practical" class="form-control" id="practical"
                                                    placeholder="Enter practical" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="credit">credit<span style="color: red;">*</span></label>
                                                <input type="text" name="credit" class="form-control" id="credit"
                                                    placeholder="Enter credit" required>
                                            </div>
                                            <div name="report" id="report" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload Syllabus<span style="color: red;">
                                                            *</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                name="report_upload" id="report_upload" required>
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
    </body>

    </html>
<?php } ?>

<!-- The Javascript part remains unchanged as requested -->
<script>
    $(document).ready(function () {
        // This logic seems to be for an 'edit' form, not a 'new' form.
        // It's trying to load data based on PHP variables that might not exist on this page.
        // Leaving it as is, per user request.
        // load_level();
        // load_program();
    });

    function load_level() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo isset($faculty_id) ? $faculty_id : 'null'; ?>;
        var level_id = <?php echo isset($level_id) ? $level_id : 'null'; ?>;

        if (faculty_id) {
            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id
                },
                success: function (result) {
                    $('#level_id').html(result);
                }
            });
        }
    }

    function load_program() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo isset($faculty_id) ? $faculty_id : 'null'; ?>;
        var level_id = <?php echo isset($level_id) ? $level_id : 'null'; ?>;

        if (faculty_id && level_id) {
            $.ajax({
                url: path + 'program.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id
                },
                success: function (result) {
                    $('#program_id').html(result);
                }
            });
        }
    }
</script>

<script type="text/javascript">
    $('#faculty_id').on('change', function () {
        var path = '<?php echo "$base_url_api"; ?>';
        var faculty_id = this.value;
        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id
            },
            success: function (result) {
                $('#level_id').html(result);
                $('#program_id').html('<option value="">---Select Program---</option>'); // Clear program dropdown
            }
        })
    });

    $('#level_id').on('change', function () {
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
            success: function (data) {
                $('#program_id').html(data);
            }
        })
    });
</script>

<script>
    // This Dropzone code appears to be unused in the form. Leaving as is.
    // DropzoneJS Demo Code Start
    Dropzone.autoDiscover = false
    var previewNode = document.querySelector("#template")
    if (previewNode) {
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })
        myDropzone.on("addedfile", function (file) {
            file.previewElement.querySelector(".start").onclick = function () {
                myDropzone.enqueueFile(file)
            }
        })
        myDropzone.on("totaluploadprogress", function (progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })
        myDropzone.on("sending", function (file) {
            document.querySelector("#total-progress").style.opacity = "1"
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })
        myDropzone.on("queuecomplete", function (progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })
        document.querySelector("#actions .start").onclick = function () {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function () {
            myDropzone.removeAllFiles(true)
        }
    }
    // DropzoneJS Demo Code End
</script>

<script>
    $(function () {
        bsCustomFileInput.init();
    });
</script>

<script>
    $(document).ready(function () {
        $('#program_id').select2({
            placeholder: "---Select Program---",
            allowClear: true
        });
    });
</script>

<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>