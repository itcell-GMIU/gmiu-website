<?php
include './include/checklogin.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>

    <?php

    $stmtcmd = $con->prepare("SELECT id from tbl_runtime_query where is_active=1 AND is_delete=0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $registered_students_count = $result->num_rows;

$stmtcmd1 = $con->prepare("SELECT id from tbl_runtime_query where is_active=1 AND is_delete=0 AND status='pending'");
    $stmtcmd1->execute();
    $result1 = $stmtcmd1->get_result();
    $pending_count = $result1->num_rows;
    
    $stmtcmd2 = $con->prepare("SELECT id from tbl_runtime_query where is_active=1 AND is_delete=0 AND status='approved'");
    $stmtcmd2->execute();
    $result2 = $stmtcmd2->get_result();
    $approved_count = $result2->num_rows;
    
        $stmtcmd3 = $con->prepare("SELECT id from tbl_runtime_query where is_active=1 AND is_delete=0 AND status='rejected'");
    $stmtcmd3->execute();
    $result3 = $stmtcmd3->get_result();
    $rejected_count = $result3->num_rows;
    ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">



        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

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

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo "$registered_students_count"; ?></h3>

                                    <p>Total Student Query</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="users.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                            
                             <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo "$pending_count"; ?></h3>

                                    <p>Pending Query</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="users.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                             <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo "$approved_count"; ?></h3>

                                    <p>Approved Query</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="users.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                             <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo "$rejected_count"; ?></h3>

                                    <p>Rejected Query</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="users.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- ./col -->
                    </div>
                    <!-- /.row -->

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include 'include/importjs.php'; ?>
</body>

</html>