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
                            <h1 class="m-0">View GEPS</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View GEPS</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>View GEPS</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="about_geps_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Images</b></th>
                                            <th scope="row" style="color:black;"><b>Type</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;

                                        $cmd = $con->prepare("SELECT geps.id as geps_id, geps.type_id as type_id,geps.file_name as file_name,geps.file_type as file_type FROM tbl_site_photos as geps 
                                             WHERE geps.is_delete = ? AND geps.type_id = 100");
                                        $cmd->bind_param("i", $status);
 
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $geps_id = $row['geps_id'];
                                            // $type_id = !empty($row['type_id']) ? $row['type_id'] : "<b>N/A</b>";
                                            $file_name = !empty($row['file_name']) ? $row['file_name'] : "<b>N/A</b>";
                                            $file_type = !empty($row['file_type']) ? $row['file_type'] : "<b>N/A</b>";

                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $geps_id; 
                                                    ?>
                                                </td>

                                                <!-- <td scope="row">
                                                    <?php //echo $type_id; ?>
                                                </td> -->
                                                <td scope="row">
                                                    <a href="<?php echo "../uploads/geps/image/" . $file_name; ?>" target="_blank"><img src='<?php echo "../uploads/geps/image/" . $file_name; ?>' alt="" style="width: 200px;"></a>

                                                </td>

                                                <td scope="row">
                                                    <?php echo $file_type; ?>
                                                </td>


                                                <td scope="row">

                                                  <?php if($role_id == 11) { ?>

                                                    <a href="about_geps_delete.php?geps_id=<?php echo $row['geps_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    
                                                       <?php } ?>
                                                    
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Images</b></th>
                                            <th scope="row" style="color:black;"><b>Type</b></th>

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