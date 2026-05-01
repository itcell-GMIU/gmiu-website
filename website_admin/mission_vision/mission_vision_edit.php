<?php
// Include the checklogin.php file
include '../include/checklogin.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Header  -->
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

// Fetch mission_vision id from display table
if (isset($_GET['mission_vision_id']) && !empty($_GET['mission_vision_id'])) {
    $mission_vision_id = mysqli_real_escape_string($con, $_GET['mission_vision_id']);
    $mission_vision_id = only_digits($mission_vision_id);
    if ($mission_vision_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='mission_vision_view.php'},1000)</script>";
    }
    $cmd = $con->prepare("SELECT mission_vision.id as mission_vision_id, mission_vision.faculty_id as faculty_id, mission_vision.level_id as level_id, mission_vision.program_id  as program_id,mission_vision.mission as mission_vision_mission, mission_vision.vision as mission_vision_vision, mission_vision.is_active as mission_vision_is_active FROM tbl_mission_vision as mission_vision WHERE mission_vision.id = ?");
    $cmd->bind_param("i", $mission_vision_id);
    $cmd->execute();
    $result = $cmd->get_result();
    while ($row = $result->fetch_assoc()) {

        // Fetch data from database
        $mission_vision_id = $row['mission_vision_id'];
        $mission = !empty($row['mission_vision_mission']) ? $row['mission_vision_mission'] : "<b>N/A</b>";
        $vision = !empty($row['mission_vision_vision']) ? $row['mission_vision_vision'] : "<b>N/A</b>";
        $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
        $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
        $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
        $mission_vision_program_id = $row['program_id'];
        $mission_vision_program_id = explode(",", $mission_vision_program_id);
        $mission_vision_is_active = $row['mission_vision_is_active'];
    }
}
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
    <!-- wrapper -->
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
                            <h1 class="m-0">Edit Mission & Vision</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Mission & Vision</li>

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
                                    <h3 class="card-title">Edit Mission & Vision</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" action="mission_vision_update.php">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Select program<span style="color: red;"> *</span></label>
                                            <!-- <div class="multi-select"> -->
                                            <div class="selected-items"></div>
                                            <select class="select2option" style="width: 100%" name="program_id[]" multiple="multiple">
                                                <?php
                                                $cmd = "SELECT pro.id,pro.name,level.name as level_name FROM tbl_program as pro LEFT JOIN tbl_faculty faculty
                                              ON pro.faculty_id = faculty.id LEFT JOIN tbl_level level
                                              ON pro.level_id = level.id WHERE pro.is_delete = 0 and pro.is_active=1 ";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    $program_id = $row['id'];
                                                    $program_name = $row['name'];
                                                    $level_name = $row['level_name'];
                                                ?>

                                                    <option value="<?php echo $program_id; ?>" <?php if (in_array($program_id, $mission_vision_program_id)) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                        <?php echo $program_name . "(" . $level_name . ")"; ?></option>
                                                <?php } ?>

                                            </select>

                                        </div>

                                        <!-- hidden mission_vision_id -->
                                        <input type="hidden" name="mission_vision_id" value="<?php echo $mission_vision_id; ?>">


                                        <div class="form-group">
                                            <label for="mission">Mission<span style="color: red;">*</span> </label>
                                            <textarea id="mission" class="ckeditor" name="mission" required><?php echo htmlspecialchars_decode($mission); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="vision">Vision<span style="color: red;">*</span> </label>
                                            <textarea id="vision" class="ckeditor" name="vision" required><?php echo htmlspecialchars_decode($vision); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Status<span style="color: red;">*</span></label>
                                            <select class="form-control" name="mission_vision_status">
                                                <option value="1" <?php if ($mission_vision_is_active == "1") {
                                                                        echo "selected";
                                                                    } ?>>Active
                                                </option>
                                                <option value="0" <?php if ($mission_vision_is_active == "0") {
                                                                        echo "selected";
                                                                    } ?>>
                                                    InActive</option>

                                            </select>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
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
        <!-- /.content -->
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

<!-- Script for select2 -->
<script>
    $(document).ready(function() {
        $('.select2option').select2();
    });
</script>
<!-- Script for load levels dynamically -->
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