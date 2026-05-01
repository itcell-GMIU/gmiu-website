<?php
include '../include/checklogin.php';
if ($role_id == 8) {
    if (isset($_POST['submit'])) {

        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        $sem = mysqli_real_escape_string($con, $_POST['sem']);

        // Validate Data
        $program_id = validate_data($program_id);
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);
        
        $title = validate_data($title);
        $year = validate_data($year);

        // Ensure year is a valid 4-digit number
        if (!is_numeric($year) || strlen($year) != 4) {
            die("Invalid year provided. Please enter a 4-digit year.");
        }

        // Prepare and execute SQL statement for inserting data into 'tbl_placement'
        $stmt = $con->prepare("INSERT INTO `tbl_exam_paper`(faculty_id, level_id, program_id, sem, year, session, title, document) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiissss", $faculty_id, $level_id, $program_id, $sem, $year, $session, $title, $document);
        $result = $stmt->execute();
        if ($result) {

            // Set session status and code for success
            $_SESSION['status'] = "Exam Paper Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='paper_view.php'},1000);</script>";
        } else {
            // Set session status and code for error if insertion failed
            $_SESSION['status'] = "Exam Paper Insertion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='paper_view.php'},1000)</script>";
        }
    }

?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include '../include/importhead.php'; ?>

        <!-- Google Font: Source Sans Pro -->
        <?php include '../include/importcss.php'; ?>


    </head>



    <body class="hold-transition sidebar-mini layout-fixed">
        <div id="preloader">
            <div id="status">&nbsp;

            </div>
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
                                <h1 class="m-0">Add Exam Paper</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Exam Paper</li>

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
                                        <h3 class="card-title">Add Exam Paper</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form id="quickForm" method="POST" enctype="multipart/form-data">

                                        <div class="card-body">
                                            <div class="form-group">

                                                <select class="form-control" name="faculty_id" required id="faculty_id" hidden>

                                                </select>
                                            </div>
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
                                                <label for="name">Year<span style="color: red;">*</span></label>
                                                <input type="text" name="year" class="form-control" id="year" placeholder="Enter Exam Year " required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Title<span style="color: red;">*</span></label>
                                                <input type="text" name="title" class="form-control" id="title_id" placeholder="Enter Subject Title" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="session">Exam Session<span style="color: red;"> *</span></label>
                                                <select class="form-control" name="session" id="session" required>
                                                    <option value="">---Select Exam Session---</option>
                                                    <option value="Summer">Summer</option>
                                                    <option value="Winter">Winter</option>
                                                </select>
                                            </div>

                                            <div name="document" id="document" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload document<span style="color: red;"> *</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="document" id="document" required>
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
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
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">

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
<?php
} else {
    if (isset($_POST['submit'])) {

        $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
        $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        $sem = mysqli_real_escape_string($con, $_POST['sem']);
        $year = mysqli_real_escape_string($con, $_POST['year']);
        $session = mysqli_real_escape_string($con, $_POST['session']);
        $title = mysqli_real_escape_string($con, $_POST['title']);



        // Validate Data
        $program_id = validate_data($program_id);
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);
        $year = validate_data($year);
        $session = validate_data($session);
        $title = validate_data($title);


        // Ensure year is a valid 4-digit number
        if (!is_numeric($year) || strlen($year) != 4) {
            die("Invalid year provided. Please enter a 4-digit year.");
        }

        $targetDirectory = "../uploads/exam_paper/document/";

        // Upload the 'document' file using a custom function 'upload_single_file'
        $file_upload_status = upload_single_file($_FILES["document"], $targetDirectory, 0);

        // Check if the file upload was successful
        if ($file_upload_status['status'] == 200) {
            $document = $file_upload_status['message'];
        }

        // Prepare the insert statement
        $stmt = $con->prepare("INSERT INTO `tbl_exam_paper`(faculty_id, level_id, program_id, sem, year, session, title, document) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiissss", $faculty_id, $level_id, $program_id, $sem, $year, $session, $title, $document);
        $result = $stmt->execute();

        // Check if the insertion was successful
        if ($result) {
            $_SESSION['status'] = "Exam Paper Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='paper_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Exam Paper Details Insertion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='paper_view.php'},1000)</script>";
        }
    }


?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include '../include/importhead.php'; ?>

        <!-- Google Font: Source Sans Pro -->
        <?php include '../include/importcss.php'; ?>


    </head>



    <body class="hold-transition sidebar-mini layout-fixed">
        <div id="preloader">
            <div id="status">&nbsp;

            </div>
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
                                <h1 class="m-0">Add Exam Paper</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Exam Paper</li>

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
                                        <h3 class="card-title">Add Exam Paper</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form id="quickForm" method="POST" enctype="multipart/form-data">

                                        <div class="card-body">


                                            <div class="form-group">
                                                <label>Select Faculty<span style="color: red;" required> *</span></label>
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
                                                <label for="name">Year<span style="color: red;">*</span></label>
                                                <input type="text" name="year" class="form-control" id="year" placeholder="Enter Exam Year " required>
                                            </div>
                                            <div class="form-group">
                                                <label for="session">Exam Session<span style="color: red;"> *</span></label>
                                                <select class="form-control" name="session" id="session" required>
                                                    <option value="">---Select Exam Session---</option>
                                                    <option value="Summer">Summer</option>
                                                    <option value="Winter">Winter</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">Title<span style="color: red;">*</span></label>
                                                <input type="text" name="title" class="form-control" id="title_id" placeholder="Enter Subject Title" required>
                                            </div>
                                            <div class="input-group" id="imgPrev">
                                            </div>

                                            <div name="document" id="document" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload document<span style="color: red;"> *</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="document" id="document" required>
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
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
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">

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
    $(function() {
        bsCustomFileInput.init();
    });
</script>
<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
    const input = document.getElementById('thumbnail');
    const preview = document.getElementById('imgPrev');

    input.addEventListener('change', () => {
        while (preview.firstChild) {
            preview.removeChild(preview.firstChild);
        }

        const files = input.files;
        if (!files) {
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = () => {
                const img = document.createElement('img');
                img.src = reader.result;
                img.style.width = '150px';
                img.style.height = '150px';
                img.style.marginLeft = '20px';
                img.style.marginTop = '10px';
                preview.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    });
</script>