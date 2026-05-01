<?php
include '../include/checklogin.php';
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
                            <h1 class="m-0">Edit Our Hackathon</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Our Hackathon</li>
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
                                    <h3 class="card-title">Edit Our Hackathon</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" action="our_hackathon_update.php" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <!-- Fetching data based on exp_id -->
                                        <?php
                                        if (isset($_GET['exp_id']) && !empty($_GET['exp_id'])) {
                                            $exp_id = mysqli_real_escape_string($con, $_GET['exp_id']);
                                            $exp_id = only_digits($exp_id);
                                            if ($exp_id == false) {
                                                $_SESSION['status'] = "Invalid data in URL";
                                                $_SESSION['status_code'] = "error";
                                                echo "<script>setTimeout(function(){window.location='our_hackathon_view.php'},1000)</script>";
                                            }
                                            $status = 0;
                                            $cmd = $con->prepare("SELECT exp.faculty_id as faculty_id, exp.level_id as level_id, exp.program_id as program_id, exp.title as exp_title,  exp.team_leader as exp_team_leader, exp.team_member as exp_team_member, exp.location as exp_location FROM tbl_our_hackathon as exp WHERE exp.is_delete = ? AND exp.id = ?");
                                            $cmd->bind_param("ii", $status, $exp_id);
                                            $cmd->execute();
                                            $result = $cmd->get_result();

                                            while ($row = $result->fetch_assoc()) {
                                                $exp_title = !empty($row['exp_title']) ? $row['exp_title'] : 'N/A';
                                                $exp_team_leader = !empty($row['exp_team_leader']) ? $row['exp_team_leader'] : 'N/A';
                                                $exp_team_member = !empty($row['exp_team_member']) ? $row['exp_team_member'] : 'N/A';
                                                $exp_location = !empty($row['exp_location']) ? $row['exp_location'] : 'N/A';
                                                $faculty_id = $row['faculty_id'];
                                                $level_id = $row['level_id'];
                                                $program_id = $row['program_id'];
                                            }
                                        }
                                        ?>
                                        <!-- End fetching data -->

                                        <!-- Faculty, Level, Program dropdowns -->
                                        <?php if ($role_id != 8) { ?>
                                            <div class="form-group">
                                                <input type="hidden" name="id" value="<?php echo $exp_id ?>">
                                                <label>Select Faculty</label>
                                                <select id="faculty_id" name="faculty_id" class="browser-default custom-select" required>
                                                    <option value="">---Select Faculty---</option>
                                                    <?php
                                                    $cmd = "SELECT id,name FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
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

                                            <label>Select Level</label>
                                            <select name="level_id" id="level_id" class="form-control" required>
                                                <option value="">---Select Level---</option>
                                            </select>

                                            <div class="form-group">
                                                <label>Select Program<span style="color: red;"> *</span></label>
                                                <select name="program_id" id="program_id" class="form-control" required>
                                                    <option value="">---Select Program---</option>
                                                </select>
                                            </div>
                                        <?php } elseif ($role_id == 8) { ?>
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
                                        <?php } ?>
                                        <!-- End Faculty, Level, Program dropdowns -->

                                        <!-- Title, Date, Team Leader, Team Member, Location fields -->
                                        <div class="form-group">
                                            <label for="title_id">Title<span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title_id" value="<?php echo $exp_title; ?>" placeholder="Enter Our Project Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="team_leader_id">Team Leader<span style="color: red;">*</span></label>
                                            <input type="text" name="team_leader" class="form-control" id="team_leader_id" value="<?php echo $exp_team_leader; ?>" placeholder="Enter Team Leader Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="team_member_id">Team Member<span style="color: red;">*</span></label>
                                            <input type="text" name="team_member" class="form-control" id="team_member_id" value="<?php echo $exp_team_member; ?>" placeholder="Enter Team Member Names" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="location_id">Location<span style="color: red;">*</span></label>
                                            <input type="text" name="location" class="form-control" id="location_id" value="<?php echo $exp_location; ?>" placeholder="Enter Location" required>
                                        </div>
                                        <div name="image" id="image" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Image</label><span style="color: red;"> *</span>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="imgInp" name="images[]" multiple>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="imgPrev">
                                        </div>
                                        <div name="image_display_main" id="image_display_main" class="form-group">
                                            <?php
                                            $status = 0;
                                            $type = "our_hackathon";
                                            $cmd = $con->prepare("SELECT photos.file_name as file_name  FROM `tbl_site_photos` as photos  where  photos.type = ? and photos.type_id = ?");
                                            $cmd->bind_param("ss", $type, $exp_id);
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $file_name  = !empty($row['file_name']) ? $row['file_name'] : "<b>N/A</b>";
                                            ?>
                                                <span name="image_display" id="image_display" class="form-group">
                                                    <img src="<?php echo "../uploads/our_project/image/" . "$file_name"; ?>" width="200" height="200">
                                                </span>
                                            <?php
                                            } ?>
                                        </div>
                                        
                                        <div class="form-group">
                                            <!-- <label>Status<span style="color: red;">*</span></label> -->
                                            <!--  <select class="form-control" name="program_status">
                                                <option value="1" <?php if ($program_is_active == "1") {
                                                                        echo "selected";
                                                                    } ?>>Active
                                                </option>
                                                <option value="0" <?php if ($program_is_active == "0") {
                                                                        echo "selected";
                                                                    } ?>>
                                                    InActive</option>

                                            </select> -->
                                        </div>
                                        
                                    </div>
                                    
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6"></div>
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
            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id
                },
                success: function(result) {
                    $('#level_id').html(result);
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
</body>

</html>
