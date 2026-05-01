<?php
// Include the checklogin.php file
include '../include/checklogin.php';
if ($role_id == 8) {
    if (isset($_POST['submit'])) {

        //Fetch data from HTML Form
        $sem = mysqli_real_escape_string($con, $_POST['sem']);
        $subject_code = mysqli_real_escape_string($con, $_POST['subject_code']);
        $subject_name = mysqli_real_escape_string($con, $_POST['subject_name']);
        $subject_short_name = mysqli_real_escape_string($con, $_POST['subject_short_name']);
        $lectures = mysqli_real_escape_string($con, $_POST['lectures']);
        $tutorial = mysqli_real_escape_string($con, $_POST['tutorial']);
        $practical = mysqli_real_escape_string($con, $_POST['practical']);
        $credit = mysqli_real_escape_string($con, $_POST['credit']);
        $level_id =  mysqli_real_escape_string($con, $_POST['level_id']);

        // validate Data
        $program_id = validate_data($program_id);
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);

        $stmt = $con->prepare("INSERT INTO `tbl_std_corner`(faculty_id,level_id,program_id,sem,subject_code,subject_name,subject_short_name,lectures,tutorial,practical,credit)VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("iiiisssiiii", $faculty_id, $level_id, $program_id, $sem, $subject_code, $subject_name, $subject_short_name, $lectures, $tutorial, $practical, $credit);
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
                                                    $cmd = "SELECT id,name FROM tbl_level WHERE id IN($level_id) and is_delete = '0' and is_active='1'";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $level_id = $row['level_id'];
                                                    ?>

                                                        <option value="<?php echo $row['id'] ?>" <?php if ($level_id == $row['id']) {
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
                                                <label for="name">subject code<span style="color: red;">*</span></label>
                                                <input type="text" name="subject code" class="form-control" id="subject_code_id" placeholder="Enter Subject Code" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">subject name<span style="color: red;">*</span></label>
                                                <input type="text" name="subject_name" class="form-control" id="subject_name" placeholder="Enter Subject Name" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">subject short name<span style="color: red;">*</span></label>
                                                <input type="text" name="subject short name" class="form-control" id="subject_short_id" placeholder="Enter subject short name" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">lectures<span style="color: red;">*</span></label>
                                                <input type="text" name="lectures" class="form-control" id="lectures" placeholder="Enter lectures" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">tutorial<span style="color: red;">*</span></label>
                                                <input type="text" name="tutorial" class="form-control" id="tutorial" placeholder="Enter lectures" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">practical<span style="color: red;">*</span></label>
                                                <input type="text" name="practical" class="form-control" id="practical" placeholder="Enter practical" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">credit<span style="color: red;">*</span></label>
                                                <input type="text" name="credit" class="form-control" id="credit" placeholder="Enter credit" required>
                                            </div>
                                            <div name="report" id="report" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload Syllabus<span style="color: red;"> *</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="report_upload" id="report_upload" required>
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

    </html><?php
            ////////////////////////////////////////////////////////////////////////// admin ///////////////////////////////////////////////////////////////////////////////
        } else {
            if (isset($_POST['submit'])) {

                //Fetch data from HTML Form
                $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
                $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
                $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
                $sem = mysqli_real_escape_string($con, $_POST['sem']);
                $subject_code = mysqli_real_escape_string($con, $_POST['subject_code']);
                $subject_name = mysqli_real_escape_string($con, $_POST['subject_name']);
                $subject_short_name = mysqli_real_escape_string($con, $_POST['subject_short_name']);
                $lectures = mysqli_real_escape_string($con, $_POST['lectures']);
                $tutorial = mysqli_real_escape_string($con, $_POST['tutorial']);
                $practical = mysqli_real_escape_string($con, $_POST['practical']);
                $credit = mysqli_real_escape_string($con, $_POST['credit']);
echo $subject_code;
                // validate Data
                $program_id = validate_data($program_id);
                $faculty_id = validate_data($faculty_id);
                $level_id = validate_data($level_id);

                $stmt = $con->prepare("INSERT INTO `tbl_std_corner`(faculty_id,level_id,program_id,sem,subject_code,subject_name,subject_short_name,lectures,tutorial,practical,credit)VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("iiiisssiiii", $faculty_id, $level_id, $program_id, $sem, $subject_code, $subject_name, $subject_short_name, $lectures, $tutorial, $practical, $credit);
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
                                                        $faculty_id = $row['faculty_id'];
                                                    ?>

                                                        <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                            <?php echo $row['name'] ?></option>
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
                                                <label for="name">subject code<span style="color: red;">*</span></label>
                                                <input type="text" name="subject code" class="form-control" id="subject_code_id" placeholder="Enter Subject Code" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">subject name<span style="color: red;">*</span></label>
                                                <input type="text" name="subject_name" class="form-control" id="subject_name" placeholder="Enter Subject Name" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">subject short name<span style="color: red;">*</span></label>
                                                <input type="text" name="subject short name" class="form-control" id="subject_short_id" placeholder="Enter subject short name" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">lectures<span style="color: red;">*</span></label>
                                                <input type="text" name="lectures" class="form-control" id="lectures" placeholder="Enter lectures" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">tutorial<span style="color: red;">*</span></label>
                                                <input type="text" name="tutorial" class="form-control" id="tutorial" placeholder="Enter lectures" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">practical<span style="color: red;">*</span></label>
                                                <input type="text" name="practical" class="form-control" id="practical" placeholder="Enter practical" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">credit<span style="color: red;">*</span></label>
                                                <input type="text" name="credit" class="form-control" id="credit" placeholder="Enter credit" required>
                                            </div>
                                            <div name="report" id="report" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload Syllabus<span style="color: red;"> *</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="report_upload" id="report_upload" required>
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

    </html><?php } ?>



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