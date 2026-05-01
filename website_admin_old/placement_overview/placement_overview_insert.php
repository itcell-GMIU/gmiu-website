<?php
include '../include/checklogin.php';
if ($role_id == 8) {
    if (isset($_POST['submit'])) {

        $average_package = mysqli_real_escape_string($con, $_POST['average_package']);
        $highest_package = mysqli_real_escape_string($con, $_POST['highest_package']);
        $placement_rat = mysqli_real_escape_string($con, $_POST['placement_rat']);
        $placed_students = mysqli_real_escape_string($con, $_POST['placed_students']);
        $companies_visited = mysqli_real_escape_string($con, $_POST['companies_visited']);
        $registered_students = mysqli_real_escape_string($con, $_POST['registered_students']);
        $year = mysqli_real_escape_string($con, $_POST['year']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);

        // validate Data

        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);
        $program_id = validate_data($program_id);

        // insert the data into database
        $stmt = $con->prepare("INSERT INTO `tbl_placement_overview`(faculty_id,level_id,program_id,year,average_package,highest_package,placement_rat,placed_students,registered_students, companies_visited)VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("iiiiiiiiii", $faculty_id, $level_id, $program_id, $year, $average_package, $highest_package,  $placement_rat, $placed_students, $registered_students, $companies_visited);
        $result = $stmt->execute();
        if ($result) {
            if ($result) {
                $_SESSION['status'] = "Placement Overview Inserted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='placement_overview_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Placement Overview Insertion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='placement_overview_view.php'},1000)</script>";
            }
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include '../include/importhead.php'; ?>
        <!-- Google Font: Source Sans Pro -->
        <?php include '../include/importcss.php'; ?>
        <!-- dropzonejs -->
        <link rel="stylesheet" href="../../admin_assets/plugins/dropzone/min/dropzone.min.css">
        <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                CKEDITOR.replace('text_editor');
            });
        </script>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
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
                                <h1 class="m-0">Add Placement Overview</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Placement Overview</li>

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
                                        <h3 class="card-title">Add Placement Overview</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST" enctype="multipart/form-data">

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
                                                <label for="title_name">Year<span style="color: red;">*</span></label>
                                                <input type="text" name="year" class="form-control" id="title" placeholder="Enter Year" pattern="[0-9]*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title_name">Registered Students(Only Numbers)<span style="color: red;">*</span></label>
                                                <input type="text" name="registered_students" class="form-control" id="title" placeholder="Enter Registered Students" pattern="[0-9]*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title_name">Placed Students(Only Numbers)<span style="color: red;">*</span></label>
                                                <input type="text" name="placed_students" class="form-control" id="title" placeholder="Enter Placed Students" pattern="[0-9]*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title_name">Placement Rate(Only Numbers)<span style="color: red;">*</span></label>
                                                <input type="text" name="placement_rat" class="form-control" id="title" placeholder="Enter Placement Rate" pattern="[0-9]*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title_name">Highest Package(Only Numbers)<span style="color: red;">*</span></label>
                                                <input type="text" name="highest_package" class="form-control" id="title" placeholder="Enter Highest Package" pattern="[0-9]*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title_name">Average Package(Only Numbers)<span style="color: red;">*</span></label>
                                                <input type="text" name="average_package" class="form-control" id="title" placeholder="Enter Average Package" pattern="[0-9]*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title_name">Total Number of Companies Visited(Only Numbers)<span style="color: red;">*</span></label>
                                                <input type="text" name="companies_visited" class="form-control" id="title" placeholder="Enter Total Number of Companies Visited" pattern="[0-9]*" required>
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

        <!-- dropzonejs -->
        <script src="../../admin_assets/plugins/dropzone/min/dropzone.min.js"></script>
    </body>

    </html>
<?php
} else {
    if (isset($_POST['submit'])) {


        $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
        $average_package = mysqli_real_escape_string($con, $_POST['average_package']);
        $highest_package = mysqli_real_escape_string($con, $_POST['highest_package']);
        $placement_rat = mysqli_real_escape_string($con, $_POST['placement_rat']);
        $placed_students = mysqli_real_escape_string($con, $_POST['placed_students']);
        $companies_visited = mysqli_real_escape_string($con, $_POST['companies_visited']);
        $registered_students = mysqli_real_escape_string($con, $_POST['registered_students']);
        $year = mysqli_real_escape_string($con, $_POST['year']);

        // validate Data

        $faculty_id = validate_data($faculty_id);
        $level_id = validate_data($level_id);
        $program_id = validate_data($program_id);

        // insert the data into database
        $stmt = $con->prepare("INSERT INTO `tbl_placement_overview`(faculty_id,level_id,program_id,year,average_package,highest_package,placement_rat,placed_students,registered_students, companies_visited)VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("iiiiiiiiii", $faculty_id, $level_id, $program_id, $year, $average_package, $highest_package,  $placement_rat, $placed_students, $registered_students, $companies_visited);
        $result = $stmt->execute();
        if ($result) {
            if ($result) {
                $_SESSION['status'] = "Placement Overview Inserted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='placement_overview_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Placement Overview Insertion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='placement_overview_view.php'},1000)</script>";
            }
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include '../include/importhead.php'; ?>
        <!-- Google Font: Source Sans Pro -->
        <?php include '../include/importcss.php'; ?>
        <!-- dropzonejs -->
        <link rel="stylesheet" href="../../admin_assets/plugins/dropzone/min/dropzone.min.css">
        <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                CKEDITOR.replace('text_editor');
            });
        </script>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
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
                                <h1 class="m-0">Add Placement Overview</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Placement Overview</li>

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
                                        <h3 class="card-title">Add Placement Overview</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST" enctype="multipart/form-data">

                                        <div class="card-body">



                                            <div class="form-group">
                                                <label>Select Faculty<span style="color: red;"> *</span></label>
                                                <select class="form-control" name="faculty_id" required id="faculty_id">
                                                    <option value="">---Select Faculty---</option>
                                                    <?php
                                                    $cmd = "SELECT id,name FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
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
                                                <label for="title_name">Year<span style="color: red;">*</span></label>
                                                <input type="text" name="year" class="form-control" id="title" placeholder="Enter Year" pattern="[0-9]*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title_name">Registered Students(Only Numbers)<span style="color: red;">*</span></label>
                                                <input type="text" name="registered_students" class="form-control" id="title" placeholder="Enter Registered Students" pattern="[0-9]*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title_name">Placed Students(Only Numbers)<span style="color: red;">*</span></label>
                                                <input type="text" name="placed_students" class="form-control" id="title" placeholder="Enter Placed Students" pattern="[0-9]*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title_name">Placement Rate(Only Numbers)<span style="color: red;">*</span></label>
                                                <input type="text" name="placement_rat" class="form-control" id="title" placeholder="Enter Placement Rate" pattern="[0-9]*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title_name">Highest Package(Only Numbers)<span style="color: red;">*</span></label>
                                                <input type="text" name="highest_package" class="form-control" id="title" placeholder="Enter Highest Package" pattern="[0-9]*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title_name">Average Package(Only Numbers)<span style="color: red;">*</span></label>
                                                <input type="text" name="average_package" class="form-control" id="title" placeholder="Enter Average Package" pattern="[0-9]*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title_name">Total Number of Companies Visited(Only Numbers)<span style="color: red;">*</span></label>
                                                <input type="text" name="companies_visited" class="form-control" id="title" placeholder="Enter Total Number of Companies Visited" pattern="[0-9]*" required>
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

        <!-- dropzonejs -->
        <script src="../../admin_assets/plugins/dropzone/min/dropzone.min.js"></script>
    </body>

    </html>
<?php } ?>
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