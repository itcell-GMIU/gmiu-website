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
    $stmtcmd = $con->prepare("SELECT id from tbl_admission_student Where is_active=1 AND is_delete=0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $registered_students_count = $result->num_rows;

   
    //payment pending count
    $stmt = $con->prepare("SELECT payment_status from tbl_admission_student where payment_status!='success' and account_office_status!='approved' AND is_active=1 AND is_delete=0");
    $stmt->execute();
    $result = $stmt->get_result();
    $payment_pending_students_count = $result->num_rows;

    //payment completed count
    $stmt = $con->prepare("SELECT payment_status from tbl_admission_student where payment_status='success' AND account_office_status='approved' AND is_active=1 AND is_delete=0");
    $stmt->execute();
    $result = $stmt->get_result();
    $payment_completed_students_count = $result->num_rows;

    //cluster pending student
    $stmt = $con->prepare("SELECT status from tbl_admission_student where status!='rejected' AND status!='approved' AND is_active=1 AND is_delete=0");
    $stmt->execute();
    $result = $stmt->get_result();
    $cluster_pending_students_count = $result->num_rows;

    //cluster approved student
    $stmtcmd = $con->prepare("SELECT status from tbl_admission_student where status='approved' AND is_active=1 AND is_delete=0");
    $stmtcmd->execute();
    $student_result = $stmtcmd->get_result();
    $cluster_approved_students_count = $student_result->num_rows;
    
    //cluster rejected student
    $stmt = $con->prepare("SELECT status from tbl_admission_student where status='rejected' AND is_active=1 AND is_delete=0");
    $stmt->execute();
    $result = $stmt->get_result();
    $cluster_rejected_students_count = $result->num_rows;

    //admission pending student
    $stmt = $con->prepare("SELECT admission_status from tbl_admission_student where admission_status!='rejected' AND admission_status!='approved' AND is_active=1 AND is_delete=0");
    $stmt->execute();
    $result = $stmt->get_result();
    $admission_pending_students_count = $result->num_rows;

    //admission rejected student
    $stmt = $con->prepare("SELECT admission_status from tbl_admission_student where admission_status='rejected' AND is_active=1 AND is_delete=0");
    $stmt->execute();
    $result = $stmt->get_result();
    $admission_rejected_students_count = $result->num_rows;

    //admission approved student 
    $stmt = $con->prepare("SELECT admission_status from tbl_admission_student where admission_status='approved' AND is_active=1 AND is_delete=0");
    $stmt->execute();
    $result = $stmt->get_result();
    $admission_approved_students_count = $result->num_rows;

    
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
                                    <h3><?php echo "$cluster_pending_students_count"; ?></h3>

                                    <p>Cluster Pending Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=cluster_pending_student" class="small-box-footer">More
                                    info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?php echo "$cluster_approved_students_count"; ?>
                                        <!-- <sup style="font-size: 20px">%</sup> -->
                                    </h3>

                                    <p>Cluster Approved Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=cluster_approved_student"
                                    class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->

                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo "$cluster_rejected_students_count"; ?></h3>

                                    <p>Cluster Rejected Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=cluster_rejected_student"
                                    class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?php echo "$admission_pending_students_count"; ?></h3>

                                    <p>Admission Pending Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=admission_pending_student"
                                    class="small-box-footer">More
                                    info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?php echo "$admission_approved_students_count"; ?>
                                        <!-- <sup style="font-size: 20px">%</sup> -->
                                    </h3>

                                    <p>Admission Approved Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=admission_approved_student"
                                    class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->

                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo "$admission_rejected_students_count"; ?></h3>

                                    <p>Admission Rejected Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=admission_rejected_student"
                                    class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?php echo "$payment_pending_students_count"; ?></h3>

                                    <p>Payment Pending Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=payment_pending" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?php echo "$payment_completed_students_count"; ?>
                                        <!-- <sup style="font-size: 20px">%</sup> -->
                                    </h3>

                                    <p>Payment Completed students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php?url_for=payment_completed" class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i></a>
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