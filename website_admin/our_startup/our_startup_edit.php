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
<?php

// GET faculty id from display table
if (isset($_GET['startup_id']) && !empty($_GET['startup_id'])) {
    $startup_id = mysqli_real_escape_string($con, $_GET['startup_id']);
    $startup_id = only_digits($startup_id);
    if ($startup_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='our_startup_view.php'},1000)</script>";
    }
    $status = 0;
    $cmd = $con->prepare("SELECT startup.title as title, startup.is_active as startup_is_active FROM tbl_our_startup as startup WHERE startup.is_delete = ? AND startup.id = ?");
    $cmd->bind_param("ii", $status, $startup_id);
    $cmd->execute();
    $result = $cmd->get_result();

    while ($row = $result->fetch_assoc()) {

        $title = !empty($row['title']) ? $row['title'] : 'N/A';
    }
}
?>

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
                            <h1 class="m-0">Edit Our Startup</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Our Startup</li>

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
                                    <h3 class="card-title">Edit Our Startup</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" action="our_startup_update.php" enctype="multipart/form-data">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <input type="hidden" name="id" value="<?php echo $startup_id ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="title_id">Title<span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title_id" value="<?php echo $title; ?>" placeholder="Enter Our Startup" required>
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
                                        <div name="image_display_main" id="image_display_main" class="form-group">
                                            <?php
                                            $status = 0;
                                            $type = "Startup";
                                            $cmd = $con->prepare("SELECT photos.file_name as file_name  FROM `tbl_site_photos` as photos  where  photos.type = ? and photos.type_id = ?");
                                            $cmd->bind_param("si", $type, $startup_id);
                                            $cmd->execute();
                                            $result2 = $cmd->get_result();
                                            while ($row = $result2->fetch_assoc()) {
                                                $file_name  = !empty($row['file_name']) ? $row['file_name'] : "<b>N/A</b>";
                                            ?>
                                                <span name="image_display" id="image_display" class="form-group">
                                                    <img src="<?php echo "../uploads/our_startup/image/" . "$file_name"; ?>" width="200" height="200">
                                                </span>
                                                
                                            <?php
                                            } ?>
                                        </div>
                                        <!-- /.card-body -->
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

<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>

<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
    $(document).ready(function() {
        {
            $("#image_display_main").show();
        }
        $("#imgInp").change(function() {
            var selectedOption = $(this).children("option:selected").val();
            $("#image_display_main").hide();
        });
    });
</script>