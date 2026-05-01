
<?php

include '../include/checklogin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
</head>
<?php

// GET faculty id from display table
if (isset($_GET['nss_unit_id']) && !empty($_GET['nss_unit_id'])) {
    $nss_unit_id = mysqli_real_escape_string($con, $_GET['nss_unit_id']);
    $nss_unit_id = only_digits($nss_unit_id);
    if ($nss_unit_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='nss_unit_view.php'},1000)</script>";
    }
}
$status = 0;
$cmd = $con->prepare("SELECT nss_unit.id as nss_unit_id, nss_unit.description as description FROM tbl_nss_unit as nss_unit 
WHERE nss_unit.is_delete = ? AND nss_unit.id = ?");
$cmd->bind_param("ii",  $status, $nss_unit_id);
$cmd->execute();
$result = $cmd->get_result();

while ($row = $result->fetch_assoc()) {
    $nss_unit_id = $row['nss_unit_id'];
    $description = !empty($row['description']) ? $row['description'] : "<b>N/A</b>";
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
                            <h1 class="m-0">Edit NSS Units</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit NSS Units</li>

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
                                    <h3 class="card-title">Edit NSS Units</h3>
                                    <!-- <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3> -->
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" action="nss_unit_update.php" enctype="multipart/form-data">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <input type="hidden" name="nss_unit_id" value="<?php echo $nss_unit_id ?>">

                                        </div>
                                        <div class="form-group">
                                            <label for="text_editor">Description </label>
                                            <textarea id="text_editor" name="description"><?php echo htmlspecialchars_decode($description); ?></textarea>
                                        </div>
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