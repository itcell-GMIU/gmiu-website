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
                            <h1 class="m-0">Virtual Counselling Registration</h1>
                        </div><!-- /.col -->

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Virtual Counselling Registration</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i> Virtual Counselling Registration</b></h5>
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
                                            <th scope="row" style="color:black;"><b>#</b></th>
                                            <th scope="row" style="color:black;"><b>Full Name</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty</b></th>
                                            <th scope="row" style="color:black;"><b>Extra</b></th>
                                            <th scope="row" style="color:black;"><b>Date</b></th>
                                            <th scope="row" style="color:black;"><b>Timing Slot</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch CA Program registrations from the new table
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT 
                                                tpfd.id, tpfd.full_name, tpfd.mobile, tpfd.email, tpfd.start_date, tpfd.description, tpfd.time_slot, tf.name as faculty_name 
                                            FROM tbl_promotional_form_data AS tpfd JOIN tbl_faculty AS tf ON tpfd.faculty_id = tf.id
                                            WHERE form_type = 3
                                            ORDER BY id DESC
                                        ");
                                        $cmd->execute();
                                        $result = $cmd->get_result();

                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr align="center">
                                                <td scope="row"><?php echo $row['id']; ?></td>
                                                <td scope="row"><?php echo $row['full_name']; ?></td>
                                                <td scope="row"><?php echo $row['mobile']; ?></td>
                                                <td scope="row"><?php echo $row['email']; ?></td>
                                                <td scope="row"><?php echo $row['faculty_name']; ?></td>
                                                <td scope="row"><?php echo $row['description']; ?></td>
                                                <td scope="row">
                                                    <?php
                                                    echo date("d M Y", strtotime($row['start_date']));
                                                    ?>
                                                </td>
                                                <td scope="row"><?php echo $row['time_slot']; ?></td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>

                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>#</b></th>
                                            <th scope="row" style="color:black;"><b>Full Name</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty</b></th>
                                            <th scope="row" style="color:black;"><b>Extra</b></th>
                                            <th scope="row" style="color:black;"><b>Date</b></th>
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