<?php
include '../include/checklogin.php';
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


        <?php

        $place_id = $_GET['id'];
        $status = 0;
        $cmd = $con->prepare("SELECT placement.id as id,placement.faculty_id as faculty_id,placement.level_id as level_id,placement.program_id as program_id, placement.placement_rat as placement_rat,placement.placed_students as placed_students,placement.registered_students as registered_students , placement.highest_package as highest_package,placement.average_package as average_package,placement.year as year,placement.is_active as program_is_active, 
                                            faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_placement_overview as placement
                                            LEFT JOIN tbl_faculty faculty ON placement.faculty_id = faculty.id 
                                            LEFT JOIN tbl_level level ON placement.level_id = level.id 
                                            LEFT JOIN tbl_program program ON placement.program_id = program.id WHERE placement.is_delete = ? and placement.id = ?");
        $cmd->bind_param("ii", $status, $place_id);
        $cmd->execute();
        $result = $cmd->get_result();
        while ($row = $result->fetch_assoc()) {
            $faculty_id = $row['faculty_id'];
            $level_id = $row['level_id'];
            $program_id = $row['program_id'];
            $id = $row['id'];
            $program_name = $row['program_name'];
            $faculty_name = $row['faculty_name'];
            $level_name = $row['level_name'];
            $year = $row['year'];
            $average_package = $row['average_package'];
            $highest_package = $row['highest_package'];
            $placement_rat = $row['placement_rat'];
            $placed_students = $row['placed_students'];
            $registered_students = $row['registered_students'];
        }
        ?>

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
                                <form action="placement_overview_update.php" method="POST" enctype="multipart/form-data">

                                    <div class="card-body">

                                        <?php if ($role_id != 8) { ?>

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
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>

                                           
                                            <div class="form-group">
                                                <label>Select Program<span style="color: red;"> *</span></label>
                                                <select name="program_id" id="program_id" class="form-control" required>
                                                    <option value="">---Select Program---</option>
                                                </select>
                                            </div>
                                        <?php  }  elseif ($role_id == 8) {
                                        ?>
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
                                        <?php
                                        }
                                        ?>
                                        <input type="hidden" name="id" value="<?php echo $place_id; ?>">
                                        <div class="form-group">
                                            <label for="title_name">Year<span style="color: red;">*</span></label>
                                            <input type="text" name="year" value="<?php echo $year; ?>" class="form-control" id="title" placeholder="Enter Year" pattern="[0-9]*" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="title_name">Registered Students(Only Numbers)<span style="color: red;">*</span></label>
                                            <input type="text" name="registered_students" value="<?php echo $registered_students; ?>" class="form-control" id="title" placeholder="Enter Registered Students" pattern="[0-9]*" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="title_name">Placed Students(Only Numbers)<span style="color: red;">*</span></label>
                                            <input type="text" name="placed_students" class="form-control" value="<?php echo $placed_students ?>" id="title" placeholder="Enter Placed Students" pattern="[0-9]*" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="title_name">Placement Rate(Only Numbers)<span style="color: red;">*</span></label>
                                            <input type="text" name="placement_rat" value="<?php echo $placement_rat ?>" class="form-control" id="title" placeholder="Enter Placement Rate" pattern="[0-9]*" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="title_name">Highest Package(Only Numbers)<span style="color: red;">*</span></label>
                                            <input type="text" name="highest_package" value="<?php echo $highest_package ?>" class="form-control" id="title" placeholder="Enter Highest Package" pattern="[0-9]*" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="title_name">Average Package(Only Numbers)<span style="color: red;">*</span></label>
                                            <input type="text" name="average_package" value="<?php echo $average_package ?>" class="form-control" id="title" placeholder="Enter Average Package" pattern="[0-9]*" required>
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