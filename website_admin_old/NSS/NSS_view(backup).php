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
                            <h1 class="m-0">View NSS List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View NSS</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i> View NSS</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- + ADD Button  -->
                                <a class="btn btn-primary" style="margin-left: 90%;" href="NSS_insert.php"><i
                                        class="fa-solid fa-plus"></i> Add</a>
                                <!-- + ADD Button End -->
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                        <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Report Thumbnail</b></th>
                                            <th scope="row" style="color:black;"><b>Report</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $status = 0;
                                            $cmd = $con->prepare("SELECT NSS.id as NSS_id, NSS.report_title as NSS_title,NSS.report as report,NSS.report_thumbnail as report_thumbnail FROM tbl_NSS as NSS  
                                           WHERE NSS.is_delete = ?");
                                            $cmd->bind_param("i", $status);
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $NSS_id = $row['NSS_id'];
                                                $NSS_title = !empty($row['NSS_title']) ? $row['NSS_title'] : "<b>N/A</b>";
                                                $report_thumbnail = !empty($row['report_thumbnail']) ? $row['report_thumbnail'] : "<b>N/A</b>";
                                                $report = !empty($row['report']) ? $row['report'] : "<b>N/A</b>";
                                                // $faculty_is_active = $row['faculty_is_active'];
                                            ?>
                                        <tr align="center">
                                            <td scope="row">
                                                <?php echo $NSS_id; ?>
                                            </td>

                                            <td scope="row">
                                                <?php echo $NSS_title; ?>
                                            </td>
                                          
                                            <td scope="row">
                                                <a href="<?php echo "../uploads/NSS/report_thumbnail/" . "$report_thumbnail"; ?>" target="_blank"><img
                                                        src="<?php echo "../uploads/NSS/report_thumbnail/" . "$report_thumbnail"; ?>" alt=""
                                                        style="width: 200px;"></a>
                                            </td>
                                            <td scope="row">
                                                <a href="<?php echo "../uploads/NSS/report/" . "$report"; ?>" target="_blank"> <?php echo $report;?></a>
                                            </td>
                                            <td scope="row">
                                                <a href="NSS_delete.php?NSS_id=<?php echo $row['NSS_id'] ?>"
                                                    class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Report Thumbnail</b></th>
                                            <th scope="row" style="color:black;"><b>Report</b></th>
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