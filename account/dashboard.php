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

    $stmtcmd = $con->prepare("SELECT id from tbl_admission_student where is_active=1 AND is_delete=0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $registered_students_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT payment_mode from tbl_admission_student where payment_mode='online' AND is_active=1 AND is_delete=0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $payment_online_count = $result->num_rows;

    $stmt = $con->prepare("SELECT 	payment_mode from tbl_admission_student where payment_mode='offline' AND is_active=1 AND is_delete=0");
    $stmt->execute();
    $result = $stmt->get_result();
    $payment_offline_count = $result->num_rows;
    
    $stmt = $con->prepare("SELECT account_office_status from tbl_admission_student where account_office_status='approved' AND is_active=1 AND is_delete=0");
    $stmt->execute();
    $result = $stmt->get_result();
    $account_approved_students_count = $result->num_rows;

    $stmt = $con->prepare("SELECT account_office_status from tbl_admission_student where  account_office_status='rejected' AND is_active=1 AND is_delete=0");
    $stmt->execute();
    $result = $stmt->get_result();
    $account_rejected_students_count = $result->num_rows;
    
    $stmt = $con->prepare("SELECT account_office_status from tbl_admission_student where  (account_office_status='pending' OR account_office_status='submitted') AND is_active=1 AND is_delete=0");
    $stmt->execute();
    $result = $stmt->get_result();
    $account_pending_students_count = $result->num_rows;
    
    $stmtcmd = $con->prepare("SELECT id from `tbl_branch_transfer_requests` where is_active=1 AND is_delete=0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $transfer = $result->num_rows;
    
    //Cancellation Request
    $stmtcmd = $con->prepare("SELECT id from `tbl_cancellation_requests` where is_active=1 AND is_delete=0 AND cluster_status = 'approved'");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $cancellation = $result->num_rows;
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

                                    <p>Total Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=all" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?php echo "$account_pending_students_count"; ?>
                                        <!-- <sup style="font-size: 20px">%</sup> -->
                                    </h3>

                                    <p>Pending Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=account_office_status_pending"
                                    class="small-box-footer">More
                                    info
                                    <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?php echo "$account_approved_students_count"; ?>
                                        <!-- <sup style="font-size: 20px">%</sup> -->
                                    </h3>

                                    <p>Approved Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=account_office_status_approved"
                                    class="small-box-footer">More
                                    info
                                    <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo "$transfer"; ?></h3>
                                    <p>Branch Transfer Request</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_branch_request.php" class="small-box-footer">More
                                    info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                         <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo "$cancellation"; ?></h3>
                                    <p>Cancellation Request</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_cancellation_request.php" class="small-box-footer">More
                                    info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo "$account_rejected_students_count"; ?></h3>

                                    <p>Rejected Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=account_office_status_rejected"
                                    class="small-box-footer">More
                                    info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?php echo "$payment_online_count"; ?></h3>

                                    <p>Payment Online</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=payment_online" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo "$payment_offline_count"; ?></h3>

                                    <p>Payment Offline</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=payment_offline" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                                                <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <?php
                                    $id_count2 = $con->query("SELECT id FROM tbl_exam_student WHERE status = 3");
                                    $std_success_count = mysqli_num_rows($id_count2);
                                    ?>
                                    <h3><?= $std_success_count ?></h3>
                                    <p>Exam Form Report</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-document"></i>
                                </div>
                                <a href="examformPayments.php" class="small-box-footer">More
                                    info <i class="fas fa-arrow-circle-right"></i></a>
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