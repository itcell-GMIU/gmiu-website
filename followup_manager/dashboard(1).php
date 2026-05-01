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
    ?>
    <?php
    $stmtcmd = $con->prepare("SELECT pacid from tbl_pac_form where is_active=1 AND is_delete=0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $pac = $result->num_rows;
    ?>
     <?php
    $stmtcmd = $con->prepare("SELECT id from `tbl_branch_transfer_requests` where is_active=1 AND is_delete=0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $transfer = $result->num_rows;
    ?>
     <?php
    $stmtcmd = $con->prepare("SELECT id from tbl_inquiry_student where is_active=1 AND is_delete=0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $inquiry_students_count = $result->num_rows;
    ?>
       <?php
    //Cancellation Request
    $stmtcmd = $con->prepare("SELECT id from `tbl_cancellation_requests` where is_active=1 AND is_delete=0");
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
                        </div>
                    </div>
                </div>
            </div>

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
                                <a href="view_student.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                             <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo "$inquiry_students_count"; ?></h3>
                                    <p>Total Inquiry Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="student_list.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                         <div class="col-lg-3 col-6">
                             <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo "$pac"; ?></h3>
                                    <p>Total PAC Forms</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_pac.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo "$transfer"; ?></h3>
                                    <p>Total Branch Transfer Request</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_branch_request.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
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
                                <a href="view_cancellation_requests.php" class="small-box-footer">More
                                    info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                      
                </div>
            </section>
        </div>

        <!-- /.content-wrapper -->
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>

    <?php include 'include/importjs.php'; ?>
</body>

</html>