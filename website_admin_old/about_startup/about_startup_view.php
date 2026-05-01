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
                            <h1 class="m-0">View About Startup List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View About Startup</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i> View About Startup</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- + ADD Button  -->
                                <a class="btn btn-primary" style="margin-left: 90%;" href="about_startup_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                                <!-- + ADD Button End -->
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Discription</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT about_startup.id as about_startup_id, about_startup.description as description FROM tbl_about_startup as about_startup 
                                       WHERE about_startup.is_delete = ?");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();

                                        while ($row = $result->fetch_assoc()) {
                                            $about_startup_id = $row['about_startup_id'];
                                            $description = !empty($row['description']) ? $row['description'] : "<b>N/A</b>";
                                            // Your code to handle each row's data goes here


                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $about_startup_id  ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $description ?>
                                                </td>

                                                <td scope="row">
                                                    <a href="about_startup_edit.php?about_startup_id=<?php echo $row['about_startup_id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    
                                                      <?php if($role_id == 11) { ?>
                                                    
                                                    <a href="about_startup_delete.php?about_startup_id=<?php echo $row['about_startup_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    
                                                    <?php } ?>
                                                    
                                                </td>

                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Discription</b></th>
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