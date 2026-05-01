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
                            <h1 class="m-0">View Testomonial List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Testomonial</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>View Testomonial</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="testimonial_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Testimonial Type</b></th>
                                            <th scope="row" style="color:black;"><b>Name</b></th>
                                            <th scope="row" style="color:black;"><b>File</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT testimonial.id as testimonial_id, testimonial.file as testimonial_file, testimonial.file_type as testimonial_filetype, testimonial.name as testimonial_name, testimonial.description as testimonial_description, testimonial.testimonial_type as testimonial_type
                                         FROM tbl_testimonial as testimonial  
                                            WHERE testimonial.is_delete = ?");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $testimonial_id = $row['testimonial_id'];
                                            $testimonial_file = !empty($row['testimonial_file']) ? $row['testimonial_file'] : "<b>N/A</b>";
                                            $testimonial_type = !empty($row['testimonial_type']) ? $row['testimonial_type'] : "<b>N/A</b>";
                                            $testimonial_name = !empty($row['testimonial_name']) ? $row['testimonial_name'] : "<b>N/A</b>";
                                            $testimonial_description = !empty($row['testimonial_description']) ? $row['testimonial_description'] : "<b>N/A</b>";

                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $testimonial_id; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $testimonial_type; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo htmlspecialchars_decode($testimonial_name) ; ?>
                                                </td>
                                                <td scope="row">
                                                    <a href='../uploads/testimonial/<?php echo $testimonial_file ?>' target="_blank">
                                                <img src="../uploads/testimonial/<?php echo $testimonial_file ?>" alt="" width="120px"></a>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $testimonial_description; ?>
                                                </td>

                                                <td scope="row">
                                                    <a href="testimonial_edit.php?testimonial_id=<?php echo $row['testimonial_id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                      <?php if($role_id == 11) { ?>
                                                    <a href="testimonial_delete.php?testimonial_id=<?php echo $row['testimonial_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Testimonial Type</b></th>
                                            <th scope="row" style="color:black;"><b>Name</b></th>
                                            <th scope="row" style="color:black;"><b>File</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
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