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

if (isset($_GET['program_id']) && !empty($_GET['program_id'])) {

    $program_id = mysqli_real_escape_string($con, $_GET['program_id']);
    $program_id = only_digits($program_id);
    if ($program_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='program_view.php'},1000)</script>"; 
        }
    // Fetch program id and level id from display table
    $program_id = $_GET['program_id'];
    $level_id = $_GET['level_id'];
    $cmd = "SELECT pro.minor as program_minor,pro.short_no as short_no,pro.token_minor as minor_token,pro.id as program_id, pro.faculty_id as faculty_id, pro.level_id as level_id, pro.name as program_name, pro.shortname as program_shortname, pro.code as program_code, pro.intake as program_intake, pro.duration as program_duration, pro.regular as program_regular, pro.blended_mode as program_blended_mode, pro.honors as program_honors, pro.international as program_international, pro.genius as program_genius, pro.token as regular_token, pro.video_link as program_video_link, pro.is_active as program_is_active, pro.description as program_description , pro.token_genius as genius_token, pro.token_international as token_international, pro.token_honors as token_honors, pro.token_blended_mode as token_blended_mode FROM tbl_program as pro WHERE pro.id = $program_id";
    $stmt = $con->prepare($cmd);
    $stmt->execute();
    $result = $stmt->get_result();


while ($row = $result->fetch_assoc()) {

    // Fetch data from database
    $faculty_id = $row['faculty_id'];
    $short_no = $row['short_no'];
    $program_name = !empty($row['program_name']) ? $row['program_name'] : '';
    $program_shortname = !empty($row['program_shortname']) ? $row['program_shortname'] : '';
    $program_code = !empty($row['program_code']) ? $row['program_code'] : '';
    $program_intake = !empty($row['program_intake']) ? $row['program_intake'] : '';
    $program_duration = !empty($row['program_duration']) ? $row['program_duration'] : '';
    $program_regular = !empty($row['program_regular']) ? $row['program_regular'] : '';
    $program_blended_mode = !empty($row['program_blended_mode']) ? $row['program_blended_mode'] : '';
    $program_honors = !empty($row['program_honors']) ? $row['program_honors'] : '';
    $program_international = !empty($row['program_international']) ? $row['program_international'] : '';
    $program_genius = !empty($row['program_genius']) ? $row['program_genius'] : '';
    $program_minor = !empty($row['program_minor']) ? $row['program_minor'] : '';
    $regular_token = !empty($row['regular_token']) ? $row['regular_token'] : '';
    $program_video_link = !empty($row['program_video_link']) ? $row['program_video_link'] : '';
    $program_description = !empty($row['program_description']) ? $row['program_description'] : '';
    // $short_description = !empty($row['short_description']) ? $row['short_description'] : '';
    $program_is_active = $row['program_is_active'];
    $token_blended_mode = !empty($row['token_blended_mode']) ? $row['token_blended_mode'] : '';
    $token_honors = !empty($row['token_honors']) ? $row['token_honors'] : '';
    $token_international = !empty($row['token_international']) ? $row['token_international'] : '';
    $genius_token = !empty($row['genius_token']) ? $row['genius_token'] : '';
    $minor_token = !empty($row['minor_token']) ? $row['minor_token'] : '';
}
}
?>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> <!-- /.Preloader -->

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
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row mb-2">

                        <!-- col -->
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Program</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Program</li>

                            </ol>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div> <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- card -->
                            <div class="card card-gmiu">
                                <!-- card-header -->
                                <div class="card-header">
                                    <h3 class="card-title">Edit Program</h3>
                                </div> <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST" action="program_update.php">
                                    <!-- card-body -->
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Select Faculty<span style="color: red;">*</span></label>
                                            <select class="form-control" name="faculty_id" id="faculty_id" required>
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
                                            <label>Select Level<span style="color: red;">*</span></label>
                                            <select name="level_id" id="level_id" class="form-control" required>
                                                <option value="">---Select Level---</option>
                                            </select>
                                        </div>

                                        <!-- hidden program_id -->
                                        <input type="hidden" name="program_id" value="<?php echo $program_id; ?>">

                                        <div class="form-group">
                                            <label for="name">Name<span style="color: red;">*</span></label>
                                            <input type="text" name="program_name" class="form-control" id="name"
                                                placeholder="Enter Name" value="<?php echo $program_name; ?>" required>
                                        </div>
                                         <div class="form-group">
                                            <label for="code">Shortable No</label>
                                            <input type="text" name="program_short_no" class="form-control" id="code"
                                                placeholder="Enter Shortable No" value="<?php echo $short_no; ?>">
                                        </div>

                                        <!-- <div class="form-group">
                                            <label for="shortdes">Short Description <span style="color: red;">*</span></label>
                                            <textarea id="short_description" class="ckeditor" name="short_description" required><?php echo htmlspecialchars_decode($short_description); ?></textarea>
                                        </div> -->

                                        <div class="form-group">
                                            <label for="text_editor">Description </label>
                                            <textarea id="text_editor"
                                                name="program_description"><?php echo htmlspecialchars_decode($program_description); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="video_link">Video Link</label>
                                            <input type="text" name="program_video_link" class="form-control"
                                                id="video_link" placeholder="Enter Video Link"
                                                value="<?php echo $program_video_link; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="shortname">Short Name</label>
                                            <input type="text" name="program_shortname" class="form-control"
                                                id="shortname" placeholder="Enter shortname"
                                                value="<?php echo $program_shortname; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="code">Code</label>
                                            <input type="text" name="program_code" class="form-control" id="code"
                                                placeholder="Enter code" value="<?php echo $program_code; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="intake">Intake</label>
                                            <input type="text" name="program_intake" class="form-control" id="intake"
                                                placeholder="Enter intake" value="<?php echo $program_intake; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="duration">Duration</label>
                                            <input type="text" name="program_duration" class="form-control"
                                                id="duration" placeholder="Enter duration"
                                                value="<?php echo $program_duration; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="token">Regular Token<span style="color: red;">*</span></label>
                                            <input type="text" name="regular_token" class="form-control" id="token"
                                                placeholder="Enter token" value="<?php echo $regular_token; ?>"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="token">Genius Token</label>
                                            <input type="text" name="genius_token" class="form-control"
                                                id="genius_token" value="<?php echo $genius_token; ?>"
                                                placeholder="Enter Genius Token ">
                                        </div>
                                        <div class="form-group">
                                            <label for="minor_token">Minor Token</label>
                                            <input type="text" name="minor_token" class="form-control" id="minor_token"
                                                value="<?php echo $minor_token; ?>" placeholder="Enter minor Token ">
                                        </div>
                                        <div class="form-group">
                                            <label for="regular">Regular Total fees</label>
                                            <input type="text" name="program_regular" class="form-control" id="regular"
                                                placeholder="Enter regular" value="<?php echo $program_regular; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="genius">Genius Total fees</label>
                                            <input type="text" name="program_genius" class="form-control" id="genius"
                                                placeholder="Enter genius" value="<?php echo $program_genius; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="minor">Minor Total fees</label>
                                            <input type="text" name="program_minor" class="form-control" id="minor"
                                                placeholder="Enter minor" value="<?php echo $program_minor; ?>">
                                        </div>


                                        <!--   <div class="form-group">
                                            <label for="blended_mode">Blended Mode Total fees</label>
                                            <input type="text" name="program_blended_mode" class="form-control"
                                                id="blended_mode" placeholder="Enter blended_mode"
                                                value="<?php /* echo  $program_blended_mode; */ ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="honors">Honors Total Fees</label>
                                            <input type="text" name="program_honors" class="form-control" id="honors"
                                                placeholder="Enter honors" value="<?php /* echo $program_honors; */ ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="international">International Total Fees</label>
                                            <input type="text" name="program_international" class="form-control"
                                                id="international" placeholder="Enter international"
                                                value="<?php /* echo $program_international; */ ?>">
                                        </div> -->





                                        <!-- 
                                        <div class="form-group">
                                            <label for="token">Blended Mode Token</label>
                                            <input type="text" name="blended_mode_token" class="form-control"
                                                id="blended_mode_token" value="<?php /*  echo $token_blended_mode;  */?>"
                                                placeholder="Enter Blended Mode Token ">
                                        </div> -->

                                        <!--    <div class="form-group">
                                            <label for="token">Honors Token</label>
                                            <input type="text" name="honors_token" class="form-control"
                                                id="honors_token" value="<?php /* echo $token_honors; */ ?>"
                                                placeholder="Enter Honors Token ">
                                        </div>
-->

                                        <!--    <div class="form-group">
                                            <label for="token">International Token </label>
                                            <input type="text" name="international_token" class="form-control"
                                                id="international_token" value="<?php  echo $token_international;  ?>"
                                                placeholder="Enter International Token">
                                        </div> -->

                                        <div class="form-group">
                                            <label>Status<span style="color: red;">*</span></label>
                                            <select class="form-control" name="program_status">
                                                <option value="1" <?php if ($program_is_active == "1") {
                                                                        echo "selected";
                                                                    } ?>>Active
                                                </option>
                                                <option value="0" <?php if ($program_is_active == "0") {
                                                                        echo "selected";
                                                                    } ?>>
                                                    InActive</option>

                                            </select>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div> <!-- /.card-body -->
                                </form>
                            </div> <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                    </div> <!-- row -->
                </div><!-- /.container-fluid -->
            </section> <!-- /.content -->
        </div> <!-- /.content-wrapper -->

        <!-- footer -->
        <?php include '../include/importfooter.php'; ?>
        <!-- /.footer -->

    </div>
    <!-- ./wrapper -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>

<!-- Script for load levels dynamically -->
<script>
$(document).ready(function() {

    //call for listing the dropdown and select by default
    load_level();

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
            api_for: api_for,
            level_id: level_id
        },
        success: function(result) {
            $('#level_id').html(result);
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
</script>