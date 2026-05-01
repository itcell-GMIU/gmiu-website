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
                            <h1 class="m-0">View Iksve Cell List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Iksve Cell</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- International Cell list code -->

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-globe"></i> View Iksve Cell</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="activities_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="iksve_cell" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Name</b></th>
                                            <th scope="row" style="color:black;"><b>Type</b></th>
                                            <th scope="row" style="color:black;"><b>Image</b></th>
                                            <th scope="row" style="color:black;"><b>Date</b></th>
                                            <th scope="row" style="color:black;"><b>Participants</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT * FROM tbl_iksve_cell WHERE is_delete = ?");
                                        $cmd->bind_param("i", $status); // type_id should be passed as a parameter
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $type = '';
                                            // Determine the type based on type_id
                                            switch ($row['type_id']) {
                                                case 1:
                                                   $type ="FDP";
                                                    break;
                                                case 2:
                                                    $type ="SDP";
                                                    break;
                                                case 3:
                                                     $type ="Workshops&Seminars";
                                                    break;
                                                case 4:
                                                     $type ="Other Activities";
                                                     break;
                                                default:
                                                   $type ="<b>Unknown</b>";
                                                    break;
                                                    
                                                }
                                            
                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $row['id']; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $row['name']; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $type ; ?> <!-- Display the type here -->
                                                </td>

                                                <td scope="row">
                                                    <a href="<?php echo "../uploads/iksve_cell/" . $row['img_name']; ?>" target="_blank">
                                                        <img src='<?php echo "../uploads/iksve_cell/" . $row['img_name']; ?>' alt="" style="width: 200px;">
                                                    </a>
                                                </td>
                                                <td scope="row">
                                                    <?php echo  $row['date']; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $row['participants']; ?>
                                                </td>



                                                <td scope="row">
                                                    <a href="activities_edit.php?ic_id=<?php echo $row['id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="activities_delete.php?ic_id=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>


                                        <?php } ?>


                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Name</b></th>
                                            <th scope="row" style="color:black;"><b>Type</b></th>
                                            <th scope="row" style="color:black;"><b>Image</b></th>
                                            <th scope="row" style="color:black;"><b>Date</b></th>
                                            <th scope="row" style="color:black;"><b>Participants</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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