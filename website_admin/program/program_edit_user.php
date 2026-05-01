<?php

// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_POST['submit'])) {

    $program_id = $_GET['program_id']; // from URL
    $program_description = $_POST['program_description'];

    $cmd = $con->prepare("UPDATE tbl_program SET description=? WHERE id=?");
    $cmd->bind_param("si", $program_description, $program_id);

    if ($cmd->execute()) {

        $_SESSION['status'] = "Program updated successfully";
        $_SESSION['status_code'] = "success";
    } else {

        $_SESSION['status'] = "Program update failed";
        $_SESSION['status_code'] = "error";
    }

    header("Location: program_view_admin.php");
    exit();
}
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
        $program_description = !empty($row['program_description']) ? $row['program_description'] : '';
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
                                <form method="POST">
                                    <!-- card-body -->
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="text_editor">Description </label>
                                            <textarea id="text_editor"
                                                name="program_description"><?php echo htmlspecialchars_decode($program_description); ?></textarea>
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