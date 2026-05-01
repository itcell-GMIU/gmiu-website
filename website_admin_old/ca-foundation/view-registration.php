<?php
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>
    <!-- /.header -->

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <!-- /.Preloader -->

    <!-- wrapper -->
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
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row mb-2">
                        <!-- col -->
                        <div class="col-sm-6">
                            <h1 class="m-0">CA Program Registration</h1>
                        </div><!-- /.col -->

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">CA Program Registration</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div> <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!-- container-fluid -->
                <div class="container-fluid">

                    <!-- card -->
                    <div class="card">
                        <!-- card-header -->
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i> CA Program Registration</b></h5>
                                </center>
                            </span>
                        </div> <!-- /.card-header -->

                        <!-- card-body -->
                        <div class="card-body">

                            <!-- table-responsive -->
                            <div class="table-responsive">

                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Full Name</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number</b></th>
                                            <th scope="row" style="color:black;"><b>District</b></th>
                                            <th scope="row" style="color:black;"><b>School</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>Timing Slot</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT * FROM tbl_ca_program_registration WHERE is_active = 1 AND is_deleted = 0");
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $row['id']; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $row['full_name']; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $row['mobile_number']; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $row['district']; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $row['school_name']; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $row['email_id']; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo ($row['preferred_timing_slot'] == 'sun-1-3' ? '1:00 PM - 3:00 PM' : '4:00 PM - 6:00 PM'); ?>
                                                </td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Full Name</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number</b></th>
                                            <th scope="row" style="color:black;"><b>District</b></th>
                                            <th scope="row" style="color:black;"><b>School</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>Timing Slot</b></th>
                                        </tr>
                                    </tfoot>

                                </table>

                            </div> <!-- /.table-responsive -->
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div><!-- /.container-fluid -->
            </section> <!-- /.content -->
        </div> <!-- /.content-wrapper -->

        <!-- footer -->
        <?php include '../include/importfooter.php'; ?>
        <!-- /.footer -->

    </div> <!-- ./wrapper -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>