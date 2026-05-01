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
    <!-- /.login-logo -->
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
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <?php
                    if ($role_id == 1) {
                    ?>
                        <div class="card card-gmiu m-0">
                            <div class="card-header">
                                <div class="card-title">
                                    YOUTHFEST REGISTRATIONS
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped text-center">
                                        <thead>
                                            <tr align="center">
                                                <th>Sr.No.</th>
                                                <th>Name</th>
                                                <th>Competitions</th>
                                                <th>Contact No.</th>
                                                <th>Email</th>
                                                <th>Department</th>
                                                <th>Payment Status</th>
                                                <th>Payment Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $status = 1;
                                            $cmd2 = $con->prepare("SELECT * FROM `tbl_registers` WHERE `is_active` = ? AND payment_status = 'success'");
                                            $cmd2->bind_param("i", $status);
                                            $cmd2->execute();
                                            $result2 = $cmd2->get_result();
                                            $in = 1;
                                            while ($row2 = $result2->fetch_assoc()) {
                                                $id = $row2['id'];
                                                $competitions = $row2['competitions'];
                                            ?>
                                                <tr>
                                                    <td><?= $in ?></td>
                                                    <td><?= $row2['name'] ?></td>
                                                    <td class="text-nowrap text-left"><?php
                                                                            $comps = unserialize($row2['competitions']);

                                                                            foreach ($comps as $compid) {
                                                                                $crud->readSingleRecordColumn("tbl_competetion", "name", ["id" => $compid, "is_active" => 1], $compname);
                                                                                echo "⮞ " . $compname . "<br>";
                                                                            }
                                                                            ?></td>
                                                    <td><?= $row2['mobile'] ?></td>
                                                    <td><?= $row2['email'] ?></td>
                                                    <td><?= $row2['deptname'] ?></td>
                                                    <td><?= $row2['payment_status'] ?></td>
                                                    <td><?= $row2['payment_date'] ?></td>
                                                </tr>
                                            <?php
                                                $in++;
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <!-- /.row -->

                </div><!-- /.container-fluid -->
            </section>

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