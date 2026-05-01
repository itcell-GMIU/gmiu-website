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
                            <h1 class="m-0"> View FAQ Content</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active"> View FAQ Content</li>
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
                    <!--   Login Attempts View -->
                    <div class="card mb-3">
                        <div class="card">
                            <div class="card-header">
                                <center>
                                    <h5><b><i class="fas fa-user-shield"></i> View Login Attempts</b></h5>
                                </center>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="loginAttempts" class="dataTableLoad table table-bordered table-striped">
                                        <thead>
                                            <tr align="center">
                                                <th style="color:black;"><b>ID</b></th>
                                                <th style="color:black;"><b>Mobile Number</b></th>
                                                <th style="color:black;"><b>IP Address</b></th>
                                                <th style="color:black;"><b>User Agent</b></th>
                                                <th style="color:black;"><b>Referrer</b></th>
                                                <th style="color:black;"><b>Attempt Time</b></th>
                                                <th style="color:black;"><b>Status</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cmd = $con->prepare("SELECT `id`, `mobile_number`, `ip_address`, `user_agent`, `referrer`, `attempt_time`, `status` FROM `tbl_admission_login_attempts`");
                                            $cmd->execute();
                                            $result = $cmd->get_result();

                                            while ($row = $result->fetch_assoc()) {
                                                echo '<tr align="center">';
                                                echo '<td>' . $row['id'] . '</td>';
                                                echo '<td>' . htmlspecialchars($row['mobile_number']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['ip_address']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['user_agent']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['referrer']) . '</td>';
                                                echo '<td>' . $row['attempt_time'] . '</td>';
                                                $status_text = strtolower($row['status']) === 'success'
                                                        ? '<span class="badge badge-success">Success</span>'
                                                        : '<span class="badge badge-danger">Failed</span>';
                                                    
                                                    echo '<td>' . $status_text . '</td>';

                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr align="center">
                                                <th style="color:black;"><b>ID</b></th>
                                                <th style="color:black;"><b>Mobile Number</b></th>
                                                <th style="color:black;"><b>IP Address</b></th>
                                                <th style="color:black;"><b>User Agent</b></th>
                                                <th style="color:black;"><b>Referrer</b></th>
                                                <th style="color:black;"><b>Attempt Time</b></th>
                                                <th style="color:black;"><b>Status</b></th>
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