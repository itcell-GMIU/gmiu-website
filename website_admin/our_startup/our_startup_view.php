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
                            <h1 class="m-0">View Our Startup</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Our Startup</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>View Our Startup</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="our_startup_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Images</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;

                                        $cmd = $con->prepare("SELECT startup.id as startup_id, startup.title as title FROM tbl_our_startup as startup WHERE startup.is_delete = ?");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row_startup = $result->fetch_assoc()) {
                                            $startup_id = $row_startup['startup_id'];
                                            $title = !empty($row_startup['title']) ? $row_startup['title'] : "<b>N/A</b>";
                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $startup_id; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $title; ?>
                                                </td>


                                                <td scope="row" style="max-width:300px; overflow-x:scroll; display:flex;">
                                                <?php
                                                // Fetch images for each startup
                                                $status = 0;
                                                $type = "Startup";
                                                $cmd = $con->prepare("SELECT photos.file_name as file_name  FROM `tbl_site_photos` as photos  where  photos.type = ? and photos.type_id = ?");
                                                $cmd->bind_param("si", $type, $startup_id);
                                                $cmd->execute();
                                                $result2 = $cmd->get_result();
                                                while ($row = $result2->fetch_assoc()) {
                                                    $file_name  = !empty($row['file_name']) ? $row['file_name'] : "<b>N/A</b>";
                                                ?>

                                                        <a href="<?php echo "../uploads/our_startup/image/" . $file_name; ?>" target="_blank">
                                                            <img src='<?php echo "../uploads/our_startup/image/" . $file_name; ?>' alt="" style="height: 200px; width:300px;">
                                                        </a>
                                                        <?php } ?>
                                                    </td>

                                                        <td scope="row">
                                                    <a href="our_startup_edit.php?startup_id=<?php echo $startup_id; ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                      <?php if($role_id == 11) { ?>
                                                    <a href="our_startup_delete.php?startup_id=<?php echo $startup_id; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        <?php
                                            // end of inner loop
                                        } // end of outer loop
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Images</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>

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