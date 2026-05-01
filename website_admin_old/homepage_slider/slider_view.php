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
                            <h1 class="m-0">View Slider image</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Slider image</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!--   Faculty list code  -->

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>View Slider image</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="slider_insert.php"><i
                                    class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Slider Image</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $type="slider_image";
                                        $cmd = $con->prepare("SELECT tbl_site_photos.id as tbl_site_photos_id, tbl_site_photos.file_name as tbl_site_photos_file, tbl_site_photos.file_type as tbl_site_photos_filetype FROM tbl_site_photos as tbl_site_photos 
                                            WHERE tbl_site_photos.type=? AND tbl_site_photos.is_delete = ?");
                                        $cmd->bind_param("si",$type, $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $tbl_site_photos_id = $row['tbl_site_photos_id'];
                                            $tbl_site_photos_file = !empty($row['tbl_site_photos_file']) ? $row['tbl_site_photos_file'] : "<b>N/A</b>";

                                        ?>
                                        <tr align="center">
                                            <td scope="row">
                                                <?php echo $tbl_site_photos_id; ?>
                                            </td>

                                            <td scope="row">
                                                <a href='../uploads/slider_image/<?php echo $tbl_site_photos_file; ?>'
                                                    target="_blank"><img
                                                        src="../uploads/slider_image/<?php echo $tbl_site_photos_file; ?>"
                                                        alt="" style="width: 200px;"></a>

                                            </td>



                                            <td scope="row">
                                            <?php if($role_id == 11  OR $role_id == 10) { ?>
                                                <a href="slider_delete.php?tbl_site_photos_file_id=<?php echo $row['tbl_site_photos_id'] ?>"
                                                    class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                            <?php } ?>
                                            </td>
                                        </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Slider Image</b></th>

                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-body -->
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