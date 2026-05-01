<?php
include '../include/checklogin.php';
if ($role_id == 8) {
    if (isset($_POST['submit'])) {

        $student_name = mysqli_real_escape_string($con, $_POST['student_name']);
        $year = mysqli_real_escape_string($con, $_POST['year']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);

        // Fetch and validate data
        $faculty_id = $_SESSION['faculty_id'];
        $program_id = $_SESSION['program_id'];
        $program_id = validate_data($program_id);
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);
        $student_name = validate_data($student_name);
        $year = validate_data($year);

        // Check if student image is uploaded
        if (isset($_FILES['student_image'])) {
            $targetDirectory = "../uploads/placement/student_image/";
            $file_upload_status = upload_single_file($_FILES["student_image"], $targetDirectory, 1);
            if ($file_upload_status['status'] == 200) {
                $student_image = $file_upload_status['message'];
            }
        }
        // Check if company logo is uploaded
        if (isset($_FILES['company_logo'])) {
            $targetDirectory = "../uploads/placement/company_logo/";
            $file_upload_status = upload_single_file($_FILES["company_logo"], $targetDirectory, 1);
            if ($file_upload_status['status'] == 200) {
                $company_logo = $file_upload_status['message'];
            }
        }

        // Prepare and execute SQL statement for inserting data into 'tbl_placement'
        $stmt = $con->prepare("INSERT INTO `tbl_placement`(faculty_id,level_id,program_id,student_name,year,student_image,company_logo)VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("iisssss", $faculty_id, $level_id, $program_id, $student_name, $year, $student_image, $company_logo);
        $result = $stmt->execute();
        if ($result) {

            // Set session status and code for success
            $_SESSION['status'] = "Placement Statistics Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='placement_view.php'},1000);</script>";
        } else {
            // Set session status and code for error if insertion failed
            $_SESSION['status'] = "Mission & Vision Insertion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='mission_vision_view.php'},1000)</script>";
        }
    }

?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include '../include/importhead.php'; ?>

        <!-- Google Font: Source Sans Pro -->
        <?php include '../include/importcss.php'; ?>

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-selection__choice__display {
                color: #000000;
            }
        </style>


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
                                <h1 class="m-0">Add Placement Statistics</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Placement Statistics</li>

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
                                        <h3 class="card-title">Add Placement Statistics</h3>
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
                                                <label for="intake">Student Name <span style="color: red;">*</span></label>
                                                <input type="text" name="student_name" class="form-control" id="name" placeholder="Enter Student Name" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Student Image</label><span style="color: red;"> *</span>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="student_image" id="file_input" required>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" id="imgPrev">
                                            </div>

                                            <div class="form-group">
                                                <label for="year">Enter Passing Year <span style="color: red;"> *</span></label>
                                                <select id="ddlYears" name="year" id="year" class="form-control">
                                                    <option value="">--Select Passing Year--</option>
                                                </select>
                                                <!-- <input type="text" placeholder="Enter Passing Year"> -->
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Company Logo</label><span style="color: red;"> *</span>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="company_logo" id="file_input1" required>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" id="imgPrev1">
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

        $program_ids = $_POST['program_id']; // This is an array from the multiple select
        $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        $student_name = mysqli_real_escape_string($con, $_POST['student_name']);
        $year = mysqli_real_escape_string($con, $_POST['year']);

        // Validate and process data
        // Convert the array of program IDs into a single comma-separated string to store in the database.
        $program_id_str = implode(',', array_map('intval', $program_ids));
        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);
        $student_name = validate_data($student_name);
        $year = validate_data($year);

        // Check if student image is uploaded
        if (isset($_FILES['student_image'])) {
            $targetDirectory = "../uploads/placement/student_image/";
            $file_upload_status = upload_single_file($_FILES["student_image"], $targetDirectory, 1);
            if ($file_upload_status['status'] == 200) {
                $student_image = $file_upload_status['message'];
            }
        }
        // Check if company logo is uploaded
        if (isset($_FILES['company_logo'])) {
            $targetDirectory = "../uploads/placement/company_logo/";
            $file_upload_status = upload_single_file($_FILES["company_logo"], $targetDirectory, 1);
            if ($file_upload_status['status'] == 200) {
                $company_logo = $file_upload_status['message'];
            }
        }

        // Prepare and execute SQL statement for inserting data into 'tbl_placement'
        $stmt = $con->prepare("INSERT INTO `tbl_placement`(faculty_id,level_id,program_id,student_name,year,student_image,company_logo)VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("iisssss", $faculty_id, $level_id, $program_id_str, $student_name, $year, $student_image, $company_logo);
        $result = $stmt->execute();
        if ($result) {

            // Set session status and code for success
            $_SESSION['status'] = "Placement Statistics Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='placement_view.php'},1000);</script>";
        } else {
            // Set session status and code for error if insertion failed
            $_SESSION['status'] = "Mission & Vision Insertion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='mission_vision_view.php'},1000)</script>";
        }
    }

?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include '../include/importhead.php'; ?>

        <!-- Google Font: Source Sans Pro -->
        <?php include '../include/importcss.php'; ?>

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-selection__choice__display {
                color: #000000;
            }
        </style>


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
                                <h1 class="m-0">Add Placement Statistics</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Placement Statistics</li>

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
                                        <h3 class="card-title">Add Placement Statistics</h3>
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
                                                <select name="program_id[]" id="program_id" class="form-control" multiple="multiple" required>
                                                    <option value="">---Select Program---</option>
                                                </select>
                                            </div>



                                            <div class="form-group">
                                                <label for="intake">Student Name <span style="color: red;">*</span></label>
                                                <input type="text" name="student_name" class="form-control" id="name" placeholder="Enter Student Name" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Student Image</label><span style="color: red;"> *</span>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="student_image" id="file_input" required>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" id="imgPrev">
                                            </div>

                                            <div class="form-group">
                                                <label for="year">Enter Passing Year <span style="color: red;"> *</span></label>
                                                <select id="ddlYears" name="year" id="year" class="form-control">
                                                    <option value="">--Select Passing Year--</option>
                                                </select>
                                                <!-- <input type="text" placeholder="Enter Passing Year"> -->
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Company Logo</label><span style="color: red;"> *</span>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="company_logo" id="file_input1" required>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" id="imgPrev1">
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

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#program_id').select2({
                    placeholder: "---Select Program---",
                    allowClear: true
                });
            });
        </script>
    </body>

    </html>
<?php } ?>
<!-- Script for year dropdown -->
<script type="text/javascript">
    window.onload = function() {
        //Reference the DropDownList.
        var ddlYears = document.getElementById("ddlYears");

        //Determine the Current Year.
        var currentYear = 2030;

        //Loop and add the Year values to DropDownList.
        for (var i = 1950; i <= currentYear; i++) {
            var option = document.createElement("OPTION");
            option.innerHTML = i;
            option.value = i;
            ddlYears.appendChild(option);
        }
    };
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
    const input = document.getElementById('file_input');
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
<script>
    const input1 = document.getElementById('file_input1');
    const preview1 = document.getElementById('imgPrev1');

    input1.addEventListener('change', () => {
        while (preview1.firstChild) {
            preview1.removeChild(preview1.firstChild);
        }

        const files = input1.files;
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
                preview1.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    });
</script>