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
                            <h1 class="m-0">View Training and Placement List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Training and Placement</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i> View Training and Placement</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- + ADD Button  -->
                                <a class="btn btn-primary" style="margin-left: 90%;" href="training_and_placement_insert.php"><i
                                        class="fa-solid fa-plus"></i> Add</a>
                                <!-- + ADD Button End -->
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Name</b></th>
                                            <th scope="row" style="color:black;"><b>Department</b></th>
                                            <th scope="row" style="color:black;"><b>Image</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $status = 0;
                                            $cmd = $con->prepare("SELECT training.id as id,training.name as name ,training.department as department ,training.img_name as img_name FROM tbl_tpa_coordinator as training WHERE training.is_delete = ?");
                                            $cmd->bind_param("i", $status);
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $id = $row['id'];
                                                $name = !empty($row['name']) ? $row['name'] : "<b>N/A</b>";
                                                $department = !empty($row['department']) ? $row['department'] : "<b>N/A</b>";
                                                $img_name = !empty($row['img_name']) ? $row['img_name'] : "<b>N/A</b>";
                                               
  
                                                // $faculty_is_active = $row['faculty_is_active'];
                                            ?>
                                        <tr align="center">
                                            <td scope="row">
                                                <?php echo $id; ?>
                                            </td>

                                            <td scope="row">
                                                <?php echo $name; ?>
                                            </td>

                                            <td scope="row">
                                                <?php echo $department; ?>
                                            </td>


                                            <td scope="row">
                                                <a href="<?php echo "../uploads/training_and_placement/" . "$img_name"; ?>" target="_blank"><img
                                                        src="<?php echo "../uploads/training_and_placement/" . "$img_name"; ?>" alt=""
                                                        style="width: 100px;"></a>

                                               

                                            </td>

                                            <td scope="row">
                                                <a href="training_and_placement_edit.php?id=<?php echo $row['id'] ?>"
                                                    class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                      <?php if($role_id == 11) { ?>
                                                <a href="training_and_placement_delete.php?id=<?php echo $row['id'] ?>"
                                                    class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <?php } ?>
                                            </td>
                                        </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                        <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Name</b></th>
                                            <th scope="row" style="color:black;"><b>Department</b></th>
                                            <th scope="row" style="color:black;"><b>Image</b></th>
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